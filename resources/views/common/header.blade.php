<nav class="header">
         <div class="container">
         <div id="row">
            <button type="button" class="navbar-toggle adjust-toggle-push" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only toggle-web-push">Toggle navigation</span>
            <i class="fa fa-bars" style="font-size: 24px;"></i>
            </button> 
            <div class="col-xs-8 col-sm-2">
               <div class="row">
                  <div id="logo">
                     <div style="all: unset;"><a href="{{route('home')}}"><h1 style="color: #fff;"class="img-responsive">OL SHOP</h1></a></div>
                  </div>
               </div>
            </div>
            <div class="col-sm-1">
                <div class="row">
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                  <ul class="nav navbar-nav after-log-main">
                    <li class="dropdown">
                    <a href="javascript:void(0)" title="Kategori" data-toggle="dropdown">
                        <h2 class="u-mrgn-bottom--0 c-category-navbar__title u-txt--fair js-dropdown-toggle" style="margin-top: unset;">
                            <?php echo 'Kategori'; ?>&nbsp;&nbsp;<i class="fa fa-caret-down" style="font-size:14px"></i>
                        </h2>
                    </a>
                    {!! $categories_header !!}
                    </li>
                    </ul>
                </div>
                </div>
            </div>
            @if($islogged)
            <div class="col-xs-12 col-sm-4">
            @else
            <div class="col-xs-12 col-sm-6">
            @endif
               <div id="search" class="input-group">
                  <input name="search" value="" placeholder="Cari di Jastek" class="form-control input-lg" autofocus="" type="text">
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default btn-lg"><i class="fa fa-search"></i></button>
                  </span>
               </div>
            </div>
            @if($islogged)
            <div class="col-xs-12 col-sm-5">
            @else
            <div class="col-xs-12 col-sm-3">
            @endif
               <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                  <ul class="nav navbar-nav after-log-main">
                  @if($islogged)
                    @if($is_shop)
                    <li id="shop_dropdown" class="dropdown">
                               <a href="javascript:void(0)" title="gdgfdg" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-building-o"></i> 
                                     <span class="hidden-sm hidden-md">
                                     Toko 
                                     </span>
                                     <!-- <span class="caret"></span> -->
                               </a>
                               <ul class="dropdown-menu dropdown-menu-right"> 
                                  <li><a href="{{route('my_shop')}}">{{$shop_name}}</a>
                                  </li>
                                  <li><a href="{{route('add_product')}}">Tambah Produk
                                     </a>
                                  </li>
                                  <li>
                                     <a href="{{route('my_product')}}">Daftar Produk</a>
                                  </li>
                               </ul>
                            
                         </li>
                    @endif
                    @endif
                     @if(!$islogged) 
                     <li><a class="nav-outside-register" href="{{ url('register') }}">Daftar</a></li>
                     <li class="nav-outside-login"><a class="login-btn-outside" href="{{ url('login') }}">Masuk</a></li>
                     @else
                     <li id="account_dropdown" class="dropdown">
                        <a href="javascript:void(0)" title="<?php echo 'Akun'; ?>" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-user-o"></i>
                                    <!-- <span class="caret"></span>-->
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a class="login-btn-outside" href="my_account">Hi,<br/><b>{{$fullname}}</b></a></li>
                            <li><a class="login-btn-outside" href="{{route('order')}}" style="border-bottom: unset;">Pembelian</a></li>
                            <li><a class="login-btn-outside" href="barang_favorit" style="border-bottom: unset;">Barang Favorit</a></li>
                            <li><a class="login-btn-outside" href="{{ url('logout') }}" style="border-bottom: unset;">Logout</a></li> 
                        </ul>
                      </li>
                     @endif
                     <li class="cart">
                        <div id="cart" class="btn-group btn-block logged-out-cart">
                        <a href="{{route('cart')}}"><i class="fa fa-shopping-bag"></i> <span id="cart-total">{{$total_cart}}</span></a>
                        </div>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
      </nav>
      <div class="verticalmenu">
         <div id="top-head-push">
         </div>
      </div>