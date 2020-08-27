@extends('layouts.site')

@section('title','Home')

@section('content')

    @if(session()->has('success'))
        <div class="alert alert-success text-center" role="alert">
            {{ session()->get('success') }}
        </div>
    @endif
    @if(session()->has('info'))
        <div class="alert alert-info text-center alert" role="alert">
            {{ session()->get('info') }}
        </div>
    @endif
    @if(session()->has('danger'))
        <div class="alert alert-danger text-center alert" role="alert">
            {{ session()->get('danger') }}
        </div>
    @endif
    <!-- <section class="home">
        <div class="row h-50 card-home">
            <div class="col-sm-12 h-100 d-table">
                <div class="card card-block d-table-cell align-middle">
                    <div class="card-header">
                        Featured
                    </div>
                    <div class="card-body">
                        <form id="get_operator_form">
                            <div class="form-group row">
                                <label for="country" class="w-100">Country</label>
                                <select class="form-control" id="country">
                                    <option value="volvo">Volvo</option>
                                    <option value="saab">Saab</option>
                                    <option value="vw">VW</option>
                                    <option value="audi" selected>Audi</option>
                                </select>
                            </div>
                            <div class="form-group row">
                                <label for="phone_number" class="w-100">Phone Number</label>
                                <input type="text" class="form-control col" id="phone_number" placeholder="Enter phone number" required onchange="hideOption()">
                                <button type="submit" class="ml-2 btn btn-primary col-auto"><i class="fa fa-spinner fa-spin d-none"></i> Search</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
@endsection
