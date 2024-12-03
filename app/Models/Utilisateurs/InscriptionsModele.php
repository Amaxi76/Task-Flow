<?php
namespace App\Models\Utilisateurs;
use CodeIgniter\Model;
class InscriptionsModele extends Model
{
	protected $table = 'inscriptions';
	protected $primaryKey = ['id_personne','id_jeton'];

	protected $allowedFields = [
		'id_personne',
		'id_jeton'
	];
	
	public function recupererIdPersonne($idJeton): ?string
	{
		// Convertir en tableau si ce n'est pas déjà un tableau
		$tab_id_jetons = is_array($idJeton) ? $idJeton : [$idJeton];
	
		// Utiliser whereIn correctement
		$inscription = $this->whereIn('id_jeton', $tab_id_jetons)->first();
	
		return $inscription ? $inscription['id_personne'] : null;
	}
	

	public function getIdJetons()
	{
		$db = \Config\Database::connect();

		$requete = $db->table('taskflow.inscriptions i')->select('id_jeton')->get();
	
		return $requete->getRowArray();
	}
	
}