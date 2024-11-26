<?php
namespace App\Models\Utilisateurs;
use CodeIgniter\Model;
class UtilisateurModele extends Model
{
	protected $table = 'utilisateurs';
	protected $primaryKey =  ['id_personne','id_jeton'];
	
	protected $allowedFields = [
		'id_personne',
		'id_jeton'
	];
}