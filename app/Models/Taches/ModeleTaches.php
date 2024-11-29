<?php
namespace App\Models\Taches;
use CodeIgniter\Model;
class ModeleTaches extends Model
{
	protected $table         = 'taches';
	protected $primaryKey    = 'id';
	protected $allowedFields = [
		'id_utilisateur',
		'titre',
		'detail',
		'date_ajout',
		'rappel',
		'date_echeance',
		'id_priorite',
		'id_statut'
	];
}