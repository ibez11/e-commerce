 @extends('layouts.app') @section('content') {!! $header !!}
<div class="container">
    <ul class="breadcrumb">
        @foreach ($breadcrumbs as $breadcrumb)
        <li>
            <a href="{{$breadcrumb['href']}}">{{ $breadcrumb['text']}}</a>
        </li>
        @endforeach
    </ul>
    <div>
        <div class="container" itemscope itemtype="http://schema.org/Product">
            <div class="row">
                <?php $class = 'col-sm-12'; ?>
                <div id="content" class="{{$class}}">
                    <div class="row">
                        <?php $class = 'col-md-9'; ?>
                        <div class="{{$class}}">
                            <div class="row-page">
                                <div class="generic-side-control mb-10">
                                    <div class="col-md-4">
                                        <div class="row-page">
                                            @if ($thumb || $images)
                                            <ul class="thumbnails">
                                                @if ($thumb)
                                                <li>
                                                    <a class="thumbnail product-main-imagedir" href="{{$popup}}" title="{{$title}}">
                                                        <img itemprop="image" class="img-responsive" id="zoom_image" src="{{$thumb}}" title="{{$title}}" alt="{{$title}}" data-zoom-image="{{$popup}}"
                                                        />
                                                    </a>
                                                </li>
                                                @endif
                                            </ul>
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div id="image-additional-carousel" class="owl-carousel owl-theme">
                                                        <?php 				 
                                 $eimages = array( 0=> array( 'popup'=>$popup,'thumb'=> $thumb )  );
                                 $images = array_merge( $eimages, $images );?> @foreach ($images as $image)
                                                        <li class="image-additional">
                                                            <a class="thumbnail product-main-imagedir" href="{{$image['popup']}}"
                                                                title="{{$title}}" data-zoom-image="{{$image['popup']}}" data-image="{{$image['popup']}}">
                                                                <img src="{{$image['thumb']}}" class="img-responsive" title="{{$title}}"
                                                                    alt="{{$title}}" data-zoom-image="{{$image['popup']}}" />
                                                            </a>
                                                        </li>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="bg-gray all-pad-10 border-ddd-1 mb-10">
                                            <h1 class="ja-pd-name" itemprop="name">{{$product_name}}</h1> 
                                            <hr> @if ($price)
                                            <ul class="list-unstyled" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                                                <li>
                                                    <meta itemprop="priceCurrency" content="IDR" />
                                                    <span itemprop="price" style="display: none;">{{$price_not_currency}}</span>
                                                    <span style="display: none;">
                                                        <link itemprop="availability" href="http://schema.org/InStock" /> In stock! Order now!
                                                    </span>
                                                    <h2 class="display-pricing-product ">{{$price}}</h2>
                                                </li>
                                            </ul>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <table border="0">
                                                <tbody>
                                                    <tr class="o-layout">
                                                        <td>
                                                            Kuantiti
                                                        </td>
                                                        <td style="width:100%;">
                                                            <div id="product" class="ja-form-quantity">
                                                            {{ csrf_field() }}
                                                                <input type="text" name="quantity" value="{{$minimum}}" size="1" id="input-quantity" class="form-control" />
                                                                <input type="hidden" name="product_id" value="{{$product_id}}" />
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="form-group">
                                            <strong class="ja-fg--black">Tersedia <span class="ja-pd--blue-super-dark">{{$stock_available}}</span> barang</strong>
                                        </div>
                                        <?php if ($minimum > 1) { ?>
                                        <div class="alert alert-info">
                                            <i class="fa fa-info-circle"></i> {{$text_minimum}}</div>
                                        <?php } ?>
                                    </div>
                                    @if(!$my_product) 
                                    <div class="col-md-8">
                                            <div class="row-page">
                                                <button type="button" id="button-cart" data-loading-text="Tunggu Sebentar" class="btn-lg btn-block button-atc-productpage">
                                                <span>Beli Sekarang</span>
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                    <div>
                                    </div>
                                </div>
                                <div class="generic-side-control mb-10">
                                    <ul class="nav nav-pills">
                                        <li class="active">
                                            <a class="product-detail-desc" href="#tab-description" data-toggle="tab" style="border-radius: unset;">Detail Barang</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" style="min-height: 300px;border: 1px solid #eee; padding: 10px;">
                                        <div class="tab-pane active" id="tab-description" itemprop="description">
                                            <div class="col-xs-6 col-md-6 product-infodetails-tab">
                                                <div class="row-page">
                                                {!!$description!!}
                                                </div>
                                            </div>
                                        </div>
                                        <span itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating" style="display:none;">
                                            <span itemprop="ratingValue">4.4</span> stars, based on
                                            <span itemprop="reviewCount">89
                                            </span> reviews
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="row-page">
                                <div class="generic-side-control mb-10">
                                    <div class="u-txt--small u-txt--small-upcase u-mrgn-bottom--2">Penjual</div>
                                    <hr>
                                    <?php if ($seller) { ?>
                                    <div class="border-eee-1 clearfix mb-20 all-pad-10">
                                        <div class="col-md-4">
                                            <div class="seller-profileon-productpage">
                                                <img src="{{$thumb_shop}}" class="img-responsive img-sellerprofile-circle" title="Seller" alt="Seller">
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="qa-seller-name">
                                                <a href="{{$link_seller_profile}}">{{$seller}} &nbsp;
                                                </a>
                                            </div>
                                            <?php if ($seller_zone) { ?>
                                            <div class="ja-seller-location">
                                                <i class="fa fa-map-marker"></i>&nbsp; {{$seller_zone}}
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div id="map" class="map-dimension"></div>
                                    <?php } ?>
                                </div>
                                <div class="generic-side-control mb-10">
                                    <h3 class="title-product-input">Jasa Pengiriman</h3>
                                    <hr>
                                    <div class="setfor-table-courrier">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script src="{{ getStatic('js/elevatezoom/jquery.elevatezoom.js') }}" type="text/javascript"></script>
                <script src="{{ getStatic('js/fancybox/jquery.fancybox.js')}}" type="text/javascript"></script>
                <link href="{{ getStatic('js/fancybox/jquery.fancybox.css')}}" type="text/css" rel="stylesheet" media="screen" />
                <script type="text/javascript"><!--
                $('#button-cart').on('click', function() {
   	$.ajax({
   		url: '{{route('add_cart')}}',
   		type: 'post',
   		data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
   		dataType: 'json',
   		beforeSend: function() {
   			$('#button-cart').button('loading');
   		},
   		success: function(json) {
               console.log(json);
   			$('.alert, .text-danger').remove();
   			$('.form-group').removeClass('has-error');
   
   			if (json['error']) {
   				if (json['error']['option']) {
   					for (i in json['error']['option']) {
   						var element = $('#input-option' + i.replace('_', '-'));
   
   						if (element.parent().hasClass('input-group')) {
   							element.parent().after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
   						} else {
   							element.after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
   						}
   					}
   				}
   
   				if (json['error']['recurring']) {
   					$('select[name=\'recurring_id\']').after('<div class="text-danger">' + json['error']['recurring'] + '</div>');
   				}
   
   				// Highlight any found errors
   				$('.text-danger').parent().addClass('has-error');
   			}
   
   			if (json['success']) {
   				$('.breadcrumb').after('<div class="alert alert-success">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
   
   				$('#cart > button').html('<span id="cart-total"><i class="fa fa-shopping-basket"></i> ' + json['total'] + '</span>');
   
   				$('html, body').animate({ scrollTop: 0 }, 'slow');
   
   				window.location = "{{route('cart')}}";
   			}
   		},
           error: function(xhr, ajaxOptions, thrownError) {
               alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
           }
   	});
   });
                    $('#zoom_image').elevateZoom({
                        constrainType: "height",
                        zoomType: "lens",
                        containLensZoom: true,
                        gallery: 'image-additional-carousel',
                        cursor: 'pointer',
                        galleryActiveClass: "active"
                    });
                    $("#zoom_image").bind("click", function (e) {
                        var ez = $('#zoom_image').data('elevateZoom');
                        $.fancybox(ez.getGalleryList());

                        return false;
                    });


                    $('#image-additional-carousel').owlCarousel({
                        items: 5,
                        navigation: true,
                        navigationText: ['<i class="fa fa-chevron-left fa-5x"></i>',
                            '<i class="fa fa-chevron-right fa-5x"></i>'
                        ],
                        pagination: false
                    });
                //--></script>
                </div>
                </div>
                </div>
                </div>
                {!! $footer !!}
                @endsection