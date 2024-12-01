<?php
namespace App\Controllers;
use App\Models\Utilisateurs\JetonsModele;
use App\Models\Utilisateurs\PersonneModele;
use App\Models\Utilisateurs\UtilisateurModele;
use CodeIgniter\Controller;
class ReinitialisationMotDePasseControleur extends Controller
{
	public function index($jeton)
	{
		helper(['form']);
		
		if ($this->verifierJeton($jeton)) 
		{
			echo view('commun/entete');
			echo view("/connexion/reinitialisationMdpVue",['jeton' => $jeton]);
			echo view('commun/piedpage');
		}
	}

	/**
	 * Verifie que le jeton passé en paramètre est présent dans la base de donnée et lié à un utilisateurs
	 * @param mixed $jeton jetons de verification donné par mail
	 * @return bool true si le jetons existe et lié
	 */
	public function verifierJeton($jeton){

		$jetonModele = new JetonsModele();
		$jetonObject = $jetonModele->where("jeton",$jeton)->first();
	
		$utilisateurModele = new UtilisateurModele();
		$jetonUtilisateur  = $utilisateurModele->where("id_jeton_resetmdp",$jetonObject['id'])->first();

		return isset($jetonUtilisateur);
	}

	/**
	 * Fait le changement de mot de passe dans la base de données 
	 */
	public function changementMotDePasse(){
		$regles          = ['mdp'=> 'required|min_length[4]','confirmerMdp' => 'required|matches[mdp]'];
		$messagesErreurs = [
			'mdp' => [
					'required'   => 'Le mot de passe est obligatoire.',
					'min_length' => 'Le mot de passe doit contenir au moins 4 caractères.'
			],
			'confirmerMdp' => [
				'required' => 'La confirmation du mot de passe est obligatoire.',
				'matches'  => 'La confirmation du mot de passe ne correspond pas au mot de passe saisi.'
			]
		];

		$jeton              = $this->request->getVar('jeton');
		$validate = $this->validate($regles,$messagesErreurs);

		if($validate)
		{
			$nouveauMdp         = $this->request->getVar('mdp'  );

			$jetonModele       = new JetonsModele     ();
			$utilisateurModele = new UtilisateurModele();

			$jeton             = $jetonModele      ->where("jeton"            ,$jeton      )->first(); //récuperer le jeton dans la bado correspondant au jeton donnée par mail 
			$utilisateur       = $utilisateurModele->where("id_jeton_resetmdp",$jeton['id'])->first(); //Réécupérer la personne concerné par l'id_jeton

			$idPersonne = $utilisateur['id_personne'];

			if($utilisateur) { //si l'utilisateur a été trouvé
				$personneModele = new PersonneModele();
				$majMotDePasse  = ['mdp' => password_hash($nouveauMdp,PASSWORD_DEFAULT)];

				$estMiseAJour = $personneModele->update($idPersonne,$majMotDePasse); //update du mot de passe

				helper(['form']);
				if($estMiseAJour){
					$utilisateurModele->update($idPersonne,["id_jeton_resetmdp" => null]); //deliée le jeton et l'utilisateur
					$jetonModele      ->delete($jeton['id']); //supprimer le jeton
					return redirect()->to('connexion');
				}
				return view(('/connexion/motDePasseOublie')); 
			}
			else{
				$erreurs = ['jeton' => "Aucun utilisateur se correspond a ce jeton, veuillez renvoyé une demande de changement de mot de passe"];


				$data = 
				[
					'erreur' => $erreurs,
					'jeton'  => $jeton
				];
				helper(['form']);
				echo view('commun/entete');
				echo view('connexion/reinitialisationMdpVue',$erreurs); //renvoie vers inscription avec message d'erreur
				echo view('commun/piedpage');
			}
		}
		else
		{
			$erreurs = $this->validator->getErrors();

			$data = 
			[
				'erreur' => $erreurs,
				'jeton'  => $jeton
			];
			helper(['form']);
			echo view('commun/entete');
			echo view('connexion/reinitialisationMdpVue',$data); //renvoie vers inscription avec message d'erreur
			echo view('commun/piedpage');
	}
	}
}