<?php 
namespace App\Controllers;

use App\Models\Taches\PrioriteUtilisateurModele;
use App\Models\Taches\TacheModele;
use App\Models\Taches\StatutUtilisateurModele;

class TachesControleur extends BaseController 
{ 
	public function index() { 
		$dataEntete = [];
		$dataEntete['titre'] = 'Liste des Tâches';

		// Charger le modèle des tâches
		$tacheModele = new TacheModele();
		$dataCorps = [];
		$dataCorps['taches']      = $tacheModele->getTachesPagineesUtilisateur(1, 4);
		$dataCorps['pagerTaches'] = $tacheModele->pager;

		// Charger la vue 
		return view('commun/entete', $dataEntete) . view('tachesVue', $dataCorps) . view('commun/piedpage'); 
	}

	public function ajouter() {
		$dataEntete = [];
		$dataEntete['titre'] = 'Ajouter une tâche';

		// Charger les modeles des priorités, et des status
		$prioriteModele = new PrioriteUtilisateurModele();
		$statusModele = new StatutUtilisateurModele();

		$dataCorps = [];
		$dataCorps['priorites'] = $prioriteModele->getPrioritesParUtilisateur(1);
		$dataCorps['status'] = $statusModele->getStatutsParUtilisateur(1);

		// Charger la vue 
		return view('commun/entete', $dataEntete) . view('ajouterTacheVue', $dataCorps) . view('commun/piedpage'); 
	}
} 