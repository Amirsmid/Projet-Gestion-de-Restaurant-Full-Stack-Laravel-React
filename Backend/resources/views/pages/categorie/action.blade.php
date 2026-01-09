@extends('layout.main')

@section('content')
    <div class="col-md-8 grid-margin stretch-card offset-2">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    @if (isset($categorie))
                        Modifier
                    @else
                        Ajouter
                    @endif
                    une catégorie
                </h4>
                <form class="forms-sample" action="{{ route('make_action') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    <input hidden name="id" value="{{ isset($categorie) ? $categorie->id : -1}}">
                    <div class="form-group row">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Nom</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nom" name="nom" value="{{ isset($categorie) ? $categorie->nom : null}}" required
                                placeholder="Choisir le nom de la catégorie ...">
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
                    <button type="submit" class="btn btn-success mr-2">Enregister</button>
                    <button class="btn btn-light">Annuler</button>
                </form>
            </div>
        </div>
    </div>
@endsection
