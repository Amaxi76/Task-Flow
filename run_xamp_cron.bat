@echo off
REM Démarrer Apache et MySQL via XAMPP
echo Starting XAMPP services...
start "" "C:\xampp\xampp_start.exe"

REM Attendre quelques secondes pour que les services démarrent
timeout /t 5 > nul

REM Démarrer le script PHP cron_runner.php
echo Starting cron_runner.php...
start "" "C:\xampp\php\php.exe" "C:\xampp\htdocs\Task-Flow\script\cron_runner.php"

REM Garder la fenêtre ouverte pour le suivi
echo All services started. Press any key to close this window.
pause
