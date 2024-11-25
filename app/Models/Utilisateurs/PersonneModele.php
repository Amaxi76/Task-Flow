<?php
namespace App\Models\Utilisateurs;
use CodeIgniter\Model;
class PersonneModele extends Model
{
	protected $table = 'personnes';
	protected $primaryKey = 'id';
	protected $allowedFields = [
		'email',
		'nom',
		'mdp'
	];
}