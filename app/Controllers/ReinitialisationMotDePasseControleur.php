<?php
namespace App\Controllers;
use App\Models\Utilisateurs\InscriptionsModele;
use App\Models\Utilisateurs\JetonsModele;
use App\Models\Utilisateurs\PersonneModele;
use App\Models\Utilisateurs\UtilisateurModele;
use CodeIgniter\Controller;
class ReinitialisationMotDePasseControleur extends Controller
{
	public function index($jeton)
	{
		helper(['form']);
		
		if ($this->verifierJeton($jeton))
			return view("/connexion/reinitialisationMdpVue",['jeton' => $jeton]);
		else 
			return view("jeton_expireVue"    );
	}

	public function verifierJeton($jeton)
	{
		$jetonModele = new JetonsModele();
		$jetonObject = $jetonModele->where("jeton",$jeton)->first();

		dd($jeton,$jetonObject);
		
		$utilisateurModele = new UtilisateurModele();
		$jetonUtilisateur  = $utilisateurModele->where("id_jeton",$jeton['id'])->first();

		return isset($jetonUtilisateur);
	}

	public function changementMotDePasse()
	{
		$regles = 
		[
			'mdp'          => 'required|min_length[4]',
			'confirmerMdp' => 'required|matches[mdp]'
		];
		
		$messagesErreurs = 
		[
			'mdp' => [
					'required'   => 'Le mot de passe est obligatoire.',
					'min_length' => 'Le mot de passe doit contenir au moins 4 caractères.'
			],
			'confirmerMdp' => [
				'required' => 'La confirmation du mot de passe est obligatoire.',
				'matches'  => 'La confirmation du mot de passe ne correspond pas au mot de passe saisi.'
			]
		];

		if($this->validate($regles,$messagesErreurs))
		{
			$jeton              = $this->request->getVar('jeton'       );
			$nouveauMdp         = $this->request->getVar('mdp'         );
			$confirmeNouveauMdp = $this->request->getVar('confimerMdp' );

			$jetonModele = new JetonsModele();
			$jeton       = $jetonModele->where("jeton",$jeton)->first();

			$utilisateurModele = new UtilisateurModele();
			$utilisateur       = $utilisateurModele->where("id_jeton",$jeton['id'])->first();

			$idPersonne = $utilisateur['id_personne'];

			if($utilisateur)
			{
				$personneModele = new PersonneModele();
				$majMotDePasse  = ['mdp' => password_hash($nouveauMdp,PASSWORD_DEFAULT)];

				$estMiseAJour = $personneModele->update($idPersonne,$majMotDePasse);

				if($estMiseAJour)
				{
					return view('connexionVue');
				}
				else
				{
					return view("motDePasseOublie");
				}
			}

		}

	}

}