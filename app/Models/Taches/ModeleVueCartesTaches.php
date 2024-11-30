<?php
namespace App\Models\Taches;
use CodeIgniter\Model;
class ModeleVueCartesTaches extends Model
{
	protected $table         = 'vuecartestaches';
	protected $primaryKey    = ['id_tache','id_utilisateur'];

	public function getCartesUtilisateurPaginees( int $idUtilisateur, int $perPage, ?string $keyword = null ) : array {
		return $this->where('id_utilisateur', $idUtilisateur)
			->paginate( $perPage, 'taches');
	}

	public function getCartesUtilisateur( int $idUtilisateur, ?string $keyword = null ) : array {
		return $this->where('id_utilisateur', $idUtilisateur)->findAll();
	}

	public function getTache( int $idTache ) : array {
		return $this->where('id_tache', $idTache)
			->first();
	}
}