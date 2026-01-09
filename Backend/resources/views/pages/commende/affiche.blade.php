@extends('layout.main')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-sm-around align-items-baseline">
                    <h4 class="card-title">Informations sur la commande </h4>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <p><strong>Date:</strong>{{ $commende->created_at }}</p>
                        <p><strong>Client:</strong>{{ $commende->clients->nom ?? 'N/A' }} {{ $commende->clients->prenom ?? 'N/A' }} </p>
                        <p><strong>Prix:</strong>{{ $commende->prix }}</p>
                        <p><strong>Etat:</strong>
                            @switch($commende->etat)
                                @case(0)
                                    <span class="badge badge-warning">Panier en cours</span>
                                    @break
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
                        </p>
                    </div>
                    <div>
                        @if ($commende->etat == 1)
                            <a class="btn btn-success"
                                href="{{ route('modif_etat_commende', ['id' => $commende->id, 'etat' => 2]) }}">
                                <i class="ti-check"></i> Accepter
                            </a>
                            <a class="btn btn-danger"
                                href="{{ route('modif_etat_commende', ['id' => $commende->id, 'etat' => 4]) }}">
                                <i class="ti-close"></i> Refuser
                            </a>
                        @elseif ($commende->etat == 2)
                            <a class="btn btn-success"
                                href="{{ route('modif_etat_commende', ['id' => $commende->id, 'etat' => 3]) }}">
                                <i class="ti-check"></i> Marquer comme Terminée
                            </a>
                        @endif
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Article</th>
                                <th>Prix Unitaire</th>
                                <th>Quantité</th>
                                <th>Prix Totale</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($commende->lignieComnd as $lignie)
                                <tr>
                                    <td>{{ $lignie->articles->nom ?? 'Article supprimé' }}</td>
                                    <td>{{ $lignie->prixU ?? 0 }}DT</td>
                                    <td>{{ $lignie->quantite ?? 0 }}</td>
                                    <td>{{ $lignie->prixT ?? 0 }}DT</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
