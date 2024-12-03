<?php
// Intervalle en secondes (par exemple : toutes les 5 minutes)
$interval = 10;

// URL de la nouvelle route
$url = 'http://localhost:8080/cron/run';

// Fichier de log pour suivre l'exécution (facultatif)
$logFile = __DIR__ . '/cron_runner.log';

// Compteurs pour limiter les exécutions et les erreurs consécutives
$compteur = 0;
$errorCount = 0;

// Nombre maximal d'erreurs consécutives avant l'arrêt
$maxErrors = 3;

while (true && $compteur < 20) {
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

		// Incrémenter le compteur d'erreurs
		$errorCount++;
		if ($errorCount >= $maxErrors) {
			file_put_contents($logFile, "[CRITICAL] " . date('Y-m-d H:i:s') . " - Maximum consecutive errors reached. Stopping script." . PHP_EOL, FILE_APPEND);
			break; // Arrêter le script
		}
	} else {
		// Réponse réussie : journaliser la réponse et réinitialiser le compteur d'erreurs
		file_put_contents($logFile, "[SUCCESS] " . date('Y-m-d H:i:s') . " - Response: $response" . PHP_EOL, FILE_APPEND);
		$errorCount = 0; // Réinitialiser le compteur d'erreurs
	}

	// Fermer la session cURL
	curl_close($ch);

	$compteur++;

	// Attendre X secondes avant la prochaine exécution
	sleep($interval);
}
