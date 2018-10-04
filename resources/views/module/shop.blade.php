    <div class="row-page">
        <div class="shop-left">
            <div class="shop-left-customer-details">
                <ul class="list-unstyled">
                    <li class="customer-name">
                        <img src="<?php echo $profile_pic; ?>" alt="customer" title="customer" data-placeholder="<?php echo $placeholder; ?>">
                    </li>
                    <a href="/s/{{$seo_name_shop}}"><li class="shop-left-money">
                        <span>{{$shop_name}}</span>
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
                </ul>
                
            </div>
        </div>
    </div>


