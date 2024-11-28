<?php
namespace App\Controllers;

use App\Models\Utilisateurs\UtilisateurModele;
use App\Models\Taches\ModeleIntitules;
use CodeIgniter\Controller;

class ProfilControleur extends Controller {

    protected $utilisateurModele;
    protected $intitulesModele;

    public function __construct() {
        $this->utilisateurModele = new UtilisateurModele();
        $this->intitulesModele = new ModeleIntitules();
    }

    public function index() {

        $idUtilisateur = session()->get('id_utilisateur');

        // Récupérer les données de l'utilisateur
        $data['utilisateur'] = $this->utilisateurModele->find($idUtilisateur);

        // Récupérer les statuts et priorités de l'utilisateur
        $data['statuts'] = $this->intitulesModele->getStatutsUtilisateur($idUtilisateur);
        $data['priorites'] = $this->intitulesModele->getPrioritesUtilisateur($idUtilisateur);

        // Charger la vue
        return view('commun/entete', ['titre' => 'Profil Utilisateur'])
             . view('profil/profilVue', $data)
             . view('commun/piedpage');
    }

    public function enregistrerCouleurs() {
        if ($this->request->isAJAX()) {
            $couleurs = $this->request->getPost('couleurs');
            $idUtilisateur = session()->get('id_utilisateur');

            // Enregistrer les couleurs des statuts
            foreach ($couleurs['statuts'] as $id => $couleur) {
                $this->intitulesModele->update($id, ['couleur' => $couleur]);
            }

            // Enregistrer les couleurs des priorités
            foreach ($couleurs['priorites'] as $id => $couleur) {
                $this->intitulesModele->update($id, ['couleur' => $couleur]);
            }

            return $this->response->setJSON(['success' => true]);
        }
    }

    public function supprimerCompte() {
        if ($this->request->isAJAX()) {
            $idUtilisateur = session()->get('id_utilisateur');

            // Supprimer le compte
            $this->utilisateurModele->delete($idUtilisateur);

            // Détruire la session
            session()->destroy();

            return $this->response->setJSON(['success' => true]);
        }
    }
}
