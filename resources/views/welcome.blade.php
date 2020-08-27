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
    @include('layouts._site._banner')
@endsection
