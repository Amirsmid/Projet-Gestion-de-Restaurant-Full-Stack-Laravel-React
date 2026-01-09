@extends('layout.main')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-sm-around align-items-baseline">
                    <h4 class="card-title">Listes des Réservations</h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Date de Réservation</th>
                                <th>Client</th>
                                <th>Date Souhaitée</th>
                                <th>Nombre de Personnes</th>
                                <th>État</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($reservations as $reservation)
                                <tr>
                                    <td>{{ $reservation->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $reservation->clients->nom ?? 'N/A' }} {{ $reservation->clients->prenom ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($reservation->date)->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <span class="badge badge-info">{{ $reservation->nb_pers }} personne(s)</span>
                                    </td>
                                    <td>
                                        @switch($reservation->etat)
                                            @case(0)
                                                <span class="badge badge-warning">En Attente</span>
                                                @break
                                            @case(1)
                                                <span class="badge badge-success">Acceptée</span>
                                                @break
                                            @case(2)
                                                <span class="badge badge-danger">Refusée</span>
                                                @break
                                            @default
                                                <span class="badge badge-secondary">Inconnu</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        @if ($reservation->etat == 0)
                                            <a class="btn btn-success btn-sm"
                                                href="{{ route('modif_etat_reservation', ['id' => $reservation->id, 'etat' => 1]) }}">
                                                <i class="ti-check"></i> Accepter
                                            </a>
                                            <a class="btn btn-danger btn-sm"
                                                href="{{ route('modif_etat_reservation', ['id' => $reservation->id, 'etat' => 2]) }}">
                                                <i class="ti-close"></i> Refuser
                                            </a>
                                        @else
                                            <span class="text-muted">Pas d'actions</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        Aucune réservation trouvée
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
