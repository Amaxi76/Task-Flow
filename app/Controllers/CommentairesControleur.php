<?php 
namespace App\Controllers;
use App\Models\Taches\ModeleVueCartesTaches;



class CommentairesControleur extends BaseController
{
	public function index()
	{

		helper(['form']);
		$tacheModele = new ModeleVueCartesTaches();


		$dataCorps = [];
		$dataEntete['titre'] = 'Tâche : ';
		$dataCorps['taches']      = $tacheModele->getCartesUtilisateurPaginees(1, 4);
		$dataCorps['commentaires'] = [
			['id_commentaire' => "1", 'description' => 'Premier commentairePremier commentairePremier commentairePremier commentairePremier commentairePremier commentairePremier commentairePremier commentaire', 'date' => '2023-10-01'],
			
			['id_commentaire' => "2", 'description' => 'Premier commentairePremier commentairePremier commentairePremier commentairePremier commentairePremier commentairePremier commentairePremier commentaire', 'date' => '2023-10-01'],
			
			['id_commentaire' => "3", 'description' => 'Deuxième commentaire', 'date' => '2023-10-02']
		];

		return view('commun/entete', $dataEntete) . view('commentaires/afficherCommentairesTacheVue', $dataCorps) . view('commun/piedpage');
	}
}