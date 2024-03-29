@extends('layouts.adm')

@section('title','New topup')

@section('content')
    <section class="topup-container">
        <section class="content">

        <h1 class="text-center" id="topup-title">Create a topup</h1>
        <section>
        <form
            id="adm-search-country"
            onsubmit="getByCountryAndPhone(event,'adm')"
        >
            <select
                name="country"
                id="country"
                onchange="getDataOfCountry()"
            >
                @foreach ($countries as $country)
                    @php
                        foreach ($country->calling_codes as $code){
                           $cod = $code;
                       }
                    @endphp
                    <option
                        value="{{$country->iso}}"
                        name="{{$country->name}}"
                        data-ddi="{{$cod}}"
                        data-country-flag="{{$country->flag}}"
                        data-countryId="{{$country->id}}"
                    >
                        {{$country->name}}
                    </option>
                @endforeach
            </select>

            <div class="group-input">
                <input
                    type="text"
                    id="country-code"
                    style="width: 100px"
                    readonly
                >

                <input
                    type="text"
                    id="phone_number"
                    placeholder="Phone number"
                    required
                >
            </div>

            <button
                type="submit"
                class="button"
            >
            <i class="fa fa-search" aria-hidden="true"></i>
            Search
            </button>
        </form>
        <form
            id="adm-show-data"
            class="d-none adm-show-data"
            onsubmit="return sendTopupAdm(event)"
        >
            <div>
                <p class="country">
                    <label><b>Pays: </b></label>
                    <span id="detail_country_name_adm"></span>
                    <img id="detail_country_flag_adm" src="">
                </p>
            </div>
            <div>
                <p>
                    <label><b>Opérateur: </b></label>
                    <span id="detail_operator_name_adm"></span>
                    <img id="detail_operator_flag_adm" src="" width="55px" height="20px">
                </p>
            </div>

            <div>
                <p>
                    <label><b>Téléphone: </b></label>
                    <span id="adm_phone_resume"></span>
                </p>
            </div>
            <div class="form-group row" id="amountField">
                <label for="valeur" class="w-100">Valeur</label>
                <input type="number" step="0.01" min="0" id="valeur" placeholder="Valeur de la recharge" oninput="hideOption()">
                <button type="button" class="btn btn btn-light pull-right" onclick="updateValue('adm')">Recherche</button>
            </div>

            <div>
            <select class="d-none" id="fixedValue-adm" onchange="getFixedValues('adm')">
                <option value="">Select an amount</option>
            </select>
            </div><br>

            <div>
                <p><span id="receive_amount"></span></p>
                <p><span id="taxes" class="d-none"></span></p>
            </div>

            <input type="hidden" id="countryCode">
            <input type="hidden" id="destinationCurrency">
            <input type="hidden" id="sent_amount">
            <input type="hidden" id="fixedSendValue">
            <input type="hidden" id="sender_currency">
            <input type="hidden" id="operator_id">
            <input type="hidden" id="fixed">
            <button
                type="submit"
                class="button d-none"
                id="btn-sent-topup"
            >
                Send
                <i class="fa fa-send" aria-hidden="true"></i>
            </button>
        </form>
            <div class="container d-none" id="receipt">
                <h4>Reçu de topup toprecharging.com</h4>
                <hr>
                <p><b>Nom de l'opérateur: </b><span id="operatorName">0</span> </p>
                <p><b>Numéro de téléphone: </b><span id="recipientPhone">0</span> </p>
                <p><b>Valeur envoyée: </b><span id="rec_sent_amount">0</span> </p>
                <p><b>Valeur reçue: </b><span id="deliveredAmount">0</span> </p>
                <p><b>Status: </b><span>Succès</span> </p>
                <p><b>Frais de taxes: </b><span id="rec_taxes">0</span> </p>
                <p><b>Date de l'envoie: </b><span>{{date('d-m-Y h:i:sa')}}</span> </p>
                <hr>
                <p><b>Total : </b><span id="total_payer">0</span> </p>
            </div>
        </section>
    </section>
    </section>
    <div class="modal fade" id="select-operators-adm">
        <fieldset>

            <div class="modal-dialog modal-sm modal-dialog-centered">

                <div class="modal-content">

                    <!-- header -->
                    <div class="modal-header head">
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div><br>

                    <!-- body -->
                    <div class="modal-body">
                        <form onsubmit="submitOperator(event,'adm')">
                            <select id="operator-adm" name="operator-adm" required onchange="getOperatorFlag('adm')">
                                <option value="">Select an operator</option>
                            </select>
                            <button class="button">Confirm</button>
                        </form>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
@endsection
