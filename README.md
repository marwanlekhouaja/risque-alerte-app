Cette application a été développée avec le framework Laravel et utilise une base de données SQL Server. Elle est conçue pour fonctionner en environnement local avec XAMPP pour la gestion du serveur web (Apache/MySQL – ici utilisé pour Apache uniquement).

⚙️ Prérequis
Avant de lancer le projet, assurez-vous d’avoir installé les outils suivants :

PHP (version compatible Laravel, recommandé : PHP 8.x)

Composer

Laravel CLI

SQL Server (avec la base de données configurée)

XAMPP (utilisé pour Apache)

PowerShell (pour exécuter le script sync-loop.ps1)

Installation et Lancement du Projet en Local

composer install
npm install && npm run dev

cp .env.example .env

Puis adapter les paramètres suivants pour correspondre à votre environnement SQL Server (env file) :
DB_CONNECTION=sqlsrv
DB_HOST=localhost
DB_PORT=1433
DB_DATABASE=nom_de_la_base
DB_USERNAME=utilisateur
DB_PASSWORD=motdepasse

Générer la clé d’application Laravel : php artisan key:generate
Démarrer le serveur Apache via XAMPP.

executer le projet via sync-loop.ps1 file