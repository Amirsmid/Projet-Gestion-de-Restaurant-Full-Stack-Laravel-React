@extends('layout.main')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-sm-around align-items-baseline">
                    <h4 class="card-title">Listes des Commandes</h4>
                    <a href="{{ route('commende.paniers') }}" class="btn btn-warning">
                        <i class="ti-shopping-cart"></i> Voir les Paniers en Cours
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Client</th>
                                <th>Prix Total</th>
                                <th>État</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($commendes as $commende)
                                <tr>
                                    <td>{{ $commende->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $commende->clients->nom ?? 'N/A' }} {{ $commende->clients->prenom ?? 'N/A' }}</td>
                                    <td>{{ number_format($commende->prix, 2) }} €</td>
                                    <td>
                                        @switch($commende->etat)
                                            @case(1)
                                                <span class="badge badge-info">En Attente</span>
                                                @break
                                            @case(2)
                                                <span class="badge badge-warning">En Préparation</span>
                                                @break
                                            @case(3)
                                                <span class="badge badge-success">Terminée</span>
                                                @break
                                            @case(4)
                                                <span class="badge badge-danger">Annulée</span>
                                                @break
                                            @default
                                                <span class="badge badge-secondary">{{ $commende->etat }}</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        <a href="{{ route('detaille_commende', ['id' => $commende->id]) }}" 
                                           class="btn btn-inverse-info btn-sm">
                                            <i class="ti-eye"></i> Voir
                                        </a>
                                        @if($commende->etat == 1)
                                            <a href="{{ route('modif_etat_commende', ['id' => $commende->id, 'etat' => 2]) }}" 
                                               class="btn btn-success btn-sm">
                                                <i class="ti-check"></i> Accepter
                                            </a>
                                            <a href="{{ route('modif_etat_commende', ['id' => $commende->id, 'etat' => 4]) }}" 
                                               class="btn btn-danger btn-sm">
                                                <i class="ti-close"></i> Refuser
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        Aucune commande trouvée
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
