@extends('layouts.adm')

@section('title','New topup')

@section('content')
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
                <input type="number" step="0.01" min="0" id="valeur" placeholder="Valeur de la recharge" oninput="updateValue(this,'adm')">
            </div>

            <div>
            <select class="d-none" id="fixedValue-adm" onchange="getFixedValues()">
                <option value="">Select an amount</option>
            </select>
            </div>

            <p><span id="receive_amount"></span></p>

            <input type="hidden" id="countryCode">
            <input type="hidden" id="destinationCurrency">
            <input type="hidden" id="sent_amount">
            <input type="hidden" id="fixedSendValue">
            <input type="hidden" id="sender_currency">
            <input type="hidden" id="destination_currency">
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
    <div class="container d-none" id="receipt">
        <h4>Reçu de topUp</h4>
        <p>Nom de l'opérateur: <span id="operatorName">0</span> </p>
        <p>Numéro de téléphone: <span id="recipientPhone">0</span> </p>
        <p>Valeur envoyée: <span id="rec_sent_amount">0</span> </p>
        <p>Valeur reçue: <span id="deliveredAmount">0</span> </p>
    </div>
@endsection
