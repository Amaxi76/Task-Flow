<?php
namespace App\Controllers;
use App\Models\Utilisateurs\InscriptionsModele;
use App\Models\Utilisateurs\JetonsModele;
use App\Models\Utilisateurs\UtilisateurModele;
use CodeIgniter\Controller;
class ActivationCompteControleur extends Controller
{
	public function index($jeton)
	{
		helper(['form']);
		$jetonModele = new JetonsModele();
		$jeton       = $jetonModele->where('jeton'      , $jeton)
								   ->where('expiration >', date('Y-m-d H:i:s'))
								   ->first();
		if ($jeton)
		{
			$this->deplacementVersUtilisateur($jeton['id']);
			return view("connexionVue"); //TODO:Voir avec les autres 
		}
		else 
		{
			return view("jeton_expireVue");
		}
	}
	
	
	public function deplacementVersUtilisateur($idJeton)
	{
		$inscriptionModele  = new InscriptionsModele();
		$utilisateurModele = new UtilisateurModele ();
		$jetonModele       = new JetonsModele      ();
		
		//Récupération de l'id_personne associé au jeton
		$idPersonne = $inscriptionModele->recupererIdPersonne($idJeton);

		if($idPersonne)
		{
			$utilisateur = [
				'id_personne' => $idPersonne,
				'id_jeton'    => null
			];
			

			$utilisateurModele->insert($utilisateur,false);

			$inscriptionModele->where('id_personne', $idPersonne)->delete();
			$jetonModele      ->where('id', $idJeton)->delete();


			return $idPersonne;
		}
	}
}