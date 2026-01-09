<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ParametersController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\CommendesController;
use App\Http\Controllers\ReservationsController;
use App\Http\Controllers\ContactsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    /* parameter */
    Route::resource("parameter", ParametersController::class);
    Route::post('modifier_parameter', [ParametersController::class, 'editParam'])->name('modifier_parameter');

    /* categories */
    Route::get('categorie', [CategoriesController::class, 'index'])->name('categorie.index');
    Route::get('action_categorie/{id}', [CategoriesController::class, 'action'])->name('action_categorie');
    Route::post('make_action', [CategoriesController::class, 'makeAction'])->name('make_action');
    Route::get('modif_etat_categorie/{id}/{etat}', [CategoriesController::class, 'archive'])->name('modif_etat_categorie');
    Route::get('categories_archive', [CategoriesController::class, 'indexArchiv'])->name('categories_archive');
    Route::get('categorie_articles/{id}', [CategoriesController::class, 'produitsCateg'])->name('categorie_articles');

    /* articles  */
    Route::get('article', [ArticlesController::class, 'index'])->name('article.index');
    Route::get('action_article/{id}', [ArticlesController::class, 'action'])->name('action_article');
    Route::post('make_action_article', [ArticlesController::class, 'makeAction'])->name('make_action_article');
    Route::get('modif_etat_article/{id}/{etat}', [ArticlesController::class, 'archive'])->name('modif_etat_article');
    Route::get('articles_archive', [ArticlesController::class, 'indexArchiv'])->name('articles_archive');

    /* clients  */
    Route::get('client', [ClientsController::class, 'index'])->name('client.index');
    Route::get('modif_etat_client/{id}/{etat}', [ClientsController::class, 'archive'])->name('modif_etat_client');
    Route::get('clients_archive', [ClientsController::class, 'indexArchiv'])->name('clients_archive');

    /* commende  */
    Route::get('commende', [CommendesController::class, 'index'])->name('commende.index');
    Route::get('commende/paniers', [CommendesController::class, 'paniersEnCours'])->name('commende.paniers');
    Route::get('detaille_commende/{id}', [CommendesController::class, 'show'])->name('detaille_commende');
    Route::get('modif_etat_commende/{id}/{etat}', [CommendesController::class, 'updatEtat'])->name('modif_etat_commende');
    Route::post('valider_panier_admin', [CommendesController::class, 'validerPanierAdmin'])->name('valider_panier_admin');

    /* reservation  */
    Route::get('reservation', [ReservationsController::class, 'index'])->name('reservation.index');
    Route::get('modif_etat_reservation/{id}/{etat}', [ReservationsController::class, 'updatEtat'])->name('modif_etat_reservation');
    
    /* contactes */
    Route::resource("contactes", ContactsController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
