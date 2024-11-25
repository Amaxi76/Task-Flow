<?php
namespace App\Models\Taches;
use CodeIgniter\Model;
class PrioriteUtilisateurModele extends Model
{
	protected $table         = 'prioriteutilisateur';
	protected $primaryKey    = ['id_priorite','id_utilisateur'];
	protected $allowedFields = [
        'estModifiable'
	];
}