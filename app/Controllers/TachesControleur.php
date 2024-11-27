<?php 
namespace App\Controllers;

use App\Models\Taches\ModeleIntitules;
use App\Models\Taches\ModeleVueCartesTaches;
use App\Models\Taches\PrioriteUtilisateurModele;
use App\Models\Taches\TacheModele;
use App\Models\Taches\StatutUtilisateurModele;

class TachesControleur extends BaseController 
{ 
	/*public function index() { 
		$dataEntete = [];
		$dataEntete['titre'] = 'Liste des Tâches';

		// Charger le modèle des tâches
		$tacheModele = new TacheModele();
		$dataCorps = [];
		$dataCorps['taches']      = $tacheModele->getTachesPagineesUtilisateur(1, 4);
		$dataCorps['pagerTaches'] = $tacheModele->pager;

		// Charger la vue 
		return view('commun/entete', $dataEntete) . view('tachesVue', $dataCorps) . view('commun/piedpage'); 
	}*/

	public function index() { 
		$dataEntete = [];
		$dataEntete['titre'] = 'Liste des Tâches';

		// Charger le modèle des tâches
		$tacheModele = new ModeleVueCartesTaches();
		$dataCorps = [];
		$dataCorps['taches']      = $tacheModele->getCartesUtilisateurPaginees(1, 4);
		$dataCorps['pagerTaches'] = $tacheModele->pager;

		// Charger la vue 
		return view('commun/entete', $dataEntete) . view('tachesVue', $dataCorps) . view('commun/piedpage'); 
	}

	//FIXME: à corriger : ne fonctionne pas
	public function ajouter() {
		$dataEntete = [];
		$dataEntete['titre'] = 'Ajouter une tâche';

		// Charger les modeles des priorités, et des status
		$prioriteModele = new ModeleIntitules();
		$statusModele   = new ModeleIntitules();

		$dataCorps = [];
		$dataCorps['priorites'] = $prioriteModele->getPrioritesUtilisateur(1);
		$dataCorps['statuts']   = $statusModele  ->getStatutsUtilisateur(1);

		// Charger la vue 
		return view('commun/entete', $dataEntete) . view('ajouterTacheVue', $dataCorps) . view('commun/piedpage'); 
	}
} 