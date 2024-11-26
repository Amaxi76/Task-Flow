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

	public function getToutesTachesUtilisateur($id_utilisateur)
	{
		return $this->select ('taches.*, priorites.nom as priorite, statuts.nom as statut')
					->join   ('priorites', 'priorites.id = taches.id_priorite', 'left') // Jointure avec la table des priorités
					->join   ('statuts', 'statuts.id = taches.id_statut', 'left')      // Jointure avec la table des statuts
					->where  ('taches.id_utilisateur', $id_utilisateur)
					->findAll();
	}

}