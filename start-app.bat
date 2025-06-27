@echo off
start powershell -ExecutionPolicy Bypass -File "C:\Users\marwan\Documents\pfe_2025\risque_alerte\risque-alerte-app\sync-loop.ps1"
php artisan serve
