<?php
namespace App\Models\Taches;
use CodeIgniter\Model;
class ModeleVueCartesTaches extends Model
{
	protected $table         = 'vuecartestaches';
	protected $primaryKey    = ['id_tache','id_utilisateur'];

	public function getCartesUtilisateurPaginees( $idUtilisateur, $perPage ) : array {
		return $this->where('id_utilisateur', $idUtilisateur)
			->paginate( $perPage, 'taches');
	}
}