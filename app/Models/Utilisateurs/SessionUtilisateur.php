<?php
namespace App\Models\Utilisateurs;

use App\Models\Taches\ServiceFiltrageTaches;
use App\Models\Taches\ServiceTriageTaches;

class SessionUtilisateur
{
	/* CLES SESSION */
	private const CLE_ID_UTILISATEUR     = 'idUtilisateur';
	private const CLE_EST_CONNECTE       = 'estConnecte';
	private const CLE_NB_TACHES_PAR_PAGE = 'nbTachesParPage';
	private const CLE_TYPE_VUE           = 'typeVue';
	private const CLE_FILTRAGE_TACHES    = 'serviceFiltrageTaches';
	private const CLE_TRIAGE_TACHES      = 'serviceTriageTaches';
	private const CLE_ID_TACHE           = 'idTache';

	/* VALEURS POSSIBLES */
	public const VUE_GENERALE = 'generale';
	public const VUE_KANBAN   = 'kanban';
	private const NB_PAR_PAGE = 8;

	private $session;

	/*---------------------------------------*/
	/*             CONSTRUCTEUR              */
	/*---------------------------------------*/

	public function __construct(){
		$this->session = session();
	}

	/**
	 * Initialiser toutes les valeurs nécessaires de la session
	 */
	public function connecter ( int $idUtilisateur ){
		$this->setIdUtilisateur   ($idUtilisateur);
		$this->setEstConnecte     (TRUE );
		$this->setNbTachesParPage ( self::NB_PAR_PAGE );
		$this->setTypeVue         ( self::VUE_GENERALE );
		$this->setFiltrageTaches  ( new ServiceFiltrageTaches() );
		$this->setTriageTaches    ( new ServiceTriageTaches() );
		$this->setIdTache         ( null );
	}

	public function deconnecter(){
		$this->session->destroy();
	}

	/*---------------------------------------*/
	/*             ID_UTILISATEUR            */
	/*---------------------------------------*/

	public function setIdUtilisateur( int $idUtilisateur ){
		$this->session->set(SessionUtilisateur::CLE_ID_UTILISATEUR ,$idUtilisateur);
	}

	public function getIdUtilisateur(): ?int {
		return $this->session->get(SessionUtilisateur::CLE_ID_UTILISATEUR);
	}

	/*---------------------------------------*/
	/*             EST_CONNECTE              */
	/*---------------------------------------*/

	public function setEstConnecte( bool $estConnecte ){
		$this->session->set(SessionUtilisateur::CLE_EST_CONNECTE, $estConnecte);
	}

	public function getEstConnecte(): bool {
		$cleAbsente = $this->session->get(SessionUtilisateur::CLE_EST_CONNECTE) === null;
		$estConnecte = $this->session->get(SessionUtilisateur::CLE_EST_CONNECTE);

		return !$cleAbsente && $estConnecte;
	}

	/*---------------------------------------*/
	/*                 VUES                  */
	/*---------------------------------------*/

	public function getNbTachesParPage(): int {
		return $this->session->get(SessionUtilisateur::CLE_NB_TACHES_PAR_PAGE);
	}

	public function setNbTachesParPage( int $nbTachesParPage ): void {
		$this->session->set(SessionUtilisateur::CLE_NB_TACHES_PAR_PAGE, $nbTachesParPage);
	}

	public function getTypeVue(): string {
		return $this->session->get(SessionUtilisateur::CLE_TYPE_VUE);
	}

	public function setTypeVue( string $typeVue ): void {
		if( $typeVue === self::VUE_GENERALE || $typeVue === self::VUE_KANBAN ){
			$this->session->set(SessionUtilisateur::CLE_TYPE_VUE, $typeVue);
		}
	}

	/*---------------------------------------*/
	/*             FILTRAGE_TACHE            */
	/*---------------------------------------*/

	public function setFiltrageTaches( ?ServiceFiltrageTaches $filtrage ) : void {
		$this->session->set(SessionUtilisateur::CLE_FILTRAGE_TACHES, $filtrage->toArray() );
	}

	public function getFiltrageTaches(): ?ServiceFiltrageTaches {
		return ServiceFiltrageTaches::fromArray( $this->session->get(SessionUtilisateur::CLE_FILTRAGE_TACHES) );
	}

	/*---------------------------------------*/
	/*              TRIAGE_TACHE             */
	/*---------------------------------------*/

	public function setTriageTaches( ?ServiceTriageTaches $triage ) : void {
		$this->session->set(SessionUtilisateur::CLE_TRIAGE_TACHES, $triage->toArray() );
	}

	public function getTriageTaches(): ?ServiceTriageTaches {
		return ServiceTriageTaches::fromArray( $this->session->get(SessionUtilisateur::CLE_TRIAGE_TACHES) );
	}

	/*---------------------------------------*/
	/*                 ID_TACHE              */
	/*---------------------------------------*/

	public function setIdTache( ?int $id ) : void {
		$this->session->set(SessionUtilisateur::CLE_ID_TACHE, $id);
	}

	public function getIdTache(): ?int {
		return $this->session->get(SessionUtilisateur::CLE_ID_TACHE);
	}

	public function idTacheExiste(): bool {
		return $this->session->get(SessionUtilisateur::CLE_ID_TACHE) !== null;
	}

	//TODO: vérifier si on ne peut pas mettre cette méthode dans une classe dédiée dans App/Filters/ pour qu'elle soit appelée automatiquement à chaque ouverture de vue
	//TODO: il serait intéressant de vérifier si l'id d'une tache existe toujours (dans le cas où elle aurait été supprimée sur un autre navigateur ou via la bdd)
	public function majIdTacheAvecPost( string $clePost = SessionUtilisateur::CLE_ID_TACHE ): void {
		$idTachePostExiste = request()->getPost( $clePost ) !== null;
		if( $idTachePostExiste ){
			$idTache = request()->getPost( $clePost );
			$this->setIdTache($idTache);
		}
	}
}