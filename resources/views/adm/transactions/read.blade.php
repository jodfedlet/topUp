@extends('layouts.adm')

@section('title','New topup')

@section('content')
<div class="container">
    <div class="card">
        <h1 class="text-center">Transactions effectuées</h1>
        <table id="table" class="display responsive nowrap" style="width:100%">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Date</th>
                <th scope="col">Opérateur</th>
                <th scope="col">Téléphone</th>
                <th scope="col">Valeur envoyée</th>
                <th scope="col">Bénéfice</th>
                <th scope="col">Valeur reçue</th>
                <th scope="col">Vendeur</th>
            </tr>
            </thead>
            <tbody>
            @foreach($topups as $topup)
                @php

                if ($topup->taxes > 0.00){
                    if (Auth::id() == 1) $benefice = $topup->taxes * .65;
                    else $benefice = $topup->taxes * .35;
                }
                else{
                    if (Auth::id() == 1) $benefice = $topup->total * .2;
                    else $benefice = $topup->total * .1;
                }

                $operator = json_decode(\App\Operator::getColumn('rid',$topup->operatorId));
                $userName = json_decode(\App\User::find($topup->user_id))->name;
                @endphp
            <tr>
                <th scope="row">{{$topup->id}}</th>
                <td>{{$topup->updated_at}}</td>
                <td>{{$operator[0]->name}}</td>
                <td>{{$topup->phoneNumber}}</td>
                <td>{{$topup->total.' '.$topup->senderCurrency}}</td>
                <td>{{number_format($benefice,2).' '.$topup->senderCurrency}}</td>
                <td>{{$topup->receivedAmount.' '.$topup->destinationCurrency}}</td>
                <td>{{$userName}}</td>
            </tr>
            @endforeach

            </tbody>
        </table>
    </div>
</div>
@endsection
