@extends('layouts.adm')

@section('title','New topup')

@section('content')
<div class="container">
    <div class="card">
        <h1 class="text-center">Transactions effectuées</h1>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Date</th>
                <th scope="col">Opérateur</th>
                <th scope="col">Téléphone</th>
                <th scope="col">Valeur envoyée</th>
                <th scope="col">Bénéfice</th>
                <th scope="col">Valeur reçue</th>
            </tr>
            </thead>
            <tbody>
            @foreach($topups as $topup)
                @php
                $benefice = $topup->total * .1;
                @endphp
            <tr>
                <th scope="row">{{$topup->id}}</th>
                <td>{{$topup->updated_at}}</td>
                <td>{{$topup->operatorId}}</td>
                <td>{{$topup->phoneNumber}}</td>
                <td>{{$topup->total.' '.$topup->senderCurrency}}</td>
                <td>{{number_format($benefice,2)}}</td>
                <td>{{$topup->receivedAmount.' '.$topup->destinationCurrency}}</td>
            </tr>
            @endforeach

            </tbody>
        </table>
    </div>
</div>
@endsection
