<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categories;
use App\Models\Articles;
use App\Models\Parameters;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Créer des paramètres
        Parameters::create([
            'nom' => 'Restaurant Delicious',
            'adresse' => '123 Rue de la Gastronomie',
            'tel' => '+33 1 23 45 67 89',
            'email' => 'contact@delicious.com',
            'logo' => 'logo.png',
            'caisse' => 0
        ]);

        // Créer des catégories
        $categories = [
            ['nom' => 'Entrées', 'logo' => 'entrees.jpg', 'etat' => 0],
            ['nom' => 'Plats Principaux', 'logo' => 'plats.jpg', 'etat' => 0],
            ['nom' => 'Desserts', 'logo' => 'desserts.jpg', 'etat' => 0],
            ['nom' => 'Boissons', 'logo' => 'boissons.jpg', 'etat' => 0],
        ];

        foreach ($categories as $cat) {
            Categories::create($cat);
        }

        // Créer des articles
        $articles = [
            // Entrées
            ['nom' => 'Salade César', 'description' => 'Salade fraîche avec poulet grillé', 'prix' => 12.50, 'id_categorie' => 1, 'logo' => 'salade-cesar.jpg', 'etat' => 0],
            ['nom' => 'Soupe à l\'Oignon', 'description' => 'Soupe traditionnelle française', 'prix' => 8.90, 'id_categorie' => 1, 'logo' => 'soupe-oignon.jpg', 'etat' => 0],
            ['nom' => 'Bruschetta', 'description' => 'Pain grillé avec tomates et basilic', 'prix' => 7.50, 'id_categorie' => 1, 'logo' => 'bruschetta.jpg', 'etat' => 0],
            
            // Plats Principaux
            ['nom' => 'Steak Frites', 'description' => 'Steak de bœuf avec frites maison', 'prix' => 24.90, 'id_categorie' => 2, 'logo' => 'steak-frites.jpg', 'etat' => 0],
            ['nom' => 'Poulet Rôti', 'description' => 'Poulet fermier rôti aux herbes', 'prix' => 18.50, 'id_categorie' => 2, 'logo' => 'poulet-roti.jpg', 'etat' => 0],
            ['nom' => 'Poisson du Jour', 'description' => 'Poisson frais du marché', 'prix' => 22.00, 'id_categorie' => 2, 'logo' => 'poisson.jpg', 'etat' => 0],
            ['nom' => 'Pâtes Carbonara', 'description' => 'Pâtes à la crème et lardons', 'prix' => 16.90, 'id_categorie' => 2, 'logo' => 'pates-carbonara.jpg', 'etat' => 0],
            
            // Desserts
            ['nom' => 'Tiramisu', 'description' => 'Dessert italien traditionnel', 'prix' => 8.50, 'id_categorie' => 3, 'logo' => 'tiramisu.jpg', 'etat' => 0],
            ['nom' => 'Crème Brûlée', 'description' => 'Crème vanille caramélisée', 'prix' => 7.90, 'id_categorie' => 3, 'logo' => 'creme-brulee.jpg', 'etat' => 0],
            ['nom' => 'Mousse au Chocolat', 'description' => 'Mousse légère au chocolat noir', 'prix' => 8.00, 'id_categorie' => 3, 'logo' => 'mousse-chocolat.jpg', 'etat' => 0],
            
            // Boissons
            ['nom' => 'Coca Cola', 'description' => 'Soda rafraîchissant', 'prix' => 3.50, 'id_categorie' => 4, 'logo' => 'coca-cola.jpg', 'etat' => 0],
            ['nom' => 'Vin Rouge', 'description' => 'Verre de vin rouge de la maison', 'prix' => 6.00, 'id_categorie' => 4, 'logo' => 'vin-rouge.jpg', 'etat' => 0],
            ['nom' => 'Eau Minérale', 'description' => 'Eau minérale naturelle', 'prix' => 2.50, 'id_categorie' => 4, 'logo' => 'eau.jpg', 'etat' => 0],
        ];

        foreach ($articles as $art) {
            Articles::create($art);
        }
    }
}
