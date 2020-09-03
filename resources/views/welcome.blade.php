@extends('layouts.site')

@section('title','Home')

@section('content')
    <main role="main" class="flex-shrink-0">
        <div class="container pt-5 mt-5" id="home-page">
            <div class="text-center"><h1>Online TopUp</h1></div>
            <div class="row">
                <div class="col-6">
                    <form id="pn_form">
                        <div class="form-group row">
                            <label for="country" class="w-100">Country</label>
                            <select class="form-control" id="country">
                                <?php foreach ($countries as $country) { ?>
                                <option value="<?=$country->iso?>">
                                    <?=$country->name?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group row">
                            <label for="phone_number" class="w-100">Phone Number</label>
                            <input type="text" class="form-control col" id="phone_number" placeholder="Enter phone number" required oninput="hideOption(this)">
                            <button type="submit" class="ml-2 btn btn-primary col-auto"><i class="fa fa-spinner fa-spin d-none"></i> Search</button>
                        </div>
                    </form>
                </div>
                <div class="col-6 d-none align-items-center text-center justify-content-center" id="details_box">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-12 text-center">
                            <img id="operator_image" src="someimage" width="100px">
                        </div>
                        <p>
                            <input type="hidden" id="operator_id">
                            <span id="operator_name">Some Name</span>
                        </p>
                    </div>
                </div>
                <div class="col-12">
                    <form id="tu_form"
                          class="d-none"
                          method="post"
                          onsubmit="getCheckout(event,{{\Illuminate\Support\Facades\Auth::guest() ? 0 : \Illuminate\Support\Facades\Auth::id()}})"
                    >
                        <input type="hidden" name="phone_number" value="">
                        <input type="hidden" name="country_code"  value="">
                        <input type="hidden" name="operator_id" value="-1">
                        <div class="form-group row">
                            <label for="amount" class="w-100">Amount</label>
                            <input type="number" step="0.01" min="0" class="form-control col" id="amount" name="amount" placeholder="Enter amount" required oninput="updateValue(this)">
                        </div>
                        <div class="form-group row " id="base_amount_div">
                            <p>Amount base: <span id="base_amount"></span> </p>
                        </div>
                        <div class="form row">
                            <input type="text" class="form-control col d-none" id="receive_amount" name="receive_amount"><br>
                            <p class="d-none" id="sent_amount" name="sent_amount"></p><br>
                            <p class="d-none" id="sender_currency"></p>
                        </div><br>
                        <button type="submit" class="btn btn-primary pull-right" id="btn-sent-topup"><i class="fa fa-spinner fa-spin d-none"></i> Pay</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="container d-none" id="receipt">
            <h4>Reçu de topUp</h4>
            <p>Nom de l'opérateur: <span id="operatorName">0</span> </p>
            <p>Numéro de téléphone: <span id="recipientPhone">0</span> </p>
            <p>Valeur envoyée: <span id="rec_sent_amount">0</span> </p>
            <p>Valeur reçue: <span id="deliveredAmount">0</span> </p>
        </div>
    </main>

@endsection
