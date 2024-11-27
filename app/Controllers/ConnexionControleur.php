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
		return view('connexion/connexionVue');
	}

	public function connexion()
	{
		$session         = session();
		$email           = $this->request->getVar("email");
		$mdpFormulaire   = $this->request->getVar("mdp");
		
		$utilisateur = $this->verifieExistance($email);

		if($utilisateur)
		{
			$mdpPersonne = $utilisateur['mdp'];
			$mdpCorrect  = password_verify($mdpFormulaire,$mdpPersonne);

			if($mdpCorrect)
			{
				$donnee_session = 
				[
					'id'          => $utilisateur['id'],
					'estConnecte' => TRUE
				];

				$session->set($donnee_session);
				return view('succes');
			}
			else
			{
				helper(['form']);
				$erreur = ["Le mot de passe est incorrect"];
				return view('connexion/connexionVue',$erreur);
			}
		}
		else
		{
			helper(['form']);
			$erreur = ["C'est adresse mail n'existe pas ou n'est pas activé"];
			return view('connexion/connexionVue',$erreur);
		}
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

		//dd($personne,$jeton);

		$estLiee = $this->lieeUtilisateurJeton($personne['id'],$jeton['id']);

		if($estLiee)
		{
			$lienReinitialisation = site_url("/reinitMdp/".$jeton['jeton']);
			$message = "Pour réinitialiser votre mot de passe, cliquez sur le lien suivant ".$lienReinitialisation;

			$emailService = \Config\Services::email();
			$emailService->setTo($email);
			$emailService->setFrom($emailService->SMTPUser);
			$emailService->setSubject('[noreply] Changement de mot de passe');
			$emailService->setMessage($message);

			echo $emailService->send(false);
		}
	}

	public function creerJetonsReinitialisation($email)
	{
		$jetonsModele = new JetonsModele();
		$jeton = [
			'jeton'      => bin2hex(random_bytes(8)),
			'expiration' => date   ('Y-m-d H:i:s',strtotime(self::TEMPS_EXPIRATION)) 
		];

		$idJeton = $jetonsModele->insert($jeton);

		$jetonAvecId = [
			'id'         => $idJeton,
			'jeton'      => bin2hex(random_bytes(8)),
			'expiration' => date   ('Y-m-d H:i:s',strtotime(self::TEMPS_EXPIRATION)) 
		];

		return $jetonAvecId;
	}

	public function lieeUtilisateurJeton($idPersonne, $idJeton)
	{
		$utilisateurModele = new UtilisateurModele();
		
		$utilisateurMaj = ["id_jeton" => $idJeton ];

		return $utilisateurModele->update($idPersonne,$utilisateurMaj);
	}

	public function afficherFormulaireEnvoieMail()
	{
		helper(['form']);
		return view('connexion/formulaireEnvoieMailVue');
	}
} 