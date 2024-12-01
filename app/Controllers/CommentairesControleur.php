<?php 
namespace App\Controllers;

use App\Models\Taches\ModeleVueCartesTaches;
use App\Models\Commentaires\CommentaireModele;
use App\Models\Utilisateurs\SessionUtilisateur;

class CommentairesControleur extends BaseController
{
	private SessionUtilisateur $session;

	/*---------------------------------------*/
	/*             CONSTRUCTEUR              */
	/*---------------------------------------*/

	public function __construct( ){
		$this->session = new SessionUtilisateur();
	}

	/*---------------------------------------*/
	/*                  VUES                 */
	/*---------------------------------------*/

	/**
	 * Acces via le GET
	 */
	public function index() {
		// Mettre à jour les données de la session
		$this->session->majIdTacheAvecPost( 'id' );

		// Vérifier qu'il n'y a pas de problème
		if( !$this->session->idTacheExiste() ) return redirect()->to(site_url('taches'));

		// Charger les modèles
		$tacheModele       = new ModeleVueCartesTaches();
		$commentaireModele = new CommentaireModele();

		// Charger les données
		$data = [];
		$data['titre']        = 'Tâche : ';
		$data['tache']        = $tacheModele->getTache($this->session->getIdTache());
		$data['commentaires'] = $commentaireModele->getCommentairesTache($this->session->getIdTache(), 'ASC');

		// Charger la vue
		helper(['form']);
		return view('commun/entete') . view('commentaires/afficherCommentairesTacheVue', $data) . view('commun/piedpage');
	}

	public function appliquerAjout() {
		// Mettre à jour les données de la session
		$this->session->majIdTacheAvecPost('id_tache');
		
		// Vérifier qu'il n'y a pas de problème
		if( !$this->session->idTacheExiste() ) return redirect()->to(site_url('taches'));

		// Récupérer les données du formulaire
		$data = request()->getPost();

		$validation = \Config\Services::validation();
		$validation->setRules([
			'commentaire'         => 'required'
		]);

		if( !$validation->withRequest ( $this->request ) ->run() ){
			return redirect()->back()->withInput()->with('errors', $validation->getErrors());
		}

		// Charger le modèle
		$commentaireModele = new CommentaireModele();

		// Insérer les données
		$commentaireModele->insert($data);

		// Charger la vue
		return redirect()->to(site_url('taches/detail'));
	}

	public function appliquerSuppression(){
		// Mettre à jour les données de la session
		$this->session->majIdTacheAvecPost('id_tache');
		
		// Vérifier qu'il n'y a pas de problème
		if( !$this->session->idTacheExiste() ) return redirect()->to(site_url('taches'));

		// Récupérer les données du formulaire
		$data = request()->getPost();
		$idCommentaire = $data['id_commentaire'];
		
		// Charger le modèle
		$commentaireModele = new CommentaireModele();

		// Insérer les données
		$commentaireModele->delete($idCommentaire);

		// Charger la vue
		return redirect()->to(site_url('taches/detail'));
	}
}