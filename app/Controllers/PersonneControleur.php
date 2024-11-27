<?php 
namespace App\Controllers; 
use App\Models\Utilisateurs\PersonneModele; 

class PersonneControleur extends BaseController 
{ 
	public function index() 
	{ 
		$personneModel = new PersonneModele();
		$personnes = $personneModel->orderBy('nom', 'asc')->findAll();

		$data = [
			'personnes' => $personnes
		];

		// Charger la vue 
		return view('personneVue', $data); 
	} 
} 