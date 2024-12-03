<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="TaskFlow">
	<meta name="description" content="">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
	<link rel="icon" href="/favicon.ico">
	<title>Task-Flow</title>
</head>

<header>
	<div class="conteneur-entete">
		<a href="<?= base_url('/') ?>">
			<img src="<?= base_url('assets/images/Task-Flow-Horizontal.svg') ?>" alt="Logo de TaskFlow">
		</a>
		
		<div class="conteneur-menu-boutons">
			<a href="<?= base_url('/profil')?>">
				<div class="button secondary-button">
					<button>Profil</button>
				</div>
			</a>
		
			<a href="<?= base_url('/deconnexion')?>">
				<div class="button main-button">
					<svg viewBox="0 0 43 36" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M27.5294 24.0714V30.9524C27.5294 33.1878 25.7298 35 23.5098 35H5.0196C2.79964 35 1 33.1878 1 30.9524V5.04762C1 2.81218 2.79964 1 5.01961 1H23.5098C25.7298 1 27.5294 2.81218 27.5294 5.04762V11.9286M11.8529 18H42M42 18L35.9704 11.9286M42 18L35.9704 24.0715" />
					</svg>
					<button>Déconnexion</button>
				</div>
			</a>
		</div>

		
	</div>
</header>