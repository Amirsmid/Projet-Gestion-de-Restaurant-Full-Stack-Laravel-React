<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ReservationsController;
use App\Http\Controllers\CommendesController;

Route::middleware('api')->group(function () {
    Route::get('parameter',[ApiController::class,'getParameter']);
    Route::get('tout_categorie',[ApiController::class,'listeCategories']);
    Route::get('tout_article',[ApiController::class,'listeArticles']);
    Route::get('article_par_categorie/{id}',[ApiController::class,'articleByCatg']);
    Route::post('inscrit_client',[ApiController::class,'inscritClit']);
    
    // Nouvelle route pour récupérer un client par email
    Route::get('clients/by-email/{email}',[ApiController::class,'getClientByEmail']);
    
    // Routes du panier améliorées
    Route::post('passer_commende',[ApiController::class,'passerCommende']);
    Route::post('lignie_commende',[ApiController::class,'lignieCommende']);
    Route::post('modifier_quantite',[ApiController::class,'modifierQuantite']);
    Route::post('supprimer_article',[ApiController::class,'supprimerArticle']);
    Route::post('vider_panier',[ApiController::class,'viderPanier']);
    Route::get('get_panier/{id}',[ApiController::class,'getPanier']);
    Route::post('valider_panier',[ApiController::class,'validerPanier']);
    
    Route::post('passer_reservation',[ApiController::class,'reservation']);
    Route::post('contacter_nous',[ApiController::class,'contacte']);
});

Route::group([
    'prefix' => 'auth'
    ], function ($router) {
    Route::post('/login', [ApiController::class, 'login']);
});

Route::get('/commande/updatEtat/{id}/{etat}', [CommendesController::class, 'updatEtat'])->name('commende.updatEtat');
Route::get('/reservation/updatEtat/{id}/{etat}', [ReservationsController::class, 'updatEtat'])->name('reservation.updatEtat');



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('jwt');
