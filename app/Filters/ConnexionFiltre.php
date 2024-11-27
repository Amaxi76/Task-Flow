<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\Utilisateurs\JetonsModele;
use App\Models\Utilisateurs\UtilisateurModele;

class ConnexionFiltre implements FilterInterface
{
	public function before(RequestInterface $request, $arguments = null)
{
	$session = session();
	helper(['cookie']);
	$jetonModele       = new JetonsModele();
	$utilisateurModele = new UtilisateurModele();

	// Vérifier si l'utilisateur est déjà connecté
	if ($session->get('estConnecte')) return;

	// Vérifier le jeton "Se souvenir de moi"
	$cookie = get_cookie('seSouvenir');
	if ($cookie) {
		list($userId, $token) = explode(':', $cookie);
		$jeton = $jetonModele->where('jeton', hash('sha256', $token))
							 ->where('expiration >', date('Y-m-d H:i:s'))
							 ->first();

		if ($jeton) {
			$utilisateur = $utilisateurModele->find($userId);
			if ($utilisateur && $utilisateur['id_jeton_sesouvenir'] == $jeton['id']) {
				// Connecter l'utilisateur
				$session->set([
					'id' => $utilisateur['id'],
					'estConnecte' => TRUE
				]);
				return;
			}
		}
	}

	// Liste des routes à exclure de l'authentification
	$excludedRoutes = [
		'/connexion',
		'/inscription',
		'/connexion/mdp_oublie',
		'/connexion/mdp_oublie/envoie_mail',
		'/connexion/mdp_oublie/reinit_mdp/(:any)',
		'/connexion/mdp_oublie/reinit_mdp'
	];

	// Vérifier si la route actuelle est dans les routes exclues
	if (!in_array($request->getUri()->getPath(), $excludedRoutes)) {
		return redirect()->to('connexion')->withCookies();
	}
}



	public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
	{
		// Rien à faire après
	}

	private function regenererJeton($userId, $jetonId)
	{
		// Logique pour régénérer le jeton
	}
}
