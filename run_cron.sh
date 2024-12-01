#!/bin/bash

# Démarrer le serveur PHP Spark
echo "Starting PHP Spark server..."
php spark serve &

# Attendre quelques secondes pour que le serveur démarre
sleep 5

# Démarrer le script PHP cron_runner.php
echo "Starting cron_runner.php..."
php script/cron_runner.php &

# Garder le script en cours d'exécution
echo "All services started. Press Ctrl+C to stop."
wait