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
	public function getTachesUtilisateur ($id_utilisateur)
	{
		return $this->select ('
				taches.titre AS titre,
				taches.detail AS detail,
				taches.echeance AS echeance,
				statut.libelle AS statut,
				priorite.libelle AS priorite
			')
			->join ('intitule AS statut', 'taches.id_statut = statut.id_intitule', 'inner')
			->join ('intitule AS priorite', 'taches.id_priorite = priorite.id_intitule', 'inner')
			->where ('taches.id_utilisateur', $id_utilisateur)
			->groupBy ('taches.id, statut.libelle, priorite.libelle')
			->findAll ();
	}

}