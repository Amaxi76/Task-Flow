<?php 
namespace App\Controllers;
use App\Models\Taches\ModeleVueCartesTaches;
use App\Models\Commentaire\CommentaireModele;

//TODO: le mieux serait de passer direcement les donénes dans la session
// et de pouvoir utiliser le système de redirecttion de CI4
class CommentairesControleur extends BaseController
{
	private $idUtilisateur;

	/*---------------------------------------*/
	/*             CONSTRUCTEUR              */
	/*---------------------------------------*/

	public function __construct()
	{
		$session = session();
		$this->idUtilisateur = $session->get('id');
	}

	/*---------------------------------------*/
	/*                  VUES                 */
	/*---------------------------------------*/

	public function index( ?int $idTache=null )
	{
		// Récupérer les données du formulaire
		$request = \Config\Services::request ();
		if( $idTache == null ) $idTache = $request->getPost ('id');

		// Données de l'entête
		$dataEntete = [];
		$dataEntete['titre'] = 'Tâche : ';

		// Charger les modèles
		$tacheModele = new ModeleVueCartesTaches();
		$commentaireModele = new CommentaireModele();

		// Charger les données
		$dataCorps = [];
		$dataCorps['tache']        = $tacheModele->getTache($idTache); //TODO: changer dans la vue 'taches' en 'tache' et adapater
		$dataCorps['commentaires'] = $commentaireModele->getCommentairesTache($idTache, 'ASC');

		// Charger la vue
		helper(['form']);
		return view('commun/entete', $dataEntete) . view('commentaires/afficherCommentairesTacheVue', $dataCorps) . view('commun/piedpage');
	}

	public function appliquerAjout()
	{
		// Récupérer les données du formulaire
		$request = \Config\Services::request();
		$data = $request->getPost();

		// Charger le modèle
		$commentaireModele = new CommentaireModele();

		// Insérer les données
		$commentaireModele->insert($data);

		// Charger la vue
		return $this->index($data['id_tache']);
	}

	public function appliquerSuppression(){
		// Récupérer les données du formulaire
		$request = \Config\Services::request();
		$data = $request->getPost();
		$idCommentaire = $data['id_commentaire'];
		
		// Charger le modèle
		$commentaireModele = new CommentaireModele();

		// Insérer les données
		$commentaireModele->delete($idCommentaire);

		// Charger la vue
		return $this->index($data['id_tache']);
	}
}