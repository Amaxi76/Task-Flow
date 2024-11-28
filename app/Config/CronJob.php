<?php namespace App\Config;

use Daycry\CronJob\Config\CronJob as BaseCronJob;
use Daycry\CronJob\Scheduler;
use \App\Controllers\EmailControleur;

class CronJob extends BaseCronJob
{
	public function init(Scheduler $schedule)
	{
		// Exemple d'envoi d'email tous les jours à 8h00
		$schedule->call(function() {
			$emailController = new EmailControleur();
			$emailController->sendEmail();
		})->everyMinute(2);
	}
}