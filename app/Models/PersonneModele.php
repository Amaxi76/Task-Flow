<?php
namespace App\Models;
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