<!DOCTYPE html>
<html lang="fr" dir="ltr">

	<head>
		<meta charset="utf-8">
		<title>Task-Flow</title>
		<meta name="author" content="TaskFlow">
		<meta name="description" content="">
		<link rel="icon" href="/favicon.ico">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="css/styles.css">
	</head>

	<body>
		<header id="up-link">
			<!--<img src="/assets/images/taskflow.png" alt="Logo de TaskFlow">-->
			<h1><?php echo $titre ?></h1>

			<style>
				#menu {
					display: flex;
					list-style-type: none;
					justify-content: space-between;
				}

				.tache {
					border: 1px solid black;
					padding: 10px;
					margin: 10px;
				}
			</style>
			
			<ul id="menu">
				<li><a href="#">Date</a></li>
				<li><a href="#">Priorité</a></li>
				<li><a href="#">Détails</a></li>
				<li>|</li>
				<li><a href="#">Statuts</a></li>
				<li><a href="#">Retard</a></li>
				<li><a href="#">Priorité</a></li>
				<li>|</li>
				<li><a href="#">Recherche</a></li>
			</ul>

			<button>Ajouter une tâche</button>
		</header>