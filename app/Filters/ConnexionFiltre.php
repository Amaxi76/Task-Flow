<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use \App\Models\Utilisateurs\JetonsModele;
use \App\Models\Utilisateurs\UtilisateurModele;

class ConnexionFiltre implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
	{
		$uri = $request->getUri()->getPath();
		log_message('debug', "Filtre activé pour la route : $uri");

		$session = session();

		if (!$session->get('estConnecte')) {
			log_message('debug', "Utilisateur non connecté. Redirection depuis : $uri");
			return redirect()->to('/connexion')->withCookies();
		}

		log_message('debug', "Utilisateur connecté, accès autorisé à : $uri");

		/*// Méthode suposée pour limiter les problèmes de cachet de formulaire POST
		if ($request->getMethod() === 'post') {
			return redirect()->to($request->getServer('HTTP_REFERER'));
		}*/
	}



    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Pas de traitement particulier après la requête
    }
}
