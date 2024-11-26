<?php
namespace App\Models\Utilisateurs;
use CodeIgniter\Model;
class UtilisateurModele extends Model
{
	protected $table = 'utilisateurs';
	protected $primaryKey =  'id_personne';
	protected $useAutoIncrement = false;
	
	protected $allowedFields = [
		'id_personne'
	];


}