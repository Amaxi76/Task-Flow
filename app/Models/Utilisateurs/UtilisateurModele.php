<?php
namespace App\Models\Utilisateurs;
use CodeIgniter\Model;
class UtilisateurModele extends Model
{
	protected $table = 'utilisateurs';
	protected $primaryKey =  'id_personne';
	protected $useAutoIncrement = false;
	
	protected $allowedFields = [
		'id_personne',
		'id_jeton_resetmdp',
		'id_jeton_sesouvenir'
		
	];

	public function selectJetonUtilisateur($idJeton) {
		$this->where("id_jeton_resetmdp",$idJeton);
	}

	//FIXME: pas la bonne syntaxe // utiliser une vue
	public function verifierJetonSeSouvenir($jeton)
	{
		$db = \Config\Database::connect();

		$query = $db->table('taskflow.utilisateurs u')
			->select('p.id, p.email, p.nom')
			->join('taskflow.personnes p', 'u.id_personne = p.id')
			->join('taskflow.jetons j', 'u.id_jeton_sesouvenir = j.id')
			->where('j.jeton', $jeton)
			->where('j.expiration >', date('Y-m-d H:i:s'))
			->get();

		$result = $query->getRowArray();

		if ($result) {
			// Le jeton est valide, on retourne les informations de l'utilisateur
			return [
				'id' => $result['id'],
				'email' => $result['email'],
				'nom' => $result['nom']
			];
		}

		// Le jeton n'est pas valide ou a expiré
		return false;
	}

	public function getIdJetons()
	{
		$db = \Config\Database::connect();

		$requete = $db->table('taskflow.utilisateurs u')->select('id_jeton_resetmdp, id_jeton_sesouvenir')->get();
		
		return $requete->getRowArray();
	}

	public function supprimerJetonsExpire($jetonsExpires)
	{
		return $this->db->table('Utilisateurs')
			->set('id_jeton_resetmdp', "CASE WHEN id_jeton_resetmdp IN (" . implode(',', array_map('intval', $jetonsExpires)) . ") THEN NULL ELSE id_jeton_resetmdp END", false)
			->set('id_jeton_sesouvenir', "CASE WHEN id_jeton_sesouvenir IN (" . implode(',', array_map('intval', $jetonsExpires)) . ") THEN NULL ELSE id_jeton_sesouvenir END", false)
			->whereIn('id_jeton_resetmdp', $jetonsExpires)
			->orWhereIn('id_jeton_sesouvenir', $jetonsExpires)
			->update();
	}

}