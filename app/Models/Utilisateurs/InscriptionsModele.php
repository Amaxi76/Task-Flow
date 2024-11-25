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
}