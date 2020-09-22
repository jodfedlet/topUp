@extends('layouts.adm')

@section('title','New topup')

@section('content')
    <div class="table-container">
    <section class="content-table">
        <h1>Transactions effectuées</h1>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">First</th>
            <th scope="col">Last</th>
            <th scope="col">Handle</th>
        </tr>
        </thead>
        <tbody>
        @foreach($topups as $topup)
        <tr>
            <th scope="row">1</th>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
        </tr>
        @endforeach

        </tbody>
    </table>
    </section>
    </div>
@endsection
