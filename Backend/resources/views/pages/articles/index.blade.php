@extends('layout.main')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-sm-around align-items-baseline">
                    @if ($type != 3)
                        <h4 class="card-title">Listes des articles
                            @if ($type == 0)
                                actif
                            @else
                                archivere
                            @endif
                        </h4>
                        <a type="button" href="{{ route('action_article', -1) }}" class="btn btn-primary btn-rounded btn-fw">+
                            Ajouter</a>
                        @if ($type == 0)
                            <a class="btn btn-danger" type="button" href="{{ route('articles_archive') }}">
                                Articles archiver
                            </a>
                        @else
                            <a class="btn btn-success" type="button" href="{{ route('article.index') }}">
                                Articles actif
                            </a>
                        @endif
                    @else
                        <h4 class="card-title">Listes des articles de la catégorie {{ $catg->nom }}
                        </h4>
                    @endif
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Catégories</th>
                                <th>Nom</th>
                                <th>Description</th>
                                <th>Prix</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($articles as $article)
                                <tr>
                                    <td><img src='{{ asset('img') }}/{{ $article->logo }}' width='50'></td>
                                    <td>{{ $article->categories->nom }}</td>
                                    <td>{{ $article->nom }}</td>
                                    <td>{{ $article->description }}</td>
                                    <td>{{ $article->prix }}DT</td>
                                    <td><a class="btn btn-warning" type="button"
                                            href="{{ route('action_article', ['id' => $article->id]) }}">
                                            Modifier
                                        </a>
                                        @if ($article->etat == 0)
                                            <a class="btn btn-danger"
                                                href="{{ route('modif_etat_article', ['id' => $article->id, 'etat' => 1]) }}">
                                                Archiver
                                            </a>
                                        @else
                                            <a class="btn btn-success"
                                                href="{{ route('modif_etat_article', ['id' => $article->id, 'etat' => 0]) }}">
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
