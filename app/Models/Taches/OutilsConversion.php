<?php 
namespace App\Models\Taches;

use DateTime;

class OutilsConversion
{
	private const UNITES = [
		'heure'  => 'hours',
		'jour'   => 'days',
		'semaine'=> 'weeks',
		'mois'   => 'months',
		'annee'  => 'years'
	];

	public static function convertirEnMinutes($valeur, string $unite) {
		if ( empty($valeur) || $valeur <= 0 ) {
			return 0;
		}

		$unite = strtolower($unite);
		if (!isset( self::UNITES[$unite] )) {
			throw new \InvalidArgumentException("Unité de temps non valide : $unite");
		}
	
		$now    = new DateTime();
		$future = (clone $now)->modify('+' . $valeur . self::UNITES[$unite] . '');
	
		return (int)( ($future->getTimestamp() - $now->getTimestamp()) / 60 );
	}

	public static function convertirMinutesEnUnite($valeur, string $unite) : int {
		if ( empty($valeur) || $valeur <= 0) {
			return 0;
		}

		$unite = strtolower($unite);
		if (!isset( self::UNITES[$unite] )) {
			throw new \InvalidArgumentException("Unité de temps non valide : $unite");
		}

		// Facteur de conversion
		$now    = new DateTime();
		$future = (clone $now)->modify('+1 ' . self::UNITES[$unite]);
		$conversionFactor = ($future->getTimestamp() - $now->getTimestamp()) / 60;

		return round($valeur / $conversionFactor, 2);
	}
}