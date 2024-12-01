<?php
namespace App\Models\Taches;
use CodeIgniter\Model;
class ModeleIntitules extends Model
{
	protected $table         = 'intitules';
	protected $primaryKey    = 'id';
	protected $allowedFields = [
		'id_utilisateur',
		'type_intitule',
		'libelle',
		'couleur',
		'est_supprimable'
	];

	public function getStatutsUtilisateur( $idUtilisateur ) : array {
		return $this->where('id_utilisateur', $idUtilisateur)
			->where('type_intitule', 'statut')
			->findAll();
	}

	public function getPrioritesUtilisateur( $idUtilisateur ) : array {
		return $this->where('id_utilisateur', $idUtilisateur)
			->where('type_intitule', 'priorite')
			->findAll();
	}
}