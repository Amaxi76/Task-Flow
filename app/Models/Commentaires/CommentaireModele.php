<?php
namespace App\Models\Commentaires;
use CodeIgniter\Model;
class CommentaireModele extends Model
{
	protected $table         = 'commentaires';
	protected $primaryKey    = 'id';
	protected $allowedFields = [
		'id_tache',
		'commentaire',
		'date_ajout'
	];

	public function getCommentairesTache( int $idTache, ?string $order ) : array {
		return $this->where('id_tache', $idTache)
			->orderBy('date_ajout', $order)
			->findAll();
	}
}