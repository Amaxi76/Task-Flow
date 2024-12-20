<?php 
namespace App\Controllers;

use App\Models\Utilisateurs\InscriptionsModele; 
use App\Models\Utilisateurs\JetonsModele;
use App\Models\Utilisateurs\PersonneModele;
use App\Models\Utilisateurs\SessionUtilisateur; 

//FIXME: ne plus utiliser "session()" mais plutot passer par SessionUtilisateur
class InscriptionControleur extends BaseController { 
	private const TEMPS_EXPIRATION = '+10 minutes';
	private SessionUtilisateur $session;

	public function __construct() {
		$this->session = new SessionUtilisateur();
	}

	public function index(): string {
		helper(['form']);
		return view('inscription/inscriptionVue');
	}

	/**
	 * Vérifie que les champs rentrés sont valides et inscrit l'utilisateur dans la table personne et inscription.
	*/
	public function inscription(){
		$validation = $this->getRegleEtMessageInscription();
		$estValide  = $this->validate($validation['regles'],$validation['messageErreur']);

		$email       = $this->request->getVar('email');

		$erreurs = [];
		
		if($estValide){
			$email       = $this->request->getVar('email');
			$nom         = $this->request->getVar( 'nom' ); 
			$mdp         = $this->request->getVar( 'mdp' );

			$idPersonne  = $this->creationPersonne($email,$nom,$mdp); //insertion d'une personne dans la table Personne et récupération de l'id
			$idJeton     = $this->creationJetonActivation(); //insertion d'un jeton dans la table jeton et récupération de l'id 

			if(isset($idPersonne) && isset($idJeton)) {
				$inscriptionModele = new InscriptionsModele();
				$inscriptionModele->insert(['id_personne' => $idPersonne, 'id_jeton' => $idJeton]); //insertion dans la table inscription

				$jetonModele = new JetonsModele();
			
				$estEnvoye = $this->envoyerMailActivation($email,$jetonModele->recupererJeton($idJeton));

				if($estEnvoye) 
				{
					session()->set('email', $email);
					session()->set('id_personne', strval($idPersonne));
					session()->set('id_jeton'   , strval($idJeton));
					return redirect()->to('inscription/mailenvoye');
				}
				$erreurs = ["Mail pas envoyé"];
			}
			else
			{
				$erreurs['email'] = "L'adresse email est déjà enregistrée";
			}
		}
		else{
			$erreurs = $this->validator->getErrors();
		}

		$data = 
		[
			'erreur' => $erreurs
		];
		helper(['form']);
		echo view('inscription/inscriptionVue',$data); //renvoie vers inscription avec message d'erreur
	}

	/**
	 * Insert dans la table Personne 
	 *
	 * @param string $email email de la personne
	 * @param string $nom   nom de la personnes
	 * @param string $mdp   mot de passe de la personne
	 * @return int id de la personne qui vient d'être insérer
	 */
	public function creationPersonne($email,$nom,$mdp){
		$personneModele = new PersonneModele();
		$personne       = $personneModele->where('email',$email)->first();
		
		if($personne) return null;

		$personne = [
			'email' => $email,
			'nom'   => $nom,
			'mdp'   => password_hash($mdp,PASSWORD_DEFAULT)
		];

		return $personneModele->insert($personne);
	}

	/**
	 * Crée et insert un nouveau jeton
	 */
	public function creationJetonActivation(){
		$jetonModele = new JetonsModele();
		$jeton = [
			'jeton'      => bin2hex(random_bytes(8)),
			'expiration' => date   ('Y-m-d H:i:s',strtotime(self::TEMPS_EXPIRATION))
		];

		return $jetonModele->insert($jeton);
	}

	public function envoyerMailActivation($email, $jetons){
		$activationLien = base_url("inscription/activationCompte/$jetons");
		
		// Préparer les données pour la vue
		$data = ['activationLien' => $activationLien];
		
		// Générer le contenu HTML en utilisant view()
		$message = view('email/activationMail', $data);

		$emailService = \Config\Services::email();
		$emailService->setTo      ($email);
		$emailService->setFrom    ($emailService->SMTPUser);
		$emailService->setSubject ('[noreply] Confirmation d\'inscription');
		$emailService->setMessage ($message);
		$emailService->setMailType('html');

		return $emailService->send(false);
	}

	public function afficherMailEnvoye()
	{
		$data = ['email' => session()->get('email'),'id_personne' => session()->get('id_personne'), 'id_jeton' => session()->get('id_jeton')];

		helper   (['form']);
		echo view('/commun/envoieMailVue',$data);
	}
	
	public function resetProcedure()
	{
		$id_jeton    = $this->request->getVar('id_jeton'   );
		$email       = $this->request->getVar('email'      );

		$jetonModele = new JetonsModele();
		
		$jetons = $jetonModele->recupererJeton($id_jeton);

		if($jetons)
		{
			$estEnvoye = $this->envoyerMailActivation($email,$jetons);

			$data = ['email' => session()->get('email'),'id_personne' => session()->get('id_personne'), 'id_jeton' => session()->get('id_jeton')];

			helper   (['form']);
			echo view('/commun/envoieMailVue',$data);
		}
		else
		{
			return redirect()->to('inscription/jeton_expire');
		}
	}

	public function jetonExpire()
	{
		helper(['form']);
		return view('commun/jetonExpireVue');
	}

	public function annulerInscription($id_personne,$id_jeton)
	{
		$inscriptionModele = new InscriptionsModele();
		$inscriptionModele->delete($id_personne);

		$jetonModele = new JetonsModele();
		$jetonModele->delete($id_jeton);

		$personneModele = new PersonneModele();
		$personneModele->delete($id_personne);
	}
	/**
	 * Retourne les règles et les messages d'erreurs associés pour les champs d'inscriptions.
	 * @return array tableau contenant les règles et les messages d'erreurs associés
	 */
	private function getRegleEtMessageInscription(){
		return [
			'regles' => [
				'email'        => 'required|valid_email',
				'nom'          => 'required|min_length[3]|max_length[50]',
				'mdp'          => 'required|min_length[4]',
				'confirmerMdp' => 'required|matches[mdp]'
			],
			'messageErreur' => [
				'email' => [
					'required'    => 'L\'adresse email est obligatoire.',
					'valid_email' => 'Veuillez entrer une adresse email valide.'
				],
				'nom' => [
					'required'    => 'Le nom est obligatoire.',
					'min_length'  => 'Le nom doit contenir au moins 3 caractères.',
					'max_length'  => 'Le nom ne peut pas dépasser 50 caractères.'
				],
				'mdp' => [
					'required'   => 'Le mot de passe est obligatoire.',
					'min_length' => 'Le mot de passe doit contenir au moins 4 caractères.'
				],
				'confirmerMdp' => [
					'required' => 'La confirmation du mot de passe est obligatoire.',
					'matches'  => 'La confirmation du mot de passe ne correspond pas au mot de passe saisi.'
				]
			]
		];
	}
} 