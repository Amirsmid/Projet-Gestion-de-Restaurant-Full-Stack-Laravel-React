<?php

namespace App\Http\Controllers;

use App\Models\Commendes;
use Illuminate\Http\Request;
use App\Mail\ReponseMile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class CommendesController extends Controller
{
public function index()
{
    $commendes = Commendes::with(['clients', 'lignieComnd'])
        ->where('etat', '!=', 0)
        ->orderBy('created_at', 'desc')
        ->get();
    return view('pages.commende.index', compact('commendes'));
}

public function show($id)
{
    $commende = Commendes::with(['lignieComnd.articles', 'clients'])->find($id);
    if (!$commende) {
        return redirect()->route('commende.index')->with('error', 'Commande introuvable');
    }
    return view('pages.commende.affiche', compact('commende'));
}

public function updatEtat($id, $etat)
{
    $commende = Commendes::with('clients')->find($id);
    if (!$commende) {
        return redirect()->route('commende.index')->with('error', 'Commande introuvable');
    }

    $commende->etat = $etat;
    $commende->save();

    try {
        $email = $commende->clients->users->email ?? null;
        if ($email) {
            $data = [
                'nom' => $commende->clients->nom . ' ' . $commende->clients->prenom,
                'reservation' => null,
                'type' => $etat,
                'date' => $commende->created_at,
                'personne' => null,
                'commende' => Commendes::with('lignieComnd')->find($id),
            ];
            Mail::to($email)->send(new ReponseMile($data));
        }
    } catch (\Exception $e) {
        Log::error('Erreur envoi email commande: ' . $e->getMessage());
    }

    return redirect()->route('commende.index')->with('success', 'État de la commande mis à jour');
}

public function paniersEnCours()
{
    $paniers = Commendes::where('etat', 0)
        ->with(['clients', 'lignieComnd'])
        ->orderBy('created_at', 'desc')
        ->get();
    return view('pages.commende.paniers', compact('paniers'));
}

public function validerPanierAdmin(Request $request)
{
    $commende = Commendes::with('clients')->find($request->id_commende);

    if (!$commende || $commende->etat !== 0) {
        return redirect()->route('commende.paniers')->with('error', 'Panier invalide');
    }

    if ($commende->lignieComnd->count() === 0) {
        return redirect()->route('commende.paniers')->with('error', 'Le panier est vide');
    }

    $commende->etat = 1;
    $commende->numFact = 'CMD_' . time() . '_' . $commende->id;
    $commende->save();

    try {
        $email = $commende->clients->users->email ?? null;
        if ($email) {
            $data = [
                'nom' => $commende->clients->nom . ' ' . $commende->clients->prenom,
                'reservation' => null,
                'type' => 1,
                'date' => $commende->created_at,
                'personne' => null,
                'commende' => Commendes::with('lignieComnd')->find($commende->id),
            ];
            Mail::to($email)->send(new ReponseMile($data));
        }
    } catch (\Exception $e) {
        Log::error('Erreur envoi email validation panier admin: ' . $e->getMessage());
    }

    return redirect()->route('commende.paniers')->with('success', 'Panier validé avec succès');
}

}
