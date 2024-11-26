<?php 
namespace App\Controllers; 
use App\Models\Utilisateurs\UtilisateurModele;
use App\Models\Utilisateurs\UtilisateurModeleModele; 
use App\Models\Utilisateurs\PersonneModele; 

class ConnexionControleur extends BaseController 
{ 
	public function index()
	{
		helper(['form']);
		return view('connexionVue');
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
				return view('connexionVue',$erreur);
			}
		}
		else
		{
			helper(['form']);
			$erreur = ["C'est adresse mail n'existe pas ou n'est pas activé"];
			return view('connexionVue',$erreur);
		}
	}

	public function verifieExistance($email)
	{
		$personneModele = new PersonneModele();
		$personne       = $personneModele->where("email",$email)->first();
		$infoPersonne = null;
		
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
} 