<?php
namespace App\Models\Taches;
use CodeIgniter\Model;
class TacheModele extends Model
{
	protected $table         = 'taches';
	protected $primaryKey    = 'id';
	protected $allowedFields = [
		'id_utilisateur',
		'titre',
		'detail',
        'ajoute_le',
        'rappel',
        'echeance',
        'id_priorite',
        'id_statut'
	];
}