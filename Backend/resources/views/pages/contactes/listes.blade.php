@extends('layout.main')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-sm-around align-items-baseline">
                    <h4 class="card-title">Listes des commended </h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>E-mail</th>
                                <th>Nom</th>
                                <th>Afficher</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contacts as $contact)
                                <tr>
                                    <td>{{ $contact->created_at }}</td>
                                    <td>{{ $contact->email }} </td>
                                    <td>{{ $contact->nom }}</td>
                                    <td>
                                        @if ($contact->etat == 0)
                                            <a type="button"
                                                class="btn btn-inverse-warning btn-rounded" href="{{ route('contactes.show', ['contacte' => $contact->id]) }}">
                                                <i class="fas fa-eye-slash btn-icon-append"></i>
                                            </a>
                                        @elseif ($contact->etat == 1)
                                            <a type="button" class="btn btn-inverse-info btn-rounded"
                                                href="{{ route('contactes.show', ['contacte' => $contact->id]) }}">
                                                <i class="fas fa-eye btn-icon-append"></i>
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
