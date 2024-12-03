<?php
/* UTILISATION
Dans un terminal : php HashMotDePasse.php <MonMotDePasse>
*/

if ($argc < 2) {
	echo "Veuillez fournir un mot de passe en paramètre.\n";
	exit(1);
}

$motDePasse = $argv[1];

// Générer le hachage du mot de passe
$hash = password_hash($motDePasse, PASSWORD_DEFAULT);

echo "Le mot de passe haché est : $hash\n";
?>
