<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class CronFilter implements FilterInterface
{
	public function before(RequestInterface $request, $arguments = null)
	{
		// Vérifiez si c'est le moment d'exécuter la tâche
		$lastRun = cache('last_cron_run') ?? 0;
		$interval = 120; // Intervalle en secondes (2 minutes)

		if (time() - $lastRun >= $interval) {
			// Mettez à jour le cache pour éviter une exécution multiple
			cache()->save('last_cron_run', time(), $interval);

			// Exécutez la tâche planifiée
			$cronController = new \App\Controllers\Cron();
			$cronController->envoyerRappelsTaches();
		}
	}

	public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
	{
		// Pas besoin d'actions après la requête
	}
}
