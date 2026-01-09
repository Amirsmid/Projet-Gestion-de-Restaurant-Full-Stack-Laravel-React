<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    public function index()
    {
        $clients=Clients::where('etat',0)->get();
        $type=0;
        return view('pages.clients.index', compact('clients','type'));
    }

    public function indexArchiv()
    {
        $clients=Clients::where('etat',1)->get();
        $type=1;
        return view('pages.clients.index', compact('clients','type'));
    }

    public function action($id)
    {
        $clients=Clients::find($id);
        return view('pages.clients.action' , compact('categorie'));
    }

    public function makeAction(Request $request)
    {
        if($request->id == -1){
            Clients::create([
                'nom'=> $request->input('nom'),
                'prenom'=> $request->input('prenom'),
                'adresse'=> $request->input('adresse'),
                'telephone'=> $request->input('telephone'),
            ]);
        }else{
            $client=Clients::find($request->id);
            $client->nom=$request->input('nom');
            $client->prenom=$request->input('prenom');
            $client->adresse=$request->input('adresse');
            $client->telephone=$request->input('telephone');
            $client->save();
        }
        
        return redirect()->route('client.index');
    }


    public function archive($id,$etat){
        $client=Clients::find($id);
        $client->etat=$etat;
        $client->save();
        return redirect()->route('client.index');
    }
}
