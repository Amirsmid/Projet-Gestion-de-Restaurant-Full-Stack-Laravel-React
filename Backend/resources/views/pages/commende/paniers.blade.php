@extends('layout.main')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-sm-around align-items-baseline">
                    <h4 class="card-title">Paniers en Cours</h4>
                    <a href="{{ route('commende.index') }}" class="btn btn-info">
                        <i class="ti-list"></i> Voir les Commandes
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Date de Création</th>
                                <th>Client</th>
                                <th>Prix Total</th>
                                <th>Articles</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($paniers as $panier)
                                <tr>
                                    <td>{{ $panier->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $panier->clients->nom ?? 'N/A' }} {{ $panier->clients->prenom ?? 'N/A' }}</td>
                                    <td>{{ number_format($panier->prix, 2) }} €</td>
                                    <td>
                                        @php
                                            $nbArticles = $panier->lignieComnd->count();
                                        @endphp
                                        <span class="badge badge-primary">{{ $nbArticles }} article(s)</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('detaille_commende', ['id' => $panier->id]) }}" 
                                           class="btn btn-inverse-info btn-sm">
                                            <i class="ti-eye"></i> Voir Détails
                                        </a>
                                        @if($panier->etat == 0)
                                            <form method="POST" action="{{ route('valider_panier_admin') }}" style="display: inline;">
                                                @csrf
                                                <input type="hidden" name="id_commende" value="{{ $panier->id }}">
                                                <button type="submit" class="btn btn-success btn-sm" 
                                                        onclick="return confirm('Êtes-vous sûr de vouloir valider ce panier ?')">
                                                    <i class="ti-check"></i> Valider
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        Aucun panier en cours
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


@endsection
