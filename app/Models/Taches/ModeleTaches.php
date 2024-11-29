<?php
namespace App\Models\Taches;
use CodeIgniter\Model;
class ModeleTaches extends Model
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

	public function getTachesARappeler()
	{
		$db = \Config\Database::connect();
		$builder = $db->table('taskflow.taches');
	;
		$query = $builder->select('Taches.id, Taches.titre, Taches.echeance, Taches.rappel, Utilisateurs.id_personne')
			->from('Taches')
			->join('Utilisateurs', 'Taches.id_utilisateur = Utilisateurs.id_personne')
			->where('Taches.echeance <=', 'NOW() + INTERVAL Taches.rappel DAY', false)
			->where('Taches.echeance >', 'NOW()', false)
			->get();

		return $query->getResultArray();
	}
	

}