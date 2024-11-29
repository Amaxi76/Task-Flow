<?php
namespace App\Models\Taches;
use CodeIgniter\Model;
class ModeleVueCartesTaches extends Model
{
	protected $table         = 'vuecartestaches';
	protected $primaryKey    = ['id_tache','id_utilisateur'];

	public function getCartesUtilisateurPaginees( int $idUtilisateur, int $perPage, string $sortOrder = 'asc', ?string $keyword = null ) : array {
		if ($keyword !== null) {
			$this->like ('titre', $keyword);
			$this->orLike ('description', $keyword);
		}
		return $this->where('id_utilisateur', $idUtilisateur)
			->paginate( $perPage, 'taches');
	}

	public function getTache( int $idTache ) : array {
		return $this->where('id_tache', $idTache)
			->first();
	}
}