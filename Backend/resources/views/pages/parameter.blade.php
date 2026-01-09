@extends('layout.main')

@section('content')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Gestion des paramètres du site </h4>

                <form class="forms-sample row" action="{{ route('modifier_parameter') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="col-lg-12"
                            style='display: flex;justify-content: space-around;'>
                        @if (isset($parameter->logo))
                            <img src='{{ asset('img') }}/{{ $parameter->logo }}' width='200'>
                        @endif
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="exampleInputName1">Nom</label>
                        <input type="text" class="form-control" id="nom" name="nom"
                            value='{{ isset($parameter->nom) ? $parameter->nom : '' }}'
                            placeholder="Choisir le nom du site ...">
                    </div>
                    <div class="form-group col-lg-6">
                        <label>Logo</label>
                        <input type="file" name="img" class="file-upload-default">
                        <div class="input-group col-xs-12">
                            <input type="text" class="form-control file-upload-info" disabled
                                placeholder="Choisir un logo ..." id="logo" name="logo">
                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-primary" type="button">Charger</button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="exampleInputEmail3">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value='{{ isset($parameter->email) ? $parameter->email : '' }}'
                            placeholder="Choisir un email ...">
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="exampleInputPassword4">Téléphone</label>
                        <input type="number" class="form-control" id="tel" name="tel"
                            value='{{ isset($parameter->tel) ? $parameter->tel : '' }}'
                            placeholder="Choisir un numéro de téléphone ...">
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="exampleInputPassword4">Adresse</label>
                        <input type="text" class="form-control" id="adresse" name="adresse"
                            value='{{ isset($parameter->adresse) ? $parameter->adresse : '' }}'
                            placeholder="Choisir une adresse ...">
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                </form>
            </div>
        </div>
    </div>
@endsection
