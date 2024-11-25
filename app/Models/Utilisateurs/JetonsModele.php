<?php
namespace App\Models\Utilisateurs;
use CodeIgniter\Model;
class JetonsModele extends Model
{
	protected $table = 'jetons';
	protected $primaryKey = 'id';
	protected $allowedFields = [
		'jeton',
		'expiration'
	];
}