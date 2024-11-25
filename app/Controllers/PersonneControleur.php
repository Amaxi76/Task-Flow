<?php 
namespace App\Controllers; 
use App\Models\PersonneModele; 

class PersonneControleur extends BaseController 
{ 
	public function index() 
	{ 
		$personneModel = new PersonneModele();
		// Récupérer les paramètres de la requête avec des valeurs par défaut 
		$email = $this->request->getVar('email') ?? 'defaut';
		$nom   = $this->request->getVar('nom') ?? 'defaut';  // Par défaut tri par titre 
		$mdp   = $this->request->getVar('mdp') ?? 'defaut'; // Par défaut croissant 


		$data['email'] = $email;
		$data['nom'] = $nom;
		$data['mdp'] = $mdp;
	

		// Charger la vue 
		return view('personneVue', $data); 
	} 
} 