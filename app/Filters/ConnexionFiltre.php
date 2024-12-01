<?php

namespace App\Filters;

use App\Models\Utilisateurs\SessionUtilisateur;
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

		$session = new SessionUtilisateur();
		if ( !$session->getEstConnecte() ) 
		{
			helper(['cookie']);

			// Vérifier le cookie seSouvenir
			$cookieSeSouvenir = get_cookie('seSouvenir');
			if ($cookieSeSouvenir) {
				log_message('debug', "Cookie seSouvenir trouvé. Tentative de connexion automatique.");
				
				// Vérifier la validité du jeton et connecter l'utilisateur
				$utilisateur = $this->verifierJetonSeSouvenir($cookieSeSouvenir);

				if ($utilisateur) {
					$session->connecter( $utilisateur['id'] );
					log_message('debug', "Connexion automatique réussie pour l'utilisateur ID: " . $utilisateur['id']);
					return; // Continuer la requête normalement
				} else {
					$session->deconnecter();
					log_message('debug', "Jeton seSouvenir invalide. Suppression du cookie.");
					delete_cookie('seSouvenir');
				}
			}

			log_message('debug', "Utilisateur non connecté. Redirection depuis : $uri");
			return redirect()->to('/connexion')->withCookies();
		}

		log_message('debug', "Utilisateur connecté, accès autorisé à : $uri");

		/*// Méthode suposée pour limiter les problèmes de cachet de formulaire POST
		if ($request->getMethod() === 'post') {
			return redirect()->to($request->getServer('HTTP_REFERER'));
		}*/
	}

	// Méthode à ajouter dans votre contrôleur ou dans un service dédié
	private function verifierJetonSeSouvenir($jeton)
	{
		//TODO: c'est quoi tous ces commnentaires ci-dessous ?
		// Implémentez ici la logique pour vérifier le jeton dans la base de données
		// et retourner les informations de l'utilisateur si le jeton est valide
		// Retournez false si le jeton est invalide ou expiré

		// Exemple:
		$utilisateurModele = new UtilisateurModele(); // Assurez-vous d'avoir un modèle approprié
		$utilisateur = $utilisateurModele->verifierJetonSeSouvenir($jeton);
		return $utilisateur;
	}



	public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
	{
		// Pas de traitement particulier après la requête
	}
}
