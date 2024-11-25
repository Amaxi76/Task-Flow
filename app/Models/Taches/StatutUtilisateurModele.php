<?php
namespace App\Models\Taches;
use CodeIgniter\Model;
class StatutUtilisateurModele extends Model
{
	protected $table         = 'StatutUtilisateur';
	protected $primaryKey    = ['id_statut','id_utilisateur'];
	protected $allowedFields = [
        'estModifiable'
	];
}