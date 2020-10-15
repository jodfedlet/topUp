@extends('layouts.adm')

@section('title','New topup')

@section('content')
<div class="container">
    <div class="card">
        <h1 class="text-center">Resellers</h1>
        <table id="table" class="display responsive nowrap" style="width:100%">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">NOM</th>
                <th scope="col">TÉLÉPHONE</th>
                <th scope="col">EMAIL</th>
                <th scope="col">BALANCE</th>
                <th scope="col">DATE DE CRÉATION</th>
                <th scope="col">ACTION</th>
            </tr>
            </thead>
            <tbody>
            @php
                $totalbalance = 0;
            @endphp
            @foreach($resellers as $reseller)
                @php
                $totalbalance+=$reseller->balance;
                @endphp
            <tr>
                <th scope="row">{{$reseller->id}}</th>
                <td>{{$reseller->name}}</td>
                <td>{{$reseller->email}}</td>
                <td>{{$reseller->email}}</td>
                <td>{{$reseller->balance}}</td>
                <td>{{$reseller->created_at}}</td>
                <td>
                    <div class="col-sm">
                            <button
                                class="btn btn-sm btn-info"
                                data-toggle="tooltip" data-placement="top" title="Balance"
                                onclick="resellerBalance({{$reseller->id}})"
                            >
                            <i class="fa fa-usd"></i></button>
                    </div>
                </td>
            </tr>
            @endforeach

            </tbody>
        </table>
    </div>
    <div><br>
        <p class="pull-right"><b><em>Total balance: </em></b><span>{{$totalbalance}}</span><b><em> BRL</em></b></p>
    </div>
</div>
<form class="modal fade" id="balance">
    <fieldset>
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">

                <!-- header -->
                <div class="modal-header head">
                    <p class="text-center" id="reseller-name">User balance</p>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div><br>

                <!-- body -->
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                                <div>
                                    <span class="msg-error text-center" id="msg-error-forgot"></span>
                                </div><br>
                            <input type="hidden" id="resellerId">
                                <div class="form-group">
                                    <label for="email">Amount:</label>
                                    <input type="number" step="0.01" min="0" id="balanceAmount" oninput="buttonOption(this)" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-danger" id="btn-remove-balance" onclick="removeBalance(event)">
                                        <i class="fa fa-spinner fa-spin d-none"></i>
                                        REMOVE
                                    </button>
                                    <button type="submit" class="btn btn-success pull-right" id="btn-add-balance" onclick="addBalance(event)">
                                        <i class="fa fa-spinner fa-spin d-none"></i>
                                         ADD
                                    </button>
                                </div>
                            <p><b><em>Current balance: </em></b><span id="current-balance">0</span><b><em> BRL</em></b></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
</form>
@endsection
