@extends('layouts.site')

@section('title','Checkout')

@section('content')
    <?php
    $data = \App\Helpers\Helper::decryptedData($_GET['data']);
    ?>
    <div class="checkout-form-container">
        <div class="content">
            <form
                  id="creditCard"
                  onsubmit="submitPayment(event)"
             >
                <p id="cc-response"></p>

                <input
                    type="text"
                    name="username"
                    placeholder="Name on the card"
                    required
                >

                <input
                    type="text"
                    name="cardNumber"
                    placeholder="The card number"
                    data-stripe="number" required
                >

                <div class="checkout-input-group">
                    <input
                        required
                        type="text"
                        placeholder="MM"
                        data-stripe="exp_month"
                    >

                    <input
                        required
                        type="text"
                        placeholder="YYYY"
                        data-stripe="exp_year"
                    >

                    <input
                        required
                        type="text"
                        data-stripe="cvc"
                        placeholder="CVC"
                    >
                </div>

                <button class="button"> Pay <?=$data->total.' '.$data->sender_currency?></button>
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
                        <h4 class="modal-title w-100">Success!</h4>
                    </div>
                    <div class="modal-body">
                        <p class="text-center" id="success-message"></p>
                    </div>
                    <a href="/">
                        <button class="button">OK</button>
                    </a>

                </div>
            </div>
        </div>
    </div>

@endsection
