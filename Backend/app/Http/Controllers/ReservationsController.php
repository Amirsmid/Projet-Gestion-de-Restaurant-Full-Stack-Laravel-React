<?php

namespace App\Http\Controllers;

use App\Models\Reservations;
use Illuminate\Http\Request;
use App\Mail\ReponseMile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ReservationsController extends Controller
{
   public function index()
{
    $reservations = Reservations::with('clients')
        ->orderBy('created_at', 'desc')
        ->get();
    return view('pages.reservation', compact('reservations'));
}

public function updatEtat($id, $etat)
{
    $reserv = Reservations::with('clients')->find($id);

    if (!$reserv) {
        return redirect()->route('reservation.index')->with('error', 'Réservation introuvable');
    }

    $reserv->etat = $etat;
    $reserv->save();

    try {
        $email = $reserv->clients->users->email ?? null;
        if ($email) {
            $data = [
                'nom' => $reserv->clients->nom . ' ' . $reserv->clients->prenom,
                'reservation' => 1,
                'type' => $etat,
                'date' => $reserv->date,
                'personne' => $reserv->nb_pers,
            ];
            Mail::to($email)->send(new ReponseMile($data));
        }
    } catch (\Exception $e) {
        Log::error('Erreur envoi email réservation: ' . $e->getMessage());
    }

    return redirect()->route('reservation.index')->with('success', 'État de la réservation mis à jour');
}

}
