@extends('layout.main')

@section('content')
    <div class="col-md-8 grid-margin stretch-card offset-2">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    @if (isset($article))
                        Modifier
                    @else
                        Ajouter
                    @endif
                    un article
                </h4>
                <form class="forms-sample" action="{{ route('make_action_article') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input hidden name="id" value="{{ isset($article) ? $article->id : -1 }}">
                    <div class="form-group row">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Nom</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nom" name="nom"
                                value="{{ isset($article) ? $article->nom : null }}" required
                                placeholder="Choisir le nom de l'article ...">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Logo</label>
                        <div class="col-sm-9">
                            <input type="file" name="img" class="file-upload-default">
                            <div class="input-group col-xs-12">
                                <input type="text" class="form-control file-upload-info" disabled
                                    placeholder="Choisir un logo ..." id="logo" name="logo" required>
                                <span>
                                    <button class="file-upload-browse btn btn-primary" type="button">Charger</button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Description</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="description" name="description" rows="4" required>
                                {{ isset($article) ? $article->description : null }}
                            </textarea>
                        </div>
                    </div>
                    <div class="form-group
                                row">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Prix</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="prix" name="prix"
                                value="{{ isset($article) ? $article->prix : null }}" required
                                placeholder="Choisir le prix de l'article ...">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Catégories</label>
                        <div class="col-sm-9">
                            <select class="form-control form-control-sm @error('id_categorie') is-invalid @enderror"
                                id="id_categorie" name="id_categorie" required>
                                <option selected disabled>Choisir une catégorie</option>
                                @foreach ($categories as $categorie)
                                    @if (isset($article) && $categorie->id == $article->id_categorie)
                                        <option value="{{ $categorie->id }}" selected>{{ $categorie->nom }}</option>
                                    @else
                                        <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('id_categorie')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success mr-2">Enregister</button>
                    <button class="btn btn-light">Annuler</button>
                </form>
            </div>
        </div>
    </div>
@endsection
