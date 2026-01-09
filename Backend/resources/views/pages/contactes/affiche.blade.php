@extends('layout.main')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-sm-around align-items-baseline">
                    <h4 class="card-title">E-mail </h4>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <p><strong>Date:</strong>{{ $contacte->created_at }}</p>
                        <p><strong>E-mail:</strong>{{ $contacte->email }} </p>
                        <p><strong>Nom:</strong>{{ $contacte->nom }} </p>
                    </div>
                </div>
                <h3>Contenue:</h3>
                <p>{{ $contacte->contenue }}</p>
            </div>
        </div>
    </div>
@endsection
