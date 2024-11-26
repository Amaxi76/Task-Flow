<?php
namespace App\Models\Taches;
use CodeIgniter\Model;
class IntituleModele extends Model
{
	protected $table         = 'intitule';
	protected $primaryKey    = 'id';
	protected $allowedFields = [
		'libelle',
        'couleur'
	];
}