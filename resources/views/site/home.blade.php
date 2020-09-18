@extends('layouts.site')

@section('title','System')

@section('content')
    <div class="home-container">
        <section class="form">
            <form id="pn_form">
                <h1>Select the country and enter mobile phone number</h1>
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
        </section>
        <img src="/../img/heroes.png" alt="">
    </div>

    <div class="modal fade" id="select-operators">
        <fieldset>

            <div class="modal-dialog modal-md modal-dialog-centered">

                <div class="modal-content">

                    <!-- header -->
                    <div class="modal-header head">
                        <h1>Choose the correct operator</h1>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div><br>

                    <!-- body -->
                    <div class="modal-body">
                        <form onsubmit="submitOperator(event)">
                                <select id="operator" name="operator" required onchange="getOperatorFlag()">
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
