<?php

namespace App\Controllers;
use App\Models\Taches\ModeleTaches;
use App\Models\Utilisateurs\InscriptionsModele;
use App\Models\Utilisateurs\JetonsModele;
use App\Models\Utilisateurs\PersonneModele;
use App\Models\Utilisateurs\UtilisateurModele;
use CodeIgniter\Controller;

class Cron extends Controller
{
	public function lancerTaches()
    {
		log_message("info","Début boucle de verification usuelle");
		$this->envoyerRappelsTaches();
		$this->verifierJetons      ();
		log_message("info","Fin boucle de verification usuelle");
    }
	
	/**
	 * Envoie des rappels pour les tâches arrivant à échéance.
	 */
	public function envoyerRappelsTaches() 
	{
		log_message('info', 'Debut de la vérification des rappels de taches');
		// Chargement du modèle
		$tacheModele = new ModeleTaches();

		// Récupérer les tâches proches de leur échéance
		$tachesARappeler = $tacheModele->getTachesARappeler();

		$idUserTachesRappeller = array_column($tachesARappeler,'id_utilisateur');

		$ensEmailaEnvoyer = $tacheModele->getEmailTaches($idUserTachesRappeller);

		$tableauRappel =$this->regrouperParEmail($tachesARappeler,$ensEmailaEnvoyer);

		foreach ($tableauRappel as $email => $taches) 
		{
			// Passer l'email et les tâches à la vue
			$contenu = view('email/rappel_email', ['taches' => $taches]);

			// Envoyer l'email
			$this->envoyerEmails($email, $contenu);

			$tacheModele->updateTaches($taches);
		}

		log_message('info', 'Fin de la vérification des rappels de taches');
	}

	public function regrouperParEmail(array $taches, array $emails) {
		$tableauRappel = [];
	
		// Créer un tableau associatif des emails avec leur ID
		$emailAssoc = [];
		foreach ($emails as $emailData) {
			// Associé l'ID de l'utilisateur à son email
			$emailAssoc[$emailData['id']] = $emailData['email'];
		}
	
		// Associer les tâches à leur email respectif
		foreach ($taches as $tache) {
			// Trouver l'email de l'utilisateur à partir de son ID
			$userId = $tache['id_utilisateur'];
			if (isset($emailAssoc[$userId])) {
				$email = $emailAssoc[$userId];
				// Ajouter la tâche à l'email correspondant
				$tableauRappel[$email][] = $tache;
			}
		}
	
		return $tableauRappel;
	}
	
	public function envoyerEmails($email,$contenu)
	{
		$emailService = \Config\Services::email();
		$emailService->setTo      ($email);
		$emailService->setFrom    ($emailService->SMTPUser);
		$emailService->setSubject ('Taches arrivant à écheance');
		$emailService->setMessage ($contenu);
		$emailService->setMailType('html');

		if ($emailService->send()) {
			log_message('info', 'Email envoyé avec succès à l\'adresse '.$email);
		} else {
			log_message('error', 'Échec de l\'envoi de l\'email : ' . $email->printDebugger(['headers']));
		}
	}

	public function verifierJetons()
	{
		log_message('info', 'Début de la vérification des jetons');

		$utilisateurModele = new UtilisateurModele ();
		$inscriptionModele = new InscriptionsModele();

		$jetonsUtilisateurs = $utilisateurModele->getIdJetons();
		$this->verifierJetonsUtilisateurs($jetonsUtilisateurs);

		$jetonsInscription = $inscriptionModele->getIdJetons();
		$this->verifierJetonsInscription($jetonsInscription);	
		
		log_message('info', 'Fin de la vérification des jetons');
	}

	public function verifierJetonsUtilisateurs($id_jetons)
	{
		//Récuperer tous les jetons expirés
		$jetonsModele = new JetonsModele();
		$jetonsExpirer = $jetonsModele->selectJetonsExpire($id_jetons);

	
		if($jetonsExpirer)
		{
			//Supprimer les jetons expirés dans la table utilisateurs
			$utilisateurModele = new UtilisateurModele();
			$utilisateurModele->supprimerJetonsExpire($jetonsExpirer);
		
			//Supprimer les jetons dans la table jetons
			$jetonsModele->whereIn($id_jetons)->delete();
		}
	}

	public function verifierJetonsInscription($id_jetons)
	{
		$inscriptionModele = new InscriptionsModele();
		$jetonsModele      = new JetonsModele      ();
		$personneModele    = new PersonneModele    ();

		$jetonsExpirer       = $jetonsModele->selectJetonsExpire ($id_jetons  );

		if($jetonsExpirer)
		{
			$IdPersonneInscrite  = $inscriptionModele->recupererIdPersonne($jetonsExpirer);
			$IdPersonneInscrite  = is_array($IdPersonneInscrite) ? $IdPersonneInscrite : [$IdPersonneInscrite];
			//Supprimer les jetons dans la table jetons
			$inscriptionModele->whereIn('id_personne',$IdPersonneInscrite)->delete();
			$jetonsModele     ->whereIn('id'         ,$jetonsExpirer     )->delete();
			$personneModele   ->whereIn('id'         ,$IdPersonneInscrite)->delete();
		}
	}
	

}
