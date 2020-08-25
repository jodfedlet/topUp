<footer id="footer">
        <div class="container-fluid"><!-- container-->
        <div class="row">
            <div class="col-sm-6 col-md-2">
                
                <h4>Enstitisyon an</h4>
                <ul>
                    <li><a href="#">VinHT</a></li>
                    <li><a href="{{route('site.contact')}}">Kontakte nou</a></li>
                    <li><a href="#">Politik & Konfidansyalite</a></li>
                    <li><a onclick="seller({{Auth()->guard('client')->guest() ? 0 : Auth()->guard('client')->user()->id}})">Vann nan Nuvann</a></li>
                </ul>
                
                <hr>
                
                <h4>Espas Kliyan</h4>
                <ul>
                    <li><a href="{{route('site.konekte')}}">Konekte</a></li>
                </ul>
                
                <hr class="hidden-md hidden-lg hidden-sm">
                
            </div>
            
            <div class="com-sm-6 col-md-4">
                
                <h4>Lyen kap edew</h4>
                <ul>
                    <li><a href="#">Anile yon kòmand</a></li>
                    <li><a href="#">Fè yon reklamasyon</a></li>
                    <li><a href="#">Prezans an Liy</a></li>
                </ul>
                <hr class="hidden-md">
                
                <h4>Metòd Pèman</h4>
                
                <p>
                    <img src="img/Payment/elo.svg" alt="">
                    <img src="img/Payment/visa.svg" alt="">
                    <img src="img/Payment/boleto.svg" alt="">
                    <img src="img/Payment/paypal.svg" alt="">
                    
                </p>
                
                
                
                
            </div>
            
            <div class="col-sm-6 col-md-2">
                <h4>Lokalize nou</h4>
                
                <p class="footer-adress">
                    <strong>VinHt Group .SA</strong>
                    <br/>Brasil
                    <br/>Chapeco
                    <br/>222-333-333
                    <br/>contact@vinht.com
                </p>
                
                <hr class="hidden-md hidden-lg">
                
            </div><!-- col-sm-6 col-md-3 Finish -->
            
            <div class="col-sm-6 col-md-3">
                
                <!-- form Finish -->
                
                <hr>
                
                <h4>Swiv Nou</h4>
                
                <p class="social">
                    <a href="#" class="fa fa-facebook"></a>
                    <a href="#" class="fa fa-twitter"></a>
                    <a href="#" class="fa fa-instagram"></a>
                    <a href="#" class="fa fa-google-plus"></a>
                    <a href="#" class="fa fa-envelope"></a>
                </p>
                
                <hr class="hidden-md hidden-lg">
                
                <h4>Rete veyatif !</h4>
                
                <p class="text-muted">
                    pouw ka gen tout denye pwodwi yo.
                </p>
                
                <form action="" method="post">
                    <div class="input-group">
                        
                        <input type="text" class="form-control" name="email" placeholder="Antre E-mail ou">
                        
                        <span class="input-group-btn">
                            
                            <input href="#" type="submit" value="Enskri" class="btn btn-info">
                            
                        </span>
                        
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</div>

<div id="copyright">
    <div class="container ">
        <div class="col-md-6 ">
            
            <p class="pull-left">&copy; 2020 vinHT Store All Rights Reserve</p>
            
        </div><!-- col-md-6 Finish -->
        <div class="col-md-6"><!-- col-md-6 Begin -->
        <p class="pull-right"> Create by: <a class="all-right" href="https://mjcode.net/"><strong class="mjcode">MJcode Groupe</strong></a></p>
        
    </div><!-- col-md-6 Finish -->
</div><!-- container Finish -->

</footer>
<!-- AS Scripts -->
@include('layouts._site._footer_links')
