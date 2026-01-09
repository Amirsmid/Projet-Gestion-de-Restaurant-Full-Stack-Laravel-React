@extends('layout.main')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-sm-around align-items-baseline">
                    <h4 class="card-title">Listes des clients
                        @if ($type == 0)
                            actif
                        @else
                            archivere
                        @endif
                    </h4>
                    @if ($type == 0)
                        <a class="btn btn-danger" type="button" href="{{ route('clients_archive') }}">
                            Clients archiver
                        </a>
                    @else
                        <a class="btn btn-success" type="button" href="{{ route('client.index') }}">
                            Clients actif
                        </a>
                    @endif
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Adresse</th>
                                <th>Téléphone</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $client)
                                <tr>
                                    <td>{{ $client->nom }} {{ $client->prenom }}</td>
                                    <td>{{ $client->adresse }} </td>
                                    <td>{{ $client->telephone }} </td>
                                    <td>
                                        @if ($client->etat == 0)
                                            <a class="btn btn-danger"
                                                href="{{ route('modif_etat_client', ['id' => $client->id, 'etat' => 1]) }}">
                                                Archiver
                                            </a>
                                        @else
                                            <a class="btn btn-success"
                                                href="{{ route('modif_etat_client', ['id' => $client->id, 'etat' => 0]) }}">
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
