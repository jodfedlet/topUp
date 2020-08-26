@extends('layouts.site')

@section('title','System')

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
    <section>
        <form action="/settings" method="post">
            {{csrf_field()}}
            <div class="form-group">
                <label for="client_id">Client ID:</label>
                <input type="text" class="form-control" id="client_id" name="client_id" required placeholder="Client ID" value="pdJBrecdcLVSUNneFmuUzBw8NXjugIcx">
            </div>

            <div class="form-group">
                <label for="client_secret">Client Secret:</label>
                <input type="text" class="form-control" id="client_secret" name="client_secret" required placeholder="Client secret" value="2BpfIVt72H-NbEWFeqlIYUtXATW1Wx-OJ0S4FRHO28TNQJSVRQOAO0LAOvwSDJH">
            </div>

            <div class="form-group" align="center">
                <select class="form-control form-control-sm" id="api_mode" name="api_mode" required>
                    <option value="">API mode</option>
                    <option value="LIVE">LIVE</option>
                    <option value="TEST">TEST</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success pull-right">Add</button>
        </form>
    </section>
@endsection

