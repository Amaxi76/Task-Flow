<?php

namespace App\Filters;

use App\Models\Utilisateurs\SessionUtilisateur;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class ConnexionPageFiltre implements FilterInterface
{
	public function before(RequestInterface $request, $arguments = null)
	{
		$uri = $request->getUri()->getPath();
		log_message('debug', "Filtre activé pour la route : $uri");

		$session = new SessionUtilisateur();
		if ( $session->getEstConnecte ( ) )
		{
			log_message('debug', "Utilisateur non connecté. Redirection depuis : $uri");
			return redirect()->back()->withCookies();
		}
	}

	public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
	{
		// Pas de traitement particulier après la requête
	}
}
