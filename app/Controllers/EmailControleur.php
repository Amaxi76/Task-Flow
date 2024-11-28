<?php namespace App\Controllers;

use CodeIgniter\Controller;

class EmailControleur extends Controller
{
	public function sendEmail()
	{
		$email = \Config\Services::email();

		$email->setTo      ("thomasboudeele1@gmail.com");
		$email->setFrom    ($email->SMTPUser);
		$email->setSubject ('[noreply] Confirmation d\'inscription');
		$email->setMessage ("aa");

		if ($email->send()) {
			echo "Email envoyé avec succès.";
		} else {
			echo "Échec de l'envoi de l'email.";
			echo $email->printDebugger();
		}
	}
}
