@extends('layouts.site')

@section('title','Topup data')

@section('content')
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
                                <span id="detail_country_name"></span>
                                <img id="detail_country_flag" src="">
                                <a  onsubmit="showAllCountry()"><i class="far fa-edit"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td> <label><b>Operator: </b></label></td>
                            <td>
                                <span id="operator_name"></span>
                                <img id="operator_image" src="" width="55px" height="20px">
                            </td>
                        </tr>
                        <tr>
                            <td> <label><b>Phone number:</b></label></td>
                            <td>
                                <span id="operator_dest_number"></span>
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

                <div class="form-group row" id="amount_field">
                    <label for="amount" class="w-100">Amount</label>
                    <input type="number" step="0.01" min="0" id="amount" name="amount" placeholder="Enter the amount" oninput="updateValue(this)">
                </div>

                <br>
                <div class="card-values" id="card-values">
                </div>

                <div class="form row">
                    <input
                        type="text"
                        class="d-none"
                        id="receive_amount"
                        name="receive_amount"
                    ><br>
                    <p class="d-none" id="sent_amount"></p><br>
                    <p class="d-none" id="fixedSendValue"></p><br>
                    <p class="d-none" id="sender_currency"></p>
                    <p class="d-none" id="destination_currency"></p>
                    <p class="d-none" id="operator_id"></p>
                    <p class="d-none" id="fixed">0</p>
                </div><br>
                <button type="submit" class="button d-none" id="btn-sent-topup">Next</button>
            </form>
        </div>
    </div>
@endsection
