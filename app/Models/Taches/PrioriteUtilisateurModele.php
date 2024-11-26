<?php
namespace App\Models\Taches;
use CodeIgniter\Model;
class PrioriteUtilisateurModele extends Model
{
	protected $table         = 'prioriteutilisateur';
	protected $primaryKey    = ['id_priorite','id_utilisateur'];
	protected $allowedFields = [
        'estModifiable'
	];

	public function getPrioritesParUtilisateur( $idUtilisateur ){
		return $this->select('prioriteutilisateur.id_priorite AS id_priorite, priorite.libelle AS libelle')
			->join('intitule', 'prioriteutilisateur.id_priorite = intitule.id', 'inner')
			->where('prioriteutilisateur.id_utilisateur', $idUtilisateur)
			->findAll();
	}
}