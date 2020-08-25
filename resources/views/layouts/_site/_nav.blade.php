<header>
<nav class="navbar navbar-expand-lg navbar-dark">
  <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse  navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">

      <li class="nav-item">
        <a class="nav-link" href="">Prensipal</a>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><Span>Kategori</span></a>
        <div class="dropdown-menu">

        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="">Pwomosyon</a>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="mega-two" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Lòt Sèvis</a>
        <div class="dropdown-menu">
          <a class="dropdown-item" href="#">...</a>
          <a class="dropdown-item" href="#">...</a>
          <a class="dropdown-item" href="#">...</a>
          <a class="dropdown-item" href="#">...</a>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" >Vann</a>
      </li>

      <li class="nav-item">
        <a class="nav-link" >Kontak</a>
      </li>

    </ul>
  </div>
</nav>

</header>

<!-- Modal seller -->
<div class="modal fade" id="sellerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
          <h5 class="modal-title">Enfomasyon Adisyonel</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
             <div class="container">
                <form action="" id="sellerForm" class="sellerForm form">
                    <div class="form">
                      <label for="cpf">CPF<span class="req"> *</span> </label>
                      <input id="sellerCPF" name="CPF" placeholder="778.351.240-25" class="form-control input-md @error('CPF') is-invalid @enderror" type="text" value="{{old('CPF')}}" onfocusout="validateSellerCPF()">
                      <i class="fa fa-check-circle"></i>
                      <i class="fa fa-exclamation-circle"></i><br>
                      <small>Error message</small>
                    </div>

                    <div class="form">
                        <label for="Date">Dat nesans <span class="req">*</span> </label>
                        <input type="date" id="birthday" name="birthday" class="form-control input-md @error('birthday') is-invalid @enderror" value="{{old('birthday')}}">
                        <i class="fa fa-check-circle"></i>
                        <i class="fa fa-exclamation-circle"></i><br>
                        <small>Error message</small>
                    </div>

                    <div class="form">
                        <label for="phone">Telefòn</label>
                        <input type="txt" class="form-control" id="phone" name="telephone" value="{{old('telephone')}}" onfocusout="phoneValidation()">
                        <i class="fa fa-check-circle"></i>
                        <i class="fa fa-exclamation-circle"></i>
                        <small>Error message</small>
                    </div>

                    <fieldset>
                            <div id="address" class="container-fluid tab-pane "><br>
                                <h3>Adrès</h3>
                                <div class="form">
                                    <label for="cep">CEP</label>
                                    <input id="cep" name="CEP"  class="form-control input-md" type="text" maxlength="8" value="{{old('CEP')}}" onfocusout="cepValidation()">
                                    <i class="fa fa-check-circle"></i>
                                    <i class="fa fa-exclamation-circle"></i>
                                    <small>Error message</small>
                                </div>
                                <button type="button" class="btn btn-primary pull-right" onclick="pesquisacep(cep.value)">Rechèche</button>
                                <br>

                                <label for="adres">Adrès</label>
                                <input type="text" class="form-control" id="rua" name="address" required="" readonly="readonly" value="{{old('address')}}">

                                <label for="numero">No</label>
                                <input id="number" name="number" class="form-control" placeholder="" type="text" value="{{old('number')}}">

                                <label for="bairro">Katye</label>
                                <input id="bairro" name="neighborhood" class="form-control" placeholder="" required="" readonly="readonly" type="text" >

                                <label for="cidade">Vil</label>
                                <input id="cidade" name="city" class="form-control" placeholder="" required=""  readonly="readonly" type="text">

                                <label for="estado">Eta</label>
                                <input id="estado" name="state" class="form-control" placeholder="" required=""  readonly="readonly" type="text">
                            </div>


                            <br><div class="form-group form-check">
                              <input type="checkbox" name="term" id="term" class="form-check-input">
                              <label class="form-check-label" for="exampleCheck1">I Agree Terms & Coditions</label>
                            </div>
                      <button type="submit" class="btn btn-primary pull-right" id="btn-sellerModal">
                        Aksepte
                      </button>
                        </fieldset>

                </form>
            </div>
          </div>
      </div>
      </div>
    </div>
<!--End  Modal seller -->

