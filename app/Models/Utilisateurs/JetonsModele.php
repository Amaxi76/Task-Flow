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

	public function selectJetonsExpire($id_jetons)
	{
		if($id_jetons == null) return null;
		return $this->select('id')
					->whereIn('id', $id_jetons)
					->where  ('expiration < NOW()')
					->get()
					->getRowArray();
	
	}
}