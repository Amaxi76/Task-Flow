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
		// Connexion à la base de données
		$db = \Config\Database::connect();
	
		// Construction de la requête
		$query = $db->table("taches")
					->select()
					->where('taches.echeance - NOW() <= (taches.rappel || \' minutes\')::INTERVAL')
					->where('taches.echeance > NOW()')
					->where('nbrappel < 1')
					->get();
		// Retourne les résultats sous forme de tableau associatif
		return $query->getResultArray();
	}

	/**
	 * Récupère les emails des utilisateurs associés à une liste de tâches.
	 *
	 * @param array $taskIds Liste des IDs de tâches.
	 * @return array Liste des emails des utilisateurs associés.
	 */
	public function getEmailTaches(array $idUtilisateur) {
		if (empty($idUtilisateur)) {
			return [];
		}

		$db = \Config\Database::connect();

		$query = $db->table("personnes")
					->select('id,email')
					->whereIn('personnes.id',$idUtilisateur)
					->get();

		return $query->getResultArray();
	}

	public function updateTaches(array $taches)
	{
		// Connexion à la base de données
		$db = \Config\Database::connect();

		// Boucle sur chaque tâche
		foreach ($taches as $tache) {
			// Mise à jour de la colonne nbRappel de chaque tâche
			$db->table('taches')
				->set('nbrappel', 'nbrappel + 1', false)  // Incrémentation de nbRappel
				->where('id', $tache['id'])  // Filtrage par l'ID de la tâche
				->update();
		}
	}


}