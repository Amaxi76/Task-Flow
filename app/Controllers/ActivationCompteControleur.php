<?php
namespace App\Controllers;
use App\Models\Utilisateurs\InscriptionsModele;
use App\Models\Utilisateurs\JetonsModele;
use App\Models\Utilisateurs\UtilisateurModele;
use CodeIgniter\Controller;
class ActivationCompteControleur extends Controller {


	/**
	 * Affiche la page de connexion si le jeton d'activation est valide
	 * @param mixed $jeton jeton recupere par mail
	 * @return string
	 */
	public function index($jeton){
		helper(['form']);
		$jetonModele = new JetonsModele();
		$jeton       = $jetonModele->where('jeton'       , $jeton)
								   ->where('expiration >', date('Y-m-d H:i:s'))
								   ->first();
		if ($jeton)
		{
			$this->deplacementVersUtilisateur($jeton['id']);
			echo view('commun/entete');
			echo view("connexion/connexionVue"); //TODO:Voir avec les autres 
			echo view('commun/piedpage');
		}
		else 
		{
			//return view("/inscription/jeton_expireVue");
		}
	}
	
	/**
	 * Deplacement de l'id_personne de la table inscription à la table utilisateur
	 * @param mixed $idJeton
	 */
	public function deplacementVersUtilisateur($idJeton){
		$inscriptionModele  = new InscriptionsModele();
		$utilisateurModele  = new UtilisateurModele ();
		$jetonModele        = new JetonsModele      ();
		
		//Récupération de l'id_personne associé au jeton
		$idPersonne = $inscriptionModele->recupererIdPersonne($idJeton);

		if($idPersonne) {
			$utilisateur = [
				'id_personne' => $idPersonne,
				'id_jeton'    => null
			];

			$utilisateurModele->insert($utilisateur,false);
			$inscriptionModele->where('id_personne', $idPersonne)->delete();
			$jetonModele      ->where('id'         , $idJeton   )->delete();

			return $idPersonne;
		}
	}
}