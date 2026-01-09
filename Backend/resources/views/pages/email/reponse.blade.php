<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        @if (isset($infoormations))
            {{ $infoormations->nom }}
        @endif
    </title>
</head>

<body>
    <h1>
        @if (isset($infoormations))
            {{ $infoormations->nom }}
        @endif
    </h1>
    <h3>Bienvenue M(e).{{ $data['nom'] }}</h3>
    @if (isset($data['reservation']))
        @if ($data['type'] == 1)
            Votre Réservation passer le {{ $data['date'] }} de {{ $data['personne'] }} personnes a été confirmée
        @else
            Votre Réservation passer le {{ $data['date'] }} de {{ $data['personne'] }} personnes a éré refuser
        @endif
    @else
        @if ($data['type'] == 1)
            Votre commende a été confirmée
            <h1>Factures</h1>
            <p><strong>Date:</strong>{{ $data['date'] }}</p>
            <p><strong>Prix:</strong>{{ $data['commende']->prix }}</p>
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
                    @foreach ($data['commende']->lignieComnd as $lignie)
                        <tr>
                            <td>{{ $lignie->articles->nom }}</td>
                            <td>{{ $lignie->prixU }}DT</td>
                            <td>{{ $lignie->quantite }}</td>
                            <td>{{ $lignie->prixT }}DT</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            Votre commende passer le {{ $data['date'] }} a éré refuser
        @endif
    @endif
    <p></p>
    @if (isset($infoormations->logo))
        <img src="{{ asset('images') }}/{{ $infoormations->logo }}" height="45" alt="Winkels" />
    @endif
</body>

</html>
