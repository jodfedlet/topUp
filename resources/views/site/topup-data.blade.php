@extends('layouts.site')

@section('title','Topup data')

@section('content')
    @php
     $topupData = \App\Helpers\Helper::decryptedData($_GET['data']);
    @endphp
    <div class="topup-data-container">
        <div class="content">
            <section>
                <table class="table table-striped" id="table">
                        <thead>
                        <tr>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><label><b>Country: </b></label></td>
                            <td class="country">
                                <span id="detail_country_name">{{$topupData->countryName}}</span>
                                <img id="detail_country_flag" src="{{$topupData->countryFlag}}">
                                <a  onsubmit="showAllCountry()"><i class="far fa-edit"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td> <label><b>Operator: </b></label></td>
                            <td>
                                <span id="operator_name">{{$topupData->name}}</span>
                                <img id="operator_image" src="{{$topupData->logo_urls[0]}}" width="55px" height="20px">
                            </td>
                        </tr>
                        <tr>
                            <td> <label><b>Phone number:</b></label></td>
                            <td>
                                <span id="operator_dest_number">{{$topupData->ddi.''.$topupData->phone}}</span>
                            </td>
                        </tr>
                        <tr class="d-none" id="sending-tr">
                            <td><label><b>Sending value: </b></label></td>
                            <td >
                                <span id="sendingValue"></span>
                            </td>
                        </tr>
                        <tr class="d-none" id="delivered-tr">
                            <td> <label><b>Delivered value: </b></label></td>
                            <td>
                                <span id="deliveredValue"></span>
                            </td>
                        </tr>
                        <tr class="d-none" id="taxe-tr">
                            <td> <label><b>Taxe: </b></label></td>
                            <td>
                                <span id="taxe"></span>
                            </td>
                        </tr>

                        <tr class="d-none" id="pay-tr">
                            <td> <label><b>Sum to pay: </b></label></td>
                            <td>
                                <span id="total"></span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
            </section>
            <form
                id="range-value-form"
                onsubmit="getCheckout(event,{{\Illuminate\Support\Facades\Auth::guest() ? 0 : \Illuminate\Support\Facades\Auth::id()}})"
            >
                <input type="hidden" name="phone_number" value="">
                <input type="hidden" name="country_code"  value="">

                @if($topupData->denomination_type != 'FIXED')
                <div id="amount_field">
                    <label for="amount">Amount to send</label>
                    <input
                        type="number"
                        step="0.01"
                        min="0"
                        id="amount"
                        name="amount"
                        placeholder="Enter the amount"
                        oninput="updateValue(this)">
                </div>
                @else
                    @php
                     $data = [
                        'id'=>$topupData->rid,
                        'cc'=>$topupData->cc,
                        'type'=>'fixed'
                    ];

                    $Operator = new \App\Operator();
                    @endphp
                    @foreach($topupData->fixed_amounts as $fixedAmount)
                    @php
                        $data['amount'] = $fixedAmount;
                        $deliveredAmount = $Operator->getFxForAmount($data);
                    @endphp
                        <a href=""  class="fixed-value">
                            <p><b>{{$fixedAmount.' '.$topupData->sender_currency_code}}</b></p>
                            <p>{{$deliveredAmount.' '.$topupData->destination_currency_code}}</p>
                        </a>
                    @endforeach
                @endif

                <input
                    type="text"
                    class="d-none"
                    id="receive_amount"
                    name="receive_amount"
                    readonly
                ><br>
                <p class="d-none" id="sent_amount"></p><br>
                <p class="d-none" id="fixedSendValue"></p><br>
                <p class="d-none" id="sender_currency"></p>
                <p class="d-none" id="destination_currency">{{$topupData->destination_currency_code}}</p>
                <p class="d-none" id="operator_id">{{$topupData->rid}}</p>
                <p class="d-none" id="fixed">0</p>

                <button type="submit" class="button d-none" id="btn-sent-topup">Next</button>
            </form>
        </div>
    </div>
    <input type="hidden" id="country" value="{{$topupData->cc}}">
@endsection
