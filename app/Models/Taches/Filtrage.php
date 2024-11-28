<?php
namespace App\Models\Taches;
use CodeIgniter\Model;
class Filtrage
{
	private $valeursAutoriseesTris = ['ASC', 'DESC', ''];

	private $tris = [
		'titre' => '',
		'ajoute_le' => '',
		'echeance' => '',
		'libelle_priorite' => '',
		'libelle_statut' => ''
	];

	private $filtres_simples = [
		'date_min' => '',
		'date_max' => '',
		'contient' => ''
	];

	private $filtres_multiples = [
		'priorite' => [],
		'statut' => []
	];

	public function setTri ( $cle, $valeur ) {
		if (array_key_exists($cle, $this->tris) && in_array($valeur, $this->valeursAutoriseesTris)) {
			$this->tris[$cle] = $valeur;
		}
	}

	public function setFiltreSimple ( $cle, $valeur ) {
		if (array_key_exists($cle, $this->filtres_simples)) {
			$this->filtres_simples[$cle] = $valeur;
		}
	}

	public function addFiltreMultiple ( $cle, $valeur ) {
		if (array_key_exists($cle, $this->filtres_multiples)) {
			$this->filtres_multiples[$cle][] = $valeur;
		}
	}

	public function filtrage (ModeleVueCartesTaches $modele) {
	
		/*// Traiter les tris
		foreach ($this->tris as $cle => $valeur) {
			if (array_key_exists($cle, $_GET) && in_array($_GET[$cle], $this->valeursAutoriseesTris)) {
				$this->tris[$cle] = $_GET[$cle];
			}
		}

		// Traiter les filtres multiples
		foreach ($this->filtres_multiples as $cle => $valeur) {
			if (array_key_exists($cle, $_GET) && is_array($_GET[$cle])) {
				$this->filtres_multiples[$cle] = $_GET[$cle];
			}
		}

		// Traiter les filtres simples
		foreach ($this->filtres_simples as $cle => $valeur) {
			if (array_key_exists($cle, $_GET)) {
				$this->filtres_simples[$cle] = $_GET[$cle];
			}
		}*/

		/*// Appliquer les tris
		foreach ($this->tris as $cle => $valeur) {
			if ($valeur != '') {
				$modele->orderBy($cle, $valeur);
			}
		}*/

		// Appliquer les filtres multiples
		/*foreach ($this->filtres_multiples as $cle => $valeur) {
			if (count($valeur) > 0) {
				$modele->whereIn($cle, $valeur);
			}
		}*/

		// Appliquer les filtres simples
		if ($this->filtres_simples['date_min'] != '') {
			$modele->where('date_echeance >=', $this->filtres_simples['date_min']);
		}

		if ($this->filtres_simples['date_max'] != '') {
			$modele->where('date_echeance <=', $this->filtres_simples['date_max']);
		}

		if ($this->filtres_simples['contient'] != '') {
			$modele->like('titre', $this->filtres_simples['contient'])
				->orLike('detail', $this->filtres_simples['contient']);
		}
	}
}