<?php

namespace App\Http\Controllers;

use App\Models\Articles;
use App\Models\Categories;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    public function index()
    {
        $articles=Articles::where('etat',0)->get();
        $type=0;
        return view('pages.articles.index', compact('articles','type'));
    }

    public function indexArchiv()
    {
        $articles=Articles::where('etat',1)->get();
        $type=1;
        return view('pages.articles.index', compact('articles','type'));
    }

    public function action($id)
    {
        $categories = Categories::where('etat',0)->get();
        $article = Articles::find($id);
        return view('pages.articles.action' , compact('article','categories'));
    }

    public function makeAction(Request $request){
        $validatedData = $request->validate([
            'id_categorie' => 'required|exists:categories,id', // Ensure it's a valid category ID
        ]);
        $logoName='';
        if ($request->hasFile('img')) {
            $logo = $request->file('img');
            $logoName = time() . '_' . $logo->getClientOriginalName();
            $logo->move(public_path('img'), $logoName);
        }
        if($request->id == -1){
            Articles::create([
                'nom'=> $request->input('nom'),
                'logo'=> $logoName,
                'description'=> $request->input('description'),
                'prix'=> $request->input('prix'),
                'id_categorie'=> $request->input('id_categorie'),
            ]);
        }else{
            $article=Articles::find($request->id);
            $article->nom=$request->input('nom');
            if($logoName!='')
                $article->logo=$logoName;
            $article->description=$request->input('description');
            $article->prix=$request->input('prix');
            $article->id_categorie=$request->input('id_categorie');
            $article->save();
        }
        
        return redirect()->route('article.index');
    }


    public function archive($id,$etat){
        $article=Articles::find($id);
        $article->etat=$etat;
        $article->save();
        return redirect()->route('article.index');
    }
}
