<?php

namespace App\Controllers;

use App\Models\Taches\ModeleTaches;
use CodeIgniter\Controller;

class Cron extends Controller
{

	function envoyerRappelsTaches() 
	{
		$tacheModele = new ModeleTaches();
		$tachesARappeler = $tacheModele->getTachesARappeler();
		
		dd($tachesARappeler);
		foreach($tachesARappeler as $tache)
		{
			dd("je suis la");
			$this->envoyerEmails($tache['email'],$tache['titre'],$tache['echeance']);
		}
	}

	
	public function envoyerEmails($email,$titre,$echeance)
	{
		$email = \Config\Services::email();
		$email->setTo      ("thomasboudeele1@gmail.com");
		$email->setFrom    ($email->SMTPUser);
		$email->setSubject ('TEST');
		$email->setMessage ("/!\ ATTENTION /!\ La taches ".$titre." arrive a écheance le ".$echeance);

		if ($email->send()) {
			log_message('info', 'Email envoyé avec succès');
		} else {
			log_message('error', 'Échec de l\'envoi de l\'email : ' . $email->printDebugger(['headers']));
		}
	}
}
