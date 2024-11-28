<?php 
namespace App\Controllers; 
use App\Models\Utilisateurs\JetonsModele;
use App\Models\Utilisateurs\UtilisateurModele;
use App\Models\Utilisateurs\UtilisateurModeleModele; 
use App\Models\Utilisateurs\PersonneModele; 

class ConnexionControleur extends BaseController 
{ 
	private const TEMPS_EXPIRATION = '+1 hour'; //TODO:A voir si on peut pas mettre un int plutôt

	public function index()
	{
		helper(['form']);
		echo view('commun/entete');
		echo view('connexion/connexionVue');
		echo view('commun/piedpage');
	}

	public function connexion(){
		helper(['cookie']);

		$email         = $this->request->getVar("email");
		$mdpFormulaire = $this->request->getVar("mdp"  );
		$seSouvenir    = $this->request->getVar("seSouvenir"  );
		
		$utilisateur = $this->verifieExistance($email);

		if($utilisateur)
		{
			$mdpPersonne = $utilisateur['mdp'];
			$mdpCorrect = password_verify($mdpFormulaire, $mdpPersonne);

			if($mdpCorrect)
			{
				$jetons_seSouvenir = null;
				if($seSouvenir){
					$jetons_seSouvenir = $this->seSouvenirDeMoi($utilisateur['id']);
					set_cookie("seSouvenir",$jetons_seSouvenir);
				}

				$donnee_session = [
					'id' => $utilisateur['id'],
					'estConnecte' => TRUE,
				];
				$session = session();
				$session->set($donnee_session);
				return redirect()->to('/taches');
			}
			else
			{
				$erreurs['mdp'] = "Le mot de passe est incorrect";
				return redirect()->to('connexion')
								->withInput() // Ne renvoie que l'email
								->with('erreurs', $erreurs);
			}
		}
		else
		{
			$erreurs['email'] = "Cette adresse mail n'existe pas ou n'est pas activée";
			return redirect()->to('connexion')
							->withInput() // Ne renvoie que l'email
							->with('erreurs', $erreurs);
		}
	}

	public function deconnexion()
	{
		// Démarrer la session
		$session = session();

		// Modèles
		$utilisateurModele = new UtilisateurModele();
		$jetonModele       = new JetonsModele();

		// Récupérer l'utilisateur actuel
		$utilisateur = $utilisateurModele->where("id_personne", $session->get('id'))->first();

		// Vérifier si l'utilisateur a un jeton de souvenir
		if ($utilisateur && !empty($utilisateur['id_jeton_sesouvenir'])) {
			// Vérifier si le cookie "seSouvenir" existe
			$cookie = get_cookie('seSouvenir');
			if ($cookie) {
				// Supprimer le jeton associé au cookie
				$jetonModele->delete($utilisateur['id_jeton_sesouvenir']);
				// Mettre à jour l'utilisateur pour supprimer l'ID du jeton
				$utilisateurModele->update($utilisateur['id_personne'], ['id_jeton_sesouvenir' => null]);
			}
		}

		// Supprimer toutes les données de session
		$session->destroy();

		// Supprimer le cookie "seSouvenir" si nécessaire
		delete_cookie('seSouvenir');

		// Rediriger l'utilisateur vers la page de connexion
		return redirect()->to('connexion')->with('message', 'Vous êtes déconnecté avec succès.');
	}

	public function seSouvenirDeMoi($idPersonne)
	{
		//creation jeton
		$jetonModele = new JetonsModele();

		$genererJetons = bin2hex(random_bytes(8));
		$jeton_seSouvenir = 
		[
			'jeton'      => $genererJetons,
			'expiration' => date('Y-m-d H:i:s',strtotime('+30 days'))
		];

		$idJetons_seSouvenir = $jetonModele->insert($jeton_seSouvenir);

		$utilisateurModele    = new UtilisateurModele();
		$ajoutJetonSeSouvenir = ['id_jeton_sesouvenir' => $idJetons_seSouvenir];

		$utilisateurModele->update($idPersonne,$ajoutJetonSeSouvenir);

		return $genererJetons;

	}

	public function verifieExistance($email)
	{
		$personneModele = new PersonneModele();
		$personne       = $personneModele->where("email",$email)->first();
		$infoPersonne   = null;
		
		if($personne)
		{
			$idPersonne  = $personne['id' ];
			$mdpPersonne = $personne['mdp'];

			$infoPersonne = 
			[
				"id"  => $idPersonne,
				"mdp" => $mdpPersonne
			];
		}
		return $infoPersonne;
	}

	public function envoiMailMdpOublie()
	{
		$email = $this->request->getVar("email");

		$personne   = $this->verifieExistance           ($email);
		$jeton      = $this->creerJetonsReinitialisation($email);

		if(!$personne)
		{
			$erreurs['email'] = "Cette adresse mail n'existe pas ou n'est pas activée";
			return redirect()->to('/connexion/mdp_oublie')->withInput()->with('erreurs', $erreurs);
		}

		$estLiee = $this->lieeUtilisateurJeton($personne['id'],$jeton['id']);

		if($estLiee)
		{
			$lienReinitialisation = base_url("/connexion/mdp_oublie/reinit_mdp/".$jeton['jeton']);
			$message = "Pour réinitialiser votre mot de passe, cliquez sur le lien suivant ".$lienReinitialisation;

			$emailService = \Config\Services::email();
			$emailService->setTo     ($email);
			$emailService->setFrom   ($emailService->SMTPUser);
			$emailService->setSubject('[noreply] Changement de mot de passe');
			$emailService->setMessage($message);

			if($emailService->send(false))
			{
				return redirect()->to('inscription/mailenvoye');
			}
		}
	}

	public function creerJetonsReinitialisation($email)
	{
		$genereJeton = bin2hex(random_bytes(8));
		$jetonsModele = new JetonsModele();
		$jeton = [
			'jeton'      => $genereJeton,
			'expiration' => date   ('Y-m-d H:i:s',strtotime(self::TEMPS_EXPIRATION)) 
		];

		$idJeton = $jetonsModele->insert($jeton);

		$jetonAvecId = [
			'id'         => $idJeton,
			'jeton'      => $genereJeton,
			'expiration' => date   ('Y-m-d H:i:s',strtotime(self::TEMPS_EXPIRATION)) 
		];

		return $jetonAvecId;
	}

	public function lieeUtilisateurJeton($idPersonne, $idJeton)
	{
		$utilisateurModele = new UtilisateurModele();
		
		$utilisateurMaj = ["id_jeton_resetmdp" => $idJeton ];

		return $utilisateurModele->update($idPersonne,$utilisateurMaj);
	}

	public function afficherFormulaireEnvoieMail()
	{
		helper(['form']);
		echo view('commun/entete');
		echo view('connexion/motDePasseOublieVue');
		echo view('commun/piedpage');
	}

	private function getRegleEtMessageInscription(){
		return [
			'regles' => [
				'email'        => 'required|valid_email',
				'mdp'          => 'required|min_length[4]'
			],
			'messageErreur' => [
				'email' => [
					'required'    => 'L\'adresse email est obligatoire.',
					'valid_email' => 'Veuillez entrer une adresse email valide.'
				],
				'mdp' => [
					'required'   => 'Le mot de passe est obligatoire.',
					'min_length' => 'Le mot de passe doit contenir au moins 4 caractères.'
				]
			]
		];
	}
} 