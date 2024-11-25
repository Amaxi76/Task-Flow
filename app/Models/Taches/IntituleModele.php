<?php
namespace App\Models\Taches;
use CodeIgniter\Model;
class IntituleModele extends Model
{
	protected $table         = 'intitule';
	protected $primaryKey    = 'id_intitule';
	protected $allowedFields = [
		'libelle',
        'couleur'
	];
}