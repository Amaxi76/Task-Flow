<?php 
namespace App\Controllers; 
use App\Models\Utilisateurs\InscriptionsModele; 
use App\Models\Utilisateurs\JetonsModele;
use App\Models\Utilisateurs\PersonneModele; 

class InscriptionControleur extends BaseController { 
	private const TEMPS_EXPIRATION = '+2 hour'; //TODO:A voir si on peut pas mettre un int plutôt

	public function index() { 
		helper(['form']);
		echo view('commun/entete');
		echo view('inscription/inscriptionVue'); //TODO: changer en fonction du nom de la vue
		echo view('commun/piedpage');
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
					session()->set('id_personne',$idPersonne);
					session()->set('id_personne',$idJeton   );
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
		echo view('commun/entete');
		echo view('inscription/inscriptionVue',$data); //renvoie vers inscription avec message d'erreur
		echo view('commun/piedpage');
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
			'expiration' => date   ('Y-m-d H:i:s',strtotime(self::TEMPS_EXPIRATION)) //TODO:voir pour le temps
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
		helper(['form']);
		echo view('commun/entete');
		echo view('/commun/envoieMailVue',['email' => session()->get('email_activation')]);
		echo view('commun/piedpage');
	}
	
	public function resetProcedure($email)
	{
		dd("je suis la");
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