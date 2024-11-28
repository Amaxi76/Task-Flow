<?php 
namespace App\Controllers;

use App\Models\Taches\ModeleIntitules;
use App\Models\Taches\ModeleVueCartesTaches;
use App\Models\Taches\ModeleTaches;
use Config\Pager;   

class FiltresTrisTachesControleur extends BaseController 
{

	public function index() 
	{ 
		$dataEntete = [];
		$dataEntete['titre'] = 'Liste des Tâches';

		// Charger le modèle des tâches
		$tacheModele = new ModeleVueCartesTaches();
		$intituleModele = new ModeleIntitules();

		// Configurer le pager
		$configPager = config(Pager::class); 
		$configPager->perPage = 4;

		// Charger les données paginées
		$dataCorps = [];
		$dataCorps['taches']      = $tacheModele->getCartesUtilisateurPaginees(1, 4);
		$dataCorps['statuts']     = $intituleModele->getStatutsUtilisateur(1);
		$dataCorps['priorites']   = $intituleModele->getPrioritesUtilisateur(1);
		$dataCorps['pagerTaches'] = $tacheModele->pager;

		// Charger la vue 
		helper(['form']);
		return view('commun/entete', $dataEntete) . view('/taches/afficherTachesVue', $dataCorps) . view('commun/piedpage'); 
	}
}
