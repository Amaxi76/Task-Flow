<?php

namespace App\Controllers;

use App\Models\Taches\ModeleTaches;
use CodeIgniter\Controller;

class Cron extends Controller
{

	/**
	 * Envoie des rappels pour les tâches arrivant à échéance.
	 */
	public function envoyerRappelsTaches() 
	{

		log_message('info', 'Genre je suis la ?');
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

}
