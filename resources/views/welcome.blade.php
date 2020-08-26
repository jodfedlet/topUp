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
    <div class="row h-50">
        <div class="col-sm-12 h-100 d-table">
            <div class="card card-block d-table-cell align-middle">
                <div class="card-header">
                    Featured
                </div>
                <div class="card-body">
                    <h5 class="card-title">Special title treatment</h5>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
    </div>
@endsection
