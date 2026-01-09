@extends('layout.main')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-sm-around align-items-baseline">
                    <h4 class="card-title">Listes des catégories
                        @if ($type == 0)
                            actif
                        @else
                            archivere
                        @endif
                    </h4>
                    <a type="button" href="{{ route('action_categorie', -1) }}" class="btn btn-primary btn-rounded btn-fw">+
                        Ajouter</a>
                    @if ($type == 0)
                        <a class="btn btn-danger" type="button" href="{{ route('categories_archive') }}">
                            Catégories archiver
                        </a>
                    @else
                        <a class="btn btn-success" type="button" href="{{ route('categorie.index') }}">
                            Catégories actif
                        </a>
                    @endif
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Nom</th>
                                <th>Nombre d'articles</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $categorie)
                                <tr>
                                    <td><img src='{{ asset('img') }}/{{ $categorie->logo }}' width='50'></td>
                                    <td>{{ $categorie->nom }}</td>
                                    <td><a href="{{ route('categorie_articles', $categorie->id) }}">{{ $categorie->catgs_articles_count }}</a></td>
                                    <td><a class="btn btn-warning" type="button"
                                            href="{{ route('action_categorie', ['id' => $categorie->id]) }}">
                                            Modifier
                                        </a>
                                        @if ($categorie->etat == 0)
                                            <a class="btn btn-danger"
                                                href="{{ route('modif_etat_categorie', ['id' => $categorie->id, 'etat' => 1]) }}">
                                                Archiver
                                            </a>
                                        @else
                                            <a class="btn btn-success"
                                                href="{{ route('modif_etat_categorie', ['id' => $categorie->id, 'etat' => 0]) }}">
                                                Désarchiver
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
