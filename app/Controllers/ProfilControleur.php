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
            $idUtilisateur = session()->get('id');
    
            // Charger les modèles nécessaires
            $intitulesModele = new ModeleIntitules();
            $tachesModele = new ModeleTaches();
            $utilisateurModele = new UtilisateurModele();
    
            // Commencer une transaction
            $this->db->transStart();
    
            // Supprimer les intitulés liés à l'utilisateur
            $intitulesModele->where('id_utilisateur', $idUtilisateur)->delete();
    
            // Supprimer les tâches liées à l'utilisateur
            $tachesModele->where('id_utilisateur', $idUtilisateur)->delete();
    
            // Supprimer l'utilisateur
            $utilisateurModele->delete($idUtilisateur);
    
            // Supprimer la personne
            $this->personneModele->delete($idUtilisateur);
    
            // Terminer la transaction
            $this->db->transComplete();
    
            if ($this->db->transStatus() === false) {
                // La transaction a échoué
                return $this->response->setJSON(['success' => false]);
            }
    
            // Détruire la session
            session()->destroy();
    
            return $this->response->setJSON(['success' => true]);
        }
    }
    
}
