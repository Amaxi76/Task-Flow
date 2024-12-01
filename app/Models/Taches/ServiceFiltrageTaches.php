<?php
namespace App\Models\Taches;
class ServiceFiltrageTaches
{
	private array $filtres;

	/*---------------------------------------*/
	/*             CONSTRUCTEUR              */
	/*---------------------------------------*/
	public function __construct() {
		$this->reinitialiser();
	}

	//TODO: ajouter un nouveau tableau avec equivalents bd pour les noms de colonnes

	public function reinitialiser(){
		$this->filtres = [
			'deb_date_echeance' => '',
			'fin_date_echeance' => '',
			'contient'          => '',
			'priorite'          => '',
			'statut'            => ''
		];
	}

	/*---------------------------------------*/
	/*                ACCESSEUR              */
	/*---------------------------------------*/

	public function setTri ( $cle, $valeur ) {
		$cleValide    = array_key_exists($cle, $this->filtres);
		//TODO: verifier les valeurs si elles sont biens des dates etc

		if ($cleValide) {
			$this->filtres[$cle] = $valeur;
		}
	}

	public function getTri ( $cle ) {
		$cleValide = array_key_exists($cle, $this->filtres);
		if ($cleValide) {
			return $this->filtres[$cle];
		}
		return null;
	}

	/*---------------------------------------*/
	/*                METHODES               */
	/*---------------------------------------*/

	public function filtrer(ModeleVueCartesTaches $modele): ModeleVueCartesTaches
	{
		if( !empty($this->filtres['deb_date_echeance']) ) {
			$modele->where('date_echeance >=', $this->filtres['deb_date_echeance']);
		}
		
		if( !empty($this->filtres['fin_date_echeance']) ) {
			$modele->where('date_echeance <=', $this->filtres['fin_date_echeance']);
		}

		if( !empty($this->filtres['contient']) ) {
			$modele	->like('titre', $this->filtres['contient'])
					->orLike('detail', $this->filtres['contient']);
		}

		if( !empty($this->filtres['priorite']) ) {
			$modele->like('libelle_priorite', $this->filtres['priorite']);
		}

		if( !empty($this->filtres['statut']) ) {
			$modele->like('libelle_statut', $this->filtres['statut']);
		}

		return $modele;
	}

	/*---------------------------------------*/
	/*             SERIALISATION             */
	/*---------------------------------------*/

	public function toArray() : array {
		return $this->filtres;
	}

	public static function fromArray(array $data): ServiceFiltrageTaches{
		$instance = new self();

		if (isset($data)) {
			$instance->filtres = $data;
		}

		return $instance;
	}
}