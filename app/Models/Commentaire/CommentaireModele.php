<?php
namespace App\Models\Commentaire;
use CodeIgniter\Model;
class CommentaireModele extends Model
{
	protected $table         = 'commentaires';
	protected $primaryKey    = 'id_commentaire';
	protected $allowedFields = [
		'id_tache',
		'commentaire',
		'ajoutee_le' //TODO: changer le nom en "date_ajout"
	];

	public function getCommentairesTache( int $idTache, ?string $order ) : array {
		return $this->where('id_tache', $idTache)
			->orderBy('ajoutee_le', $order)
			->findAll();
	}
}