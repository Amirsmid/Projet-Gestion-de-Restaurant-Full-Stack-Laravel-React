<?php

namespace App\Http\Controllers;

use App\Models\Contacts;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    public function index()
    {
        $contacts = Contacts::orderBy('etat')->get();
        return view('pages.contactes.listes', compact('contacts'));
    }

    public function show($id){
        $contacte=Contacts::find($id);
        $contacte->etat=1;
        $contacte->update();
        return view('pages.contactes.affiche', compact('contacte'));
    }
}
