<?php
/**
 * Script de vérification rapide du système
 * Vérifie que tous les composants nécessaires sont en place
 */

echo "<h1>Vérification du Système Restaurant</h1>\n";

// Vérification de PHP
echo "<h2>1. Vérification de PHP</h2>\n";
echo "Version PHP: " . PHP_VERSION . "\n";
echo "Extensions requises:\n";

$required_extensions = ['pdo', 'pdo_mysql', 'curl', 'json', 'mbstring'];
foreach ($required_extensions as $ext) {
    if (extension_loaded($ext)) {
        echo "✓ $ext\n";
    } else {
        echo "✗ $ext (manquant)\n";
    }
}

// Vérification de Composer
echo "\n<h2>2. Vérification de Composer</h2>\n";
if (file_exists('composer.json')) {
    echo "✓ composer.json trouvé\n";
    $composer = json_decode(file_get_contents('composer.json'), true);
    echo "Nom du projet: " . ($composer['name'] ?? 'Non défini') . "\n";
} else {
    echo "✗ composer.json non trouvé\n";
}

// Vérification de Laravel
echo "\n<h2>3. Vérification de Laravel</h2>\n";
if (file_exists('artisan')) {
    echo "✓ artisan trouvé (Laravel installé)\n";
    
    // Vérifier la version de Laravel
    $output = shell_exec('php artisan --version 2>&1');
    if ($output) {
        echo "Version Laravel: " . trim($output) . "\n";
    }
} else {
    echo "✗ artisan non trouvé (Laravel non installé)\n";
}

// Vérification de la base de données
echo "\n<h2>4. Vérification de la Base de Données</h2>\n";
try {
    // Charger la configuration Laravel
    if (file_exists('vendor/autoload.php')) {
        require_once 'vendor/autoload.php';
        
        if (file_exists('bootstrap/app.php')) {
            $app = require_once 'bootstrap/app.php';
            $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
            
            // Tester la connexion
            $pdo = \Illuminate\Support\Facades\DB::connection()->getPdo();
            echo "✓ Connexion à la base de données réussie\n";
            echo "Base de données: " . \Illuminate\Support\Facades\DB::connection()->getDatabaseName() . "\n";
            
            // Vérifier les tables
            $tables = \Illuminate\Support\Facades\DB::select('SHOW TABLES');
            echo "Tables trouvées: " . count($tables) . "\n";
            
            if (count($tables) > 0) {
                echo "Tables principales:\n";
                $main_tables = ['users', 'clients', 'commendes', 'reservations', 'articles', 'categories'];
                foreach ($main_tables as $table) {
                    $exists = \Illuminate\Support\Facades\DB::getSchemaBuilder()->hasTable($table);
                    echo ($exists ? "✓" : "✗") . " $table\n";
                }
            }
        } else {
            echo "✗ bootstrap/app.php non trouvé\n";
        }
    } else {
        echo "✗ vendor/autoload.php non trouvé (Composer non installé)\n";
    }
    
} catch (Exception $e) {
    echo "✗ Erreur de connexion à la base de données: " . $e->getMessage() . "\n";
    echo "Vérifiez votre fichier .env\n";
}

// Vérification des permissions
echo "\n<h2>5. Vérification des Permissions</h2>\n";
$directories = ['storage', 'bootstrap/cache'];
foreach ($directories as $dir) {
    if (is_writable($dir)) {
        echo "✓ $dir (écriture autorisée)\n";
    } else {
        echo "✗ $dir (écriture refusée)\n";
    }
}

// Vérification des routes
echo "\n<h2>6. Vérification des Routes API</h2>\n";
try {
    if (class_exists('\Illuminate\Support\Facades\Route')) {
        $routes = \Illuminate\Support\Facades\Route::getRoutes();
        $api_routes = 0;
        foreach ($routes as $route) {
            if (strpos($route->getPrefix(), 'api') !== false) {
                $api_routes++;
            }
        }
        echo "Routes API trouvées: $api_routes\n";
    } else {
        echo "Classe Route non disponible\n";
    }
} catch (Exception $e) {
    echo "Impossible de vérifier les routes: " . $e->getMessage() . "\n";
}

echo "\n<h2>Résumé</h2>\n";
echo "Si toutes les vérifications sont marquées ✓, votre système est prêt.\n";
echo "En cas de problème, consultez le fichier SOLUTION_ERREURS.md\n";
echo "\n";
echo "Pour démarrer le projet:\n";
echo "1. Laravel: double-cliquez sur start_project.bat\n";
echo "2. React: double-cliquez sur start_react.bat (dans le dossier GestionRestaurant)\n";
?>
