<?php
namespace App\Models\Taches;
use CodeIgniter\Model;
class StatutUtilisateurModele extends Model
{
	protected $table         = 'statututilisateur';
	protected $primaryKey    = ['id_statut','id_utilisateur'];
	protected $allowedFields = [
        'estModifiable'
	];

	public function getStatutsParUtilisateur( $idUtilisateur ){
		return $this->select('statututilisateur.id_statut AS id_statut, intitule.libelle AS libelle')
			->join('intitule', 'statututilisateur.id_statut = intitule.id', 'inner')
			->where('statututilisateur.id_utilisateur', $idUtilisateur)
			->findAll();
	}
}