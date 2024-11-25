<?php 
namespace App\Controllers; 
use App\Models\PersonneModele; 

class PersonneControleur extends BaseController 
{ 
	public function index() 
	{ 
		$personneModel = new PersonneModele();

		$personnes = $personneModel->orderBy('nom', 'asc')->findAll();

		// Charger la vue 
		return view('personneVue', $personnes); 
	} 
} 