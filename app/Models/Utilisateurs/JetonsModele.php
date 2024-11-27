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

	public function recupererJeton($idJeton)
	{
		$jeton = $this->where("id",$idJeton)->first();
		return $jeton ? $jeton['jeton'] : null;
	}
}