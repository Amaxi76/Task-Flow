<?php
// Intervalle en secondes (par exemple : toutes les 5 minutes)
$interval = 10;

// URL de la nouvelle route
$url = 'http://localhost/Task-Flow/public/cron/run';

// Fichier de log pour suivre l'exécution (facultatif)
$logFile = __DIR__ . '/cron_runner.log';

while (true) {

	// Initialiser une session cURL
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Suivre les redirections si nécessaire
	curl_setopt($ch, CURLOPT_TIMEOUT, 30); // Timeout après 30 secondes

	// Exécuter la requête cURL
	$response = curl_exec($ch);

	// Vérifier les erreurs cURL
	if ($response === false) {
		$error = curl_error($ch);
		file_put_contents($logFile, "[ERROR] " . date('Y-m-d H:i:s') . " - cURL error: $error" . PHP_EOL, FILE_APPEND);
	} else {
		// Journaliser la réponse
		file_put_contents($logFile, "[SUCCESS] " . date('Y-m-d H:i:s') . " - Response: $response" . PHP_EOL, FILE_APPEND);
	}

	// Fermer la session cURL
	curl_close($ch);

	// Attendre X secondes avant la prochaine exécution
	sleep($interval);
}
