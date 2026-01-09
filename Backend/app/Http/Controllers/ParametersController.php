<?php

namespace App\Http\Controllers;

use App\Models\Parameters;
use Illuminate\Http\Request;

class ParametersController extends Controller
{
    public function index()
    {
        $parameter=Parameters::first();
        return view("pages.parameter",compact('parameter'));
    }

    public function editParam(Request $request){
        $nbParam=Parameters::count();
        $logoName='';
        if ($request->hasFile('img')) {
            $logo = $request->file('img');
            $logoName = time() . '_' . $logo->getClientOriginalName();
            $logo->move(public_path('img'), $logoName);
        }
    
        if($nbParam == 0){
            Parameters::create([
                'nom'=> $request->input('nom'),
                'logo'=> $logoName,
                'email'=> $request->input('email'),
                'adresse'=> $request->input('adresse'),
                'tel'=> $request->input('tel'),
            ]);
        }else{
            $pram=Parameters::first();
            $pram->nom=$request->nom;
            if($logoName!='')
                $pram->logo=$logoName;
            $pram->email=$request->email;
            $pram->adresse=$request->adresse;
            $pram->tel=$request->tel;
            $pram->update();
        }
        return redirect()->route('parameter.index');
    }

}
