<?php 
namespace App\Controllers; 
use App\Models\Utilisateurs\InscriptionsModele; 
use App\Models\Utilisateurs\JetonsModele;
use App\Models\Utilisateurs\PersonneModele; 

class InscriptionControleur extends BaseController { 
	private const TEMPS_EXPIRATION = '+1 hour'; //TODO:A voir si on peut pas mettre un int plutôt

	public function index() { 
		helper(['form']);
		return view('inscription/inscriptionVue'); //TODO: changer en fonction du nom de la vue
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

				if($estEnvoye) return view('succes');
				
				$erreurs = ["Mail pas envoyé"];
			}
		}
		else{
			$erreurs = $this->validator->getErrors();
		}

		helper(['form']); 	
		return view('inscription/inscriptionVue',$erreurs); //renvoie vers inscription avec message d'erreur

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
		$activationLien = site_url("/inscription/activationCompte/$jetons");
		$message        = "Cliquez sur le lien pour activer votre compte : $activationLien";

		$emailService = \Config\Services::email();
		$emailService->setTo($email);
		$emailService->setFrom($emailService->SMTPUser);
		$emailService->setSubject('[noreply] Confirmation d\'inscription');
		$emailService->setMessage($message);

		return $emailService->send(false);
	}

	/**
	 * Retourne les règles et les messages d'erreurs associés pour les champs d'inscriptions.
	 * @return array tableau contenant les règles et les messages d'erreurs associés
	 */
	private function getRegleEtMessageInscription(){
		return [
			'regles' => [
				'email'        => 'required|valid_email',
				'nom'          => 'required|alpha_space|min_length[3]|max_length[50]',
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
					'alpha_space' => 'Le nom ne peut contenir que des lettres et des espaces.',
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