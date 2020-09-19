@extends('layouts.site')

@section('title','Checkout')

@section('content')
    <?php
    $data = \App\Helpers\Helper::decryptedData($_GET['data']);
    ?>
    <div class="container checkout-form">
        <img id="loader" src="/../../img/loader.gif" alt="">
        <div class="checkout-content">
                <article class="card">
                    <div class="card-header">
                    <div class="card-body">
                        <p id="cc-response"></p>
                        <form role="form" id="creditCard"
                              onsubmit="submitPayment(event)"
                        >
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="username">Full name (on the card)</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="username" placeholder="" required value="John Doe">
                                </div> <!-- input-group.// -->
                            </div> <!-- form-group.// -->

                            <div class="form-group">
                                <label for="cardNumber">Card number</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-credit-card"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="cardNumber" placeholder="" data-stripe="number" required value="4242424242424242">
                                </div> <!-- input-group.// -->
                            </div> <!-- form-group.// -->

                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label><span class="hidden-xs">Expiration</span> </label>
                                        <div class="form-inline">
                                            <input class="form-control" required type="text" style="width:45%" placeholder="MM" data-stripe="exp_month" value="12">
                                            <span style="width:10%; text-align: center"> / </span>
                                            <input class="form-control" required type="text" style="width:45%" placeholder="YYYY" data-stripe="exp_year" value="2030">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label data-toggle="tooltip" title="" data-original-title="3 digits code on back side of the card">CVV <i class="fa fa-question-circle"></i></label>
                                        <input class="form-control" required type="text" data-stripe="cvc" value="123">
                                    </div> <!-- form-group.// -->
                                </div>
                            </div> <!-- row.// -->
                            <button class="subscribe btn btn-primary btn-block"> Pay <?=$data->total.' '.$data->sender_currency?></button>
                            <input type="hidden" id="stripeToken" name="stripeToken">
                            <input type="hidden" id="value_to_pay" name="value_to_pay" value="<?=$data->total?>">
                            <input type="hidden" id="destination_currency" name="destination_currency" value="<?=$data->destination_currency?>">
                            <input type="hidden" id="sender_currency" name="sender_currency" value="<?=$data->sender_currency?>">
                            <input type="hidden" id="country_code" name="country_code" value="<?=$data->country_code?>">
                            <input type="hidden" id="operator_id" name="operator_id" value="<?=$data->operator_id?>">
                            <input type="hidden" id="phone_number" name="phone_number" value="<?=$data->phone_number?>">
                            <input type="hidden" id="sent_amount" name="sent_amount" value="<?=$data->sent_amount?>">
                            <input type="hidden" id="fixed" name="fixed" value="<?=$data->fixed?>">
                        </form>
                    </div>
                    </div>
                </article>
            </div>
        </div>
    <br><br>

    <div>
        <!-- Modal HTML -->
        <div id="myModal" class="modal fade">
            <div class="modal-dialog modal-confirm">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="icon-box">
                            <i class="material-icons">&#xE876;</i>
                        </div>
                        <h4 class="modal-title w-100">Awesome!</h4>
                    </div>
                    <div class="modal-body">
                        <p class="text-center">Your booking has been confirmed. Check your email for detials.</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success btn-block" data-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
