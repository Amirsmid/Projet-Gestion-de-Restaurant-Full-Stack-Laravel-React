<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parameters;
use App\Models\Categories;
use App\Models\Articles;
use App\Models\Clients;
use App\Models\User;
use App\Models\Commendes;
use App\Models\CommendeLignies;
use App\Models\Reservations;
use App\Models\Contacts;
use App\Mail\ReponseMile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Response;

class ApiController extends Controller
{
    public function getParameter(){
        $parameter=Parameters::first();
        return response()->json($parameter);
    }

    public function listeCategories(){
        $categories = Categories::select('id','nom','logo')->where('etat',0)->get()->toArray();
        return array_reverse($categories);
    }

    public function listeArticles(){
        $categories = Articles::select('id','nom','logo','description','prix','id_categorie')->where('etat',0)->get()->toArray();
        return array_reverse($categories);
    }

    public function articleByCatg($id)
    {
        $articles= Articles::where('id_categorie', $id)->with('categories')->get()->toArray();
        return response()->json($articles);
    }

    public function inscritClit(Request $request){
        // Validation des données
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'adresse' => 'required|string|max:500',
            'telephone' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Données invalides',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            // Vérifier si l'utilisateur existe déjà
            $existingUser = User::where('email', $request->email)->first();
            if ($existingUser) {
                return response()->json([
                    'success' => false,
                    'message' => 'Un compte avec cet email existe déjà',
                    'errors' => ['email' => ['Cet email est déjà utilisé']]
                ], 400);
            }

            // Créer l'utilisateur
            $user = User::create([
                'name' => $request->input('nom') . ' ' . $request->input('prenom'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'role' => 0, // Client par défaut
            ]);

            // Créer le client
            $client = Clients::create([
                'nom' => $request->input('nom'),
                'prenom' => $request->input('prenom'),
                'adresse' => $request->input('adresse'),
                'telephone' => $request->input('telephone'),
                'id_user' => $user->id,
                'etat' => 0, // Actif
            ]);

            // Charger les relations pour la réponse
            $user->load('client');

            // Générer un token JWT pour l'authentification
            $token = JWTAuth::fromUser($user);

            return response()->json([
                'success' => true,
                'message' => 'Compte créé avec succès !',
                'user_id' => $user->id,
                'client_id' => $client->id,
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'nom' => $client->nom,
                    'prenom' => $client->prenom,
                    'email' => $user->email,
                    'adresse' => $client->adresse,
                    'telephone' => $client->telephone,
                    'client_id' => $client->id,
                    'role' => $user->role
                ],
                'type' => 'nouveau'
            ], 201);

        } catch (\Exception $e) {
            // En cas d'erreur, nettoyer ce qui a été créé
            if (isset($user)) {
                $user->delete();
            }
            if (isset($client)) {
                $client->delete();
            }

            Log::error('Erreur lors de la création du compte: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création du compte: ' . $e->getMessage(),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Méthode améliorée pour créer une commande (panier ou commande directe)
    public function passerCommende(Request $request){
        // Validation des données
        $validator = Validator::make($request->all(), [
            'id_client' => 'required|integer|exists:clients,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Données invalides',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            // Vérifier que le client existe et est actif
            $client = Clients::find($request->input('id_client'));
            if (!$client) {
                return response()->json([
                    'success' => false,
                    'message' => 'Client introuvable'
                ], 404);
            }

            if ($client->etat !== 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Client inactif'
                ], 400);
            }

            // Vérifier s'il y a déjà un panier en cours pour ce client
            $panierExistant = Commendes::where('id_client', $request->input('id_client'))
                ->where('etat', 0) // 0 = panier en cours
                ->first();

            if ($panierExistant) {
                return response()->json([
                    'success' => true,
                    'message' => 'Panier existant récupéré',
                    'commande_id' => $panierExistant->id,
                    'type' => 'existant'
                ]);
            }

            // Créer un nouveau panier
            $commande = Commendes::create([
                'id_client' => $request->input('id_client'),
                'prix' => 0, // Initialiser le prix à 0
                'etat' => 0, // 0 = panier en cours
                'numFact' => 'PANIER_' . time() // Numéro temporaire pour le panier
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Nouveau panier créé',
                'commande_id' => $commande->id,
                'type' => 'nouveau'
            ], 201);

        } catch (\Exception $e) {
            Log::error('Erreur lors de la création de la commande: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création de la commande',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Méthode améliorée pour ajouter des articles au panier
    public function lignieCommende(Request $request){
        // Validation des données
        $validator = Validator::make($request->all(), [
            'id_article' => 'required|integer',
            'prixU' => 'required|numeric|min:0',
            'quantite' => 'required|integer|min:1',
            'id_commende' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Données invalides',
                'errors' => $validator->errors()
            ], 400);
        }

        // Vérifier que la commande existe
        $commende = Commendes::find($request->id_commende);
        if (!$commende) {
            return response()->json([
                'success' => false,
                'message' => 'Commande introuvable'
            ], 400);
        }

        // Vérifier que l'article existe
        $article = Articles::find($request->id_article);
        if (!$article) {
            return response()->json([
                'success' => false,
                'message' => 'Article introuvable'
            ], 400);
        }

        // Vérifier si l'article existe déjà dans la commande
        $ligneExistante = CommendeLignies::where('id_commende', $request->id_commende)
            ->where('id_article', $request->id_article)
            ->first();

        if ($ligneExistante) {
            // Mettre à jour la quantité existante
            $ancienneQuantite = $ligneExistante->quantite;
            $nouvelleQuantite = $ancienneQuantite + $request->quantite;
            
            $ligneExistante->quantite = $nouvelleQuantite;
            $ligneExistante->prixT = $ligneExistante->prixU * $nouvelleQuantite;
            $ligneExistante->save();

            // Recalculer le prix total de la commande
            $this->recalculerPrixTotal($commende);

            return response()->json([
                'success' => true,
                'message' => 'Quantité mise à jour dans la commande',
                'ligne_id' => $ligneExistante->id,
                'nouvelle_quantite' => $nouvelleQuantite
            ]);
        }

        // Créer une nouvelle ligne
        $lignieCommande = CommendeLignies::create([
            'id_article' => $request->input('id_article'),
            'prixU' => $request->input('prixU'),
            'quantite' => $request->input('quantite'),
            'prixT' => $request->input('prixU') * $request->input('quantite'),
            'id_commende' => $request->input('id_commende'),
        ]);

        // Recalculer le prix total de la commande
        $this->recalculerPrixTotal($commende);

        return response()->json([
            'success' => true,
            'message' => 'Article ajouté à la commande',
            'ligne_id' => $lignieCommande->id
        ]);
    }

    // Nouvelle méthode pour modifier la quantité d'un article
    public function modifierQuantite(Request $request){
        $validator = Validator::make($request->all(), [
            'ligne_id' => 'required|exists:commende_lignies,id',
            'quantite' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Données invalides',
                'errors' => $validator->errors()
            ], 400);
        }

        $ligne = CommendeLignies::find($request->ligne_id);
        if (!$ligne) {
            return response()->json([
                'success' => false,
                'message' => 'Ligne de commande introuvable'
            ], 404);
        }

        // Mettre à jour la quantité
        $ligne->quantite = $request->quantite;
        $ligne->prixT = $ligne->prixU * $request->quantite;
        $ligne->save();

        // Recalculer le prix total de la commande
        $commende = Commendes::find($ligne->id_commende);
        $this->recalculerPrixTotal($commende);

        return response()->json([
            'success' => true,
            'message' => 'Quantité modifiée',
            'nouvelle_quantite' => $request->quantite,
            'nouveau_prix' => $ligne->prixT
        ]);
    }

    // Nouvelle méthode pour supprimer un article du panier
    public function supprimerArticle(Request $request){
        $validator = Validator::make($request->all(), [
            'ligne_id' => 'required|exists:commende_lignies,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Données invalides',
                'errors' => $validator->errors()
            ], 400);
        }

        $ligne = CommendeLignies::find($request->ligne_id);
        if (!$ligne) {
            return response()->json([
                'success' => false,
                'message' => 'Ligne de commande introuvable'
            ], 404);
        }

        $idCommende = $ligne->id_commende;
        
        // Supprimer la ligne
        $ligne->delete();

        // Recalculer le prix total de la commande
        $commende = Commendes::find($idCommende);
        $this->recalculerPrixTotal($commende);

        return response()->json([
            'success' => true,
            'message' => 'Article supprimé du panier'
        ]);
    }

    // Nouvelle méthode pour vider le panier
    public function viderPanier(Request $request){
        $validator = Validator::make($request->all(), [
            'id_commende' => 'required|exists:commendes,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Données invalides',
                'errors' => $validator->errors()
            ], 400);
        }

        $commende = Commendes::find($request->id_commende);
        if (!$commende || $commende->etat !== 0) { // 0 = panier
            return response()->json([
                'success' => false,
                'message' => 'Commande invalide ou pas un panier'
            ], 400);
        }

        // Supprimer toutes les lignes
        CommendeLignies::where('id_commende', $request->id_commende)->delete();
        
        // Remettre le prix à 0
        $commende->prix = 0;
        $commende->save();

        return response()->json([
            'success' => true,
            'message' => 'Panier vidé'
        ]);
    }

    // Nouvelle méthode pour récupérer le contenu du panier
    public function getPanier(Request $request){
        $validator = Validator::make($request->all(), [
            'id_commende' => 'required|exists:commendes,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Données invalides',
                'errors' => $validator->errors()
            ], 400);
        }

        $commende = Commendes::with(['lignieComnd.articles'])->find($request->id_commende);
        if (!$commende) {
            return response()->json([
                'success' => false,
                'message' => 'Commande introuvable'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'panier' => $commende
        ]);
    }

    // Nouvelle méthode pour valider le panier (passer la commande)
    public function validerPanier(Request $request){
        $validator = Validator::make($request->all(), [
            'id_commende' => 'required|exists:commendes,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Données invalides',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $commende = Commendes::with(['clients.user'])->find($request->id_commende);
            if (!$commende) {
                return response()->json([
                    'success' => false,
                    'message' => 'Commande introuvable'
                ], 404);
            }

            if ($commende->etat !== 0) { // 0 = panier
                return response()->json([
                    'success' => false,
                    'message' => 'Cette commande n\'est pas un panier'
                ], 400);
            }

            // Vérifier que le panier n'est pas vide
            $lignes = CommendeLignies::where('id_commende', $request->id_commende)->count();
            if ($lignes === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Le panier est vide'
                ], 400);
            }

            // Vérifier que le prix total est correct
            $prixTotal = CommendeLignies::where('id_commende', $request->id_commende)->sum('prixT');
            if ($prixTotal <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Le prix total est invalide'
                ], 400);
            }

            // Générer un numéro de facture unique
            $commende->numFact = 'FACT_' . date('Ymd') . '_' . str_pad($commende->id, 6, '0', STR_PAD_LEFT);
            $commende->prix = $prixTotal;
            $commende->etat = 1; // 1 = en attente
            $commende->save();

            // Envoyer un email de notification au client
            try {
                if ($commende->clients && $commende->clients->user) {
                    $email = $commende->clients->user->email;
                    $data = [
                        'nom' => $commende->clients->nom . ' ' . $commende->clients->prenom,
                        'reservation' => null,
                        'type' => 1, // Commande en attente
                        'date' => $commende->created_at,
                        'personne' => null,
                        'commende' => Commendes::with('lignieComnd.articles')->find($commende->id),
                    ];
                    Mail::to($email)->send(new ReponseMile($data));
                }
            } catch (\Exception $e) {
                Log::error('Erreur envoi email validation panier: ' . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'Panier validé, commande en attente',
                'num_facture' => $commende->numFact,
                'prix_total' => $commende->prix,
                'commande_id' => $commende->id
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur lors de la validation du panier: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la validation du panier',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Méthode privée pour recalculer le prix total
    private function recalculerPrixTotal($commende){
        $prixTotal = CommendeLignies::where('id_commende', $commende->id)
            ->sum('prixT');
        
        $commende->prix = $prixTotal;
        $commende->save();
    }

    public function reservation(Request $request){
        // Validation des données
        $validator = Validator::make($request->all(), [
            'id_client' => 'required|integer|exists:clients,id',
            'date' => 'required|string',
            'nb_pers' => 'required|integer|min:1|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Données invalides',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            // Vérifier que le client existe et est actif
            $client = Clients::find($request->input('id_client'));
            if (!$client) {
                return response()->json([
                    'success' => false,
                    'message' => 'Client introuvable'
                ], 404);
            }

            if ($client->etat !== 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Client inactif'
                ], 400);
            }

            // Traiter la date (extraire seulement la partie date)
            $dateTime = \Carbon\Carbon::parse($request->input('date'));
            $dateOnly = $dateTime->format('Y-m-d');
            
            // Vérifier que la date n'est pas dans le passé
            if ($dateTime->isPast()) {
                return response()->json([
                    'success' => false,
                    'message' => 'La date de réservation ne peut pas être dans le passé',
                    'errors' => ['date' => ['Date invalide']]
                ], 400);
            }

            // Vérifier s'il n'y a pas déjà une réservation pour ce client à cette date
            $reservationExistante = Reservations::where('id_client', $request->input('id_client'))
                ->where('date', $dateOnly)
                ->where('etat', '!=', 2) // Exclure les réservations annulées
                ->first();

            if ($reservationExistante) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vous avez déjà une réservation pour cette date',
                    'errors' => ['date' => ['Réservation existante']]
                ], 400);
            }

            // Créer la réservation
            $reservation = Reservations::create([
                'id_client' => $request->input('id_client'),
                'date' => $dateOnly,
                'nb_pers' => $request->input('nb_pers'),
                'etat' => 0, // 0 = en attente par défaut
            ]);

            // Envoyer un email de confirmation
            try {
                if ($client->user) {
                    $email = $client->user->email;
                    $data = [
                        'nom' => $client->nom . ' ' . $client->prenom,
                        'reservation' => $reservation,
                        'type' => 2, // Réservation en attente
                        'date' => $reservation->date,
                        'personne' => $reservation->nb_pers,
                        'commende' => null,
                    ];
                    Mail::to($email)->send(new ReponseMile($data));
                }
            } catch (\Exception $e) {
                Log::error('Erreur envoi email réservation: ' . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'Réservation effectuée avec succès !',
                'reservation_id' => $reservation->id,
                'date' => $reservation->date,
                'nb_pers' => $reservation->nb_pers
            ], 201);

        } catch (\Exception $e) {
            Log::error('Erreur lors de la création de la réservation: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création de la réservation',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function contacte(Request $request){
        // Validation des données
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'contenue' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Données invalides',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $contact = Contacts::create([
                'nom' => $request->input('nom'),
                'email' => $request->input('email'),
                'contenue' => $request->input('contenue'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Message envoyé avec succès !',
                'contact_id' => $contact->id
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'envoi du message',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Nouvelle méthode pour récupérer un client par email
    public function getClientByEmail($email){
        try {
            $client = Clients::whereHas('user', function($query) use ($email) {
                $query->where('email', $email);
            })->first();

            if ($client) {
                return response()->json([
                    'success' => true,
                    'message' => 'Client trouvé',
                    'client_id' => $client->id,
                    'client' => $client
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Client non trouvé'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la recherche du client',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function login(Request $request){
        // Validation des données
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Données invalides',
                'errors' => $validator->errors()
            ], 400);
        }

        $input = $request->only('email', 'password');
        
        try {
            if (!$jwt_token = JWTAuth::attempt($input)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email ou mot de passe incorrect',
                ], Response::HTTP_UNAUTHORIZED);
            }

            $user = Auth::user();
            
            return response()->json([
                'success' => true,
                'message' => 'Connexion réussie',
                'token' => $jwt_token,
                'user' => $user,
                'token_type' => 'bearer',
                'expires_in' => config('jwt.ttl') * 60
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la connexion',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
