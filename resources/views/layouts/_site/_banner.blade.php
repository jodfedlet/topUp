<div id="page-home">


    <div class="banner-content text-center">
        <h1>Nous fournissons des recharges mobiles à des millions de personnes dans le monde</h1>
        <p>Recharges mobiles en ligne et
          rester connecté avec les personnes qui comptent le plus.
        </p>

        <div class="card w-75">
          <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <form id="get_operator_form">
                <div class="form-group row">
                  <select class="form-control" id="country">
                      @foreach ($countries as $country)
                          <option value="{{$country->isoName}}">
                              {{$country->name}}
                          </option>
                      @endforeach
                  </select>
                </div>
                <div class="form-group row">
                    <!-- <label for="phone_number" class="w-100">Phone Number</label> -->
                    <input type="text" class="form-control col" id="phone_number" placeholder="Enter phone number" required onchange="hideOption()">
                </div>
                <button type="submit" class="ml-2 btn btn-primary pull-right"><i class="fa fa-spinner fa-spin d-none"></i> Search</button>

            </form>
          </div>
        </div>

</div>

    </div>
</div>
