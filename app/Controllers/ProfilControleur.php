<?php
namespace App\Controllers;

use App\Models\Utilisateurs\PersonneModele;
use App\Models\Utilisateurs\UtilisateurModele;
use App\Models\Taches\ModeleIntitules;
use App\Models\Taches\ModeleTaches;
use CodeIgniter\Controller;

class ProfilControleur extends Controller {

	protected $personneModele;
	protected $intitulesModele;

	public function __construct() {
		$this->personneModele = new PersonneModele();
		$this->intitulesModele = new ModeleIntitules();
	}

	public function index() {

		$idUtilisateur = session()->get('id');

		// Récupérer les données de l'utilisateur
		$data['utilisateur'] = $this->personneModele->find($idUtilisateur);

		// Récupérer les statuts et priorités de l'utilisateur
		$data['statuts']   = $this->intitulesModele->getStatutsUtilisateur($idUtilisateur);
		$data['priorites'] = $this->intitulesModele->getPrioritesUtilisateur($idUtilisateur);

		helper(['form']);
		// Charger la vue
		return view('commun/entete', ['titre' => 'Profil Utilisateur'])
			 . view('profil/profilVue', $data)
			 . view('commun/piedpage');
	}

	public function enregistrerModification() 
	{
		$this->enregistrerCouleurs();
	
	}

	public function enregistrerCouleurs()
	{
		// Récupérer les couleurs envoyées depuis le formulaire
		$couleurs = $this->request->getPost('couleurs');

		$idUtilisateur = session()->get('id');

		// Vérifier si les couleurs des statuts existent
		if (isset($couleurs['statuts'])) 
		{
			foreach ($couleurs['statuts'] as $id => $couleur) 
			{
				$this->intitulesModele->update($id,['couleur' => $couleur]);
			}
		}

		// Redirection ou réponse après traitement
		return redirect()->back()->with('success', 'Couleurs enregistrées avec succès.');
	}

	public function supprimerCompte() 
	{
		$idUtilisateur = session()->get('id');

		// Charger les modèles nécessaires
		$intitulesModele   = new ModeleIntitules();
		$tachesModele      = new ModeleTaches();
		$utilisateurModele = new UtilisateurModele();

		// Supprimer les tâches liées à l'utilisateur
		$tachesModele->where('id_utilisateur', $idUtilisateur)->delete();

		// Supprimer les intitulés liés à l'utilisateur
		$intitulesModele->where('id_utilisateur', $idUtilisateur)->delete();

		
		// Supprimer l'utilisateur
		$utilisateurModele->delete($idUtilisateur);

		// Supprimer la personne
		$this->personneModele->delete($idUtilisateur);

		// Détruire la session
		session()->destroy();
	}

	public function ajouterStatut()
	{
		$titre = $this->request->getPost("titre");
		$couleur = $this->request->getPost("couleur");

		$intituleModele = new ModeleIntitules();
		
		$intitule = 
		[
			'id_utilisateur' => session()->get("id"),
			'type_intitule'  => 'statut',
			'libelle'        => $titre,
			'couleur'        => $couleur 
		];
		$intituleModele->insert($intitule);
		
		return redirect()->to('profil');
	}

	public function supprimerStatut($id)
	{
		$this->intitulesModele->delete($id);
		return redirect()->back();
	}
	
}