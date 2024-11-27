<?php 
namespace App\Controllers; 
use App\Models\Utilisateurs\JetonsModele;
use App\Models\Utilisateurs\UtilisateurModele;
use App\Models\Utilisateurs\UtilisateurModeleModele; 
use App\Models\Utilisateurs\PersonneModele; 

class ConnexionControleur extends BaseController { 
	private const TEMPS_EXPIRATION = '+1 hour'; //TODO:A voir si on peut pas mettre un int plutôt

	/**
	 * Affiche la page de connexion
	 */
	public function index(){
		helper(['form']);
		echo view('commun/entete');
		echo view('connexion/connexionVue');
		echo view('commun/piedpage');
	}

	/**
	 * Verifie les informations passées dans le formulaire de connexion, ouvre la session et redirige vers la page d'accueil
	 * @return string
	 */
	public function connexion(){
		$session         = session();
		$email           = $this->request->getVar("email");
		$mdpFormulaire   = $this->request->getVar("mdp");
		
		$utilisateur = $this->verifieExistanceUtilisateur($email);

		$erreur = [];

		if($utilisateur){
			$mdpPersonne = $utilisateur['mdp'];
			$mdpCorrect  = password_verify($mdpFormulaire,$mdpPersonne);

			if($mdpCorrect){
				$donnee_session = [
					'id'          => $utilisateur['id'],
					'estConnecte' => TRUE
				];

				$session->set($donnee_session);
				return view('succes'); //TODO:Changer pour la page d'accueil
			}
			else{
				$erreur = ["Le mot de passe est incorrect"];
			}
		}
		else{
			$erreur = ["C'est adresse mail n'existe pas ou n'est pas activé"];
		}

		return view('connexion/connexionVue',$erreur);
	}

	/**
	 * Verifie que la personne saisie dans le formulaire existe dans la base de donnée
	 * @param mixed $email 
	 */
	public function verifieExistanceUtilisateur($email){
		$personneModele = new PersonneModele();
		$personne       = $personneModele->where("email",$email)->first();
		$infoPersonne   = null;
		
		if($personne){
			$infoPersonne = [
				"id"  =>  $personne['id' ],
				"mdp" => $personne['mdp']
			];
		}
		return $infoPersonne;
	}

	/**
	 * Crée et envoie le mail pour changer son mot de passe oublié
	 */
	public function envoiMailMdpOublie(){
		$email      = $this->request->getVar("email");

		$personne   = $this->verifieExistanceUtilisateur($email);
		$jeton      = $this->creerJetonsReinitialisation();

		$estLiee = $this->lieeUtilisateurJeton($personne['id'],$jeton['id']);

		if($estLiee){
			$lienReinitialisation = site_url("/connexion/mdp_oublie/reinit_mdp/".$jeton['jeton']);
			$message = "Pour réinitialiser votre mot de passe, cliquez sur le lien suivant ".$lienReinitialisation;

			$emailService = \Config\Services::email();
			$emailService->setTo     ($email);
			$emailService->setFrom   ($emailService->SMTPUser);
			$emailService->setSubject('[noreply] Changement de mot de passe');
			$emailService->setMessage($message);

			echo $emailService->send(false);
		}
	}

	/**
	 * Crée le jeton de changement de mot de passe et l'insert dans la bado
	 * retourne le jeton avec l'id
	 */
	public function creerJetonsReinitialisation(){
		$jetonsModele = new JetonsModele();

		$genererJeton = bin2hex(random_bytes(8));
		$jeton = [
			'jeton'      => $genererJeton,
			'expiration' => date   ('Y-m-d H:i:s',strtotime(self::TEMPS_EXPIRATION)) 
		];

		$idJeton = $jetonsModele->insert($jeton);

		$jetonAvecId = [
			'id'         => $idJeton,
			'jeton'      => $genererJeton,
			'expiration' => date   ('Y-m-d H:i:s',strtotime(self::TEMPS_EXPIRATION)) 
		];

		return $jetonAvecId;
	}

	/**
	 * Lie l'id_jeton et l'id_personne dans la table utilisateur s
	 * @param mixed $idPersonne
	 * @param mixed $idJeton
	 * @return bool
	 */
	public function lieeUtilisateurJeton($idPersonne, $idJeton){
		$utilisateurModele = new UtilisateurModele();
		return $utilisateurModele->update($idPersonne,["id_jeton" => $idJeton ]);
	}

	public function afficherFormulaireEnvoieMail(){
		helper(['form']);
		return view('connexion/formulaireEnvoieMailVue');
	}
} 