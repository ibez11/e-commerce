    <div class="row-page">
        <div class="shop-left">
            <div class="shop-left-customer-details">
                <ul class="list-unstyled">
                    <li class="customer-name">
                        <img src="<?php echo $profile_pic; ?>" alt="customer" title="customer" data-placeholder="<?php echo $placeholder; ?>">
                    </li>
                    <a href="sdgfg"><li class="shop-left-money">
                        <span>{{$text_customer_name}}</span>
                        </li></a>
                    <?php //if($isgoldMember){ ?>
                    <a href="fghgfj"><li class="username-desc" style="border-bottom:unset;">
                        <span>Username : <b>{{$text_username}}</b></span>
                        </li></a>
                    <?php //} ?> 
                    <div class="user-meta">
                        <ul class="list-unstyled">
                            Bergabung {{$date_join}}
                        </ul>
                        <ul class="list-unstyled">
                            Login terakhir {{$last_login}}
                        </ul>
                    </div>
                   @if ($is_shop) 
                    <li class="top-up"><a href="s/{{$seo_name_shop}}">Lihat Toko Saya</a> </li>
                    @endif
                </ul>
                
            </div>
            <div class="shop-left-profile">
                <h3><i class="fa fa-user-o" aria-hidden="true"></i><strong>Akun Saya</strong></h3>
                <ul class="list-unstyled">
                    <a href="fdgfdg"><li><?php echo $text_customer_name; ?></li></a>
                    <a  href="sdgdgfg"><li>Ganti Password</li></a>
                    <a  href="sdgdgfg"><li>Pembelian</li></a>
                    <a  href="fghgfh"><li>Barang Favorit</li></a>
                </ul>
            </div>
        </div>
    </div>


