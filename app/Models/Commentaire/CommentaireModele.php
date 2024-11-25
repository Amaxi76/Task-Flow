<?php
namespace App\Models\Taches;
use CodeIgniter\Model;
class CommentaireModele extends Model
{
	protected $table         = 'commentaire';
	protected $primaryKey    = 'id_commentaire';
	protected $allowedFields = [
        'id_tache',
        'commentaire',
        'ajoutee_le'
	];
}