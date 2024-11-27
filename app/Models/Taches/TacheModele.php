<?php
namespace App\Models\Taches;
use CodeIgniter\Model;
class TacheModele extends Model
{
	protected $table         = 'taches';
	protected $primaryKey    = 'id';
	protected $allowedFields = [
		'id_utilisateur',
		'titre',
		'detail',
		'ajoute_le',
		'rappel',
		'echeance',
		'id_priorite',
		'id_statut'
	];

	//TODO: peut être à modifier
	public function getTachesPagineesUtilisateur ($id_utilisateur, $perPage) : array {
		return $this->select ('
				taches.titre AS titre,
				taches.detail AS detail,
				taches.echeance AS echeance,
				statut.libelle AS statut,
				priorite.libelle AS priorite
			')
			->join ('intitule AS statut', 'taches.id_statut = statut.id', 'inner')
			->join ('intitule AS priorite', 'taches.id_priorite = priorite.id', 'inner')
			->where ('taches.id_utilisateur', $id_utilisateur)
			->groupBy ('taches.id, statut.libelle, priorite.libelle')
			->paginate( $perPage, 'taches');
	}

	public function ajouterTache() {
		$tacheModele = new \App\Models\Taches\TacheModele();

		// Récupérer les données du formulaire
		$data = [
			'id_utilisateur' => session()->get('id_utilisateur'), // ou un ID utilisateur valide
			'titre' => $this->request->getPost('titre'),
			'detail' => $this->request->getPost('detail'),
			'echeance' => $this->request->getPost('echeance'),
			'id_priorite' => $this->request->getPost('id_priorite'),
			'id_statut' => $this->request->getPost('id_statut')
		];

		// Ajouter la tâche
		if ($tacheModele->insert($data)) {
			return redirect()->to('/taches')->with('message', 'Tâche ajoutée avec succès.');
		} else {
			return redirect()->back()->with('error', 'Erreur lors de l\'ajout de la tâche.');
		}
	}
}