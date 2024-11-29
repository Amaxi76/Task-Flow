<?php 
namespace App\Controllers;
use App\Models\Taches\ModeleVueCartesTaches;



class CommentairesControleur extends BaseController
{
	private $idUtilisateur;

	public function __construct()
	{
		$session = session();
		$this->idUtilisateur = $session->get('id');
	}

	public function index()
	{
		// Récupérer les données du formulaire
		$request = \Config\Services::request ();
		$idTache = $request->getPost ('id');

		// Données de l'entête
		$dataEntete = [];
		$dataEntete['titre'] = 'Tâche : ';

		// Charger les modèles
		$tacheModele = new ModeleVueCartesTaches();
		//TODO: modele VIEW commentaire

		// Charger les données
		$dataCorps = [];
		$dataCorps['tache'] = $tacheModele->getTache($idTache); //TODO: changer dans la vue 'taches' en 'tache' et adapater
		$dataCorps['commentaires'] = [ //TODO: plus de commentaires en durs
			['id_commentaire' => "1", 'description' => 'Premier commentairePremier commentairePremier commentairePremier commentairePremier commentairePremier commentairePremier commentairePremier commentaire', 'date' => '2023-10-01'],
			
			['id_commentaire' => "2", 'description' => 'Premier commentairePremier commentairePremier commentairePremier commentairePremier commentairePremier commentairePremier commentairePremier commentaire', 'date' => '2023-10-01'],
			
			['id_commentaire' => "3", 'description' => 'Deuxième commentaire', 'date' => '2023-10-02']
		];

		// Charger la vue
		helper(['form']);
		return view('commun/entete', $dataEntete) . view('commentaires/afficherCommentairesTacheVue', $dataCorps) . view('commun/piedpage');
	}
}