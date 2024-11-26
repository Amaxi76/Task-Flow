<?php 
namespace App\Controllers;  

class TachesControleur extends BaseController 
{ 
	public function index() 
	{ 
		$dataEntete = [];
		$dataEntete['titre'] = 'Liste des Tâches';

		$dataCorps = [];
		$dataCorps['taches'] = [
			[
				'titre' => 'Faire les maquettes',
				'detail' => 'Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l imprimerie depuis les années 1500, quand un imprimeur anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. Il n a pas fait que survivre cinq siècles, mais s est aussi adapté à la bureautique informatique, sans que son contenu n en soit modifié. Il a été popularisé dans les années 1960 grâce à la vente de feuilles Letraset contenant des passages du Lorem Ipsum, et, plus récemment, par son inclusion dans des applications de mise en page de texte, comme Aldus PageMaker.',
				'rappel' => '1 semaine restante',
				'priorite' => 'Faible',
				'statut' => 'En cours'
			],
			[
				'titre' => 'Développer le site',
				'detail' => 'Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l\'imprimerie depuis les années 1500',
				'rappel' => '2 semaines restantes',
				'priorite' => 'Moyenne',
				'statut' => 'En cours'
			],
			[
				'titre' => 'Tester le site',
				'detail' => 's',
				'rappel' => '3 semaines restantes',
				'priorite' => 'Haute',
				'statut' => 'En cours'
			],
			[
				'titre' => 'Mettre en production',
				'detail' => 'Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l\'imprimerie depuis les années 1500',
				'rappel' => '4 semaines restantes',
				'priorite' => 'Haute',
				'statut' => 'En cours'
			]
		];

		// Charger la vue 
		return view('commun/entete', $dataEntete) . view('tachesVue', $dataCorps) . view('commun/piedpage'); 
	} 
} 