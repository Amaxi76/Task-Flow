<?php
namespace App\Models\Taches;
class ServiceTriageTaches
{
	private array $valeursAutoriseesTris;
	private array $tris;

	/*---------------------------------------*/
	/*             CONSTRUCTEUR              */
	/*---------------------------------------*/
	public function __construct() {
		$this->reinitialiser();
	}

	public function reinitialiser(){
		$this->valeursAutoriseesTris = ['ASC', 'DESC', ''];
		$this->tris = [
			'titre'     => '',
			'date_ajout' => '',
			'date_echeance'  => '',
			//'libelle_priorite' => '',
			//'libelle_statut' => ''
		];
	}

	/*---------------------------------------*/
	/*                ACCESSEUR              */
	/*---------------------------------------*/

	public function setTri ( $cle, $valeur ) {
		$cleValide    = array_key_exists($cle, $this->tris);
		$valeurValide = in_array($valeur, $this->valeursAutoriseesTris);

		if ($cleValide && $valeurValide) {
			$this->tris[$cle] = $valeur;
		}
	}

	public function getTri ( $cle ) {
		$cleValide = array_key_exists($cle, $this->tris);
		if ($cleValide) {
			return $this->tris[$cle];
		}
		return null;
	}

	/*---------------------------------------*/
	/*                METHODES               */
	/*---------------------------------------*/

	public function trier(ModeleVueCartesTaches $modele): ModeleVueCartesTaches
	{
		foreach ($this->tris as $cle => $valeur) {
			if (!empty($valeur)) {
				$modele->orderBy($cle, $valeur);
			}
		}

		return $modele;
	}

	/*---------------------------------------*/
	/*             SERIALISATION             */
	/*---------------------------------------*/

	public function toArray() : array {
		return $this->tris;
	}

	public static function fromArray(?array $data): ServiceTriageTaches {
		$instance = new self();

		if (isset($data)) {
			$instance->tris = $data;
		}

		return $instance;
	}
}