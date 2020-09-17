@extends('layouts.site')

@section('title','Home')

@section('content')
    <main role="main" class="flex-shrink-0" id="main">
        <div class="container pt-5 mt-5" id="home-page">
            <div class="text-center"><h1>Online TopUp</h1></div>
            <div class="checkCountry">
                <div class="card checkCountry-card">
                    <div class="card-header text-center">
                        <h5>Choose the country and phone number</h5>
                    </div>
                    <div class="card-body">
                    <form id="pn_form">
                        <div class="input-group mb-3">
                            <label for="country" class="w-100">Country</label>
                            <div class="input-group-append">
                                <span class="input-group-text country">
                                    <img src="" alt="" id="country_flag">
                                </span>
                            </div>
                            <select class="form-control" id="country" onchange="getDataOfCountry()">
                                <?php foreach ($countries as $country){
                                    foreach ($country->calling_codes as $code){
                                        $cod = $code;
                                    }
                                ?>
                                    <option
                                        value="<?=$country->iso;?>"
                                        name="<?=$country->name?>"
                                        data-ddi="<?=$cod;?>"
                                        data-country-flag="<?=$country->flag;?>"
                                        data-countryId="<?=$country->id;?>"
                                    >
                                        <?=
                                        $country->name
                                        ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="country-code"></span>
                            </div>
                            <input type="text" class="form-control col" id="phone_number" placeholder="Enter phone number" required oninput="hideOption(this)" aria-describedby="basic-addon1">
                            <div class="input-group-append">
                                <button type="submit" class="ml-2 btn btn-primary col-auto"><i class="fa fa-spinner fa-spin d-none"></i> Search</button>
                            </div>
                        </div>
                    </form>
                </div>

        </div>
        </div>
        </div>
        <div class="modal fade" id="select-operators">
            <fieldset>
                <div class="modal-dialog modal-md modal-dialog-centered">
                    <div class="modal-content">

                        <!-- header -->
                        <div class="modal-header head">
                            <p class="text-center"><em>Choose the correct operator</em></p>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div><br>

                        <!-- body -->
                        <div class="modal-body">
                            <div class="card">
                                    <div class="card-body">
                                        <form onsubmit="submitOperator(event)">
                                            <div class="input-group mb-3">
                                                <label for="country" class="w-100">Select an operator</label>
                                                <div class="input-group-append d-none" id="operator_flag_div">
                                                <span class="input-group-text" >
                                                    <img src="" alt="" id="operator_flag" width="55px" height="20px">
                                                </span>
                                                </div>
                                                <select id="operator" class="form-control" name="operator" required onchange="getOperatorFlag()">
                                                    <option value="">Choisissez un opérateur</option>
                                                </select>
                                                <div class="input-group-append">
                                                    <button type="submit" class="ml-2 btn btn-primary col-auto">Confirm</button>
                                                </div>
                                            </div>
                                         </form>
                                    </div>
                            </div>
                        </div>
                        <!-- footer -->
                        <div class="modal-footer">
                            <div class="row">
                                <div class="col-sm-6">
                                    <button type="button" class="btn btn-danger can">Cancel</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </fieldset>
        </div>

        <section role="main" class="flex-shrink-0 d-none" id="topup-data">
            <div class="container pt-5 mt-5">
                <div class="container topupElement">
                    <div class="topupElement-content">
                        <div class="row justify-content-center align-items-center">
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
                        </div>
                        <div class="col-12">
                            <form
                                id="range-value-form"
                                onsubmit="getCheckout(event,{{\Illuminate\Support\Facades\Auth::guest() ? 0 : \Illuminate\Support\Facades\Auth::id()}})"
                            >
                                <input type="hidden" name="phone_number" value="">
                                <input type="hidden" name="country_code"  value="">

                                <div class="form-group row" id="amount_field">
                                    <label for="amount" class="w-100">Amount</label>
                                    <input type="number" step="0.01" min="0" class="form-control col" id="amount" name="amount" placeholder="Enter amount" oninput="updateValue(this)">
                                </div>

                                <br>
                                <div class="card-values" id="card-values">
                                </div>

                                <div class="form row">
                                    <input type="text" class="form-control col d-none" id="receive_amount" name="receive_amount"><br>
                                    <p class="d-none" id="sent_amount"></p><br>
                                    <p class="d-none" id="fixedSendValue"></p><br>
                                    <p class="d-none" id="sender_currency"></p>
                                    <p class="d-none" id="destination_currency"></p>
                                    <p class="d-none" id="operator_id"></p>
                                    <p class="d-none" id="fixed">0</p>
                                </div><br>
                                <button type="submit" class="btn btn-primary pull-right d-none" id="btn-sent-topup">Next</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="container d-none" id="receipt">
            <h4>Reçu de topUp</h4>
            <p>Nom de l'opérateur: <span id="operatorName">0</span> </p>
            <p>Numéro de téléphone: <span id="recipientPhone">0</span> </p>
            <p>Valeur envoyée: <span id="rec_sent_amount">0</span> </p>
            <p>Valeur reçue: <span id="deliveredAmount">0</span> </p>
        </div>
    </main>

@endsection
