@extends('layouts.app') @section('content') {!! $header !!}
<div class="container">
    <ul class="breadcrumb">
        @foreach ($breadcrumbs as $breadcrumb)
        <li>
            <a href="{{$breadcrumb['href']}}">{{ $breadcrumb['text']}}</a>
        </li>
        
        @endforeach
    </ul>
</div>
<div class="container">
    <div class="row">
    <?php $class = 'col-sm-12'; ?>
    <?php if ($products) { ?>   
        <div class="<?php echo $class; ?>">
            <div class="row-page">
                <div class="right-side-control" id="content">
                    <div class="top-aligner-category">
                        <div class="col-md-1 hidden-sm hidden-xs">
                            <div class="row">
                          </div>
                        </div>
                    </div>
                    
            <div class="columns is-mobile is-tablet is-desktop is-multiline">
            </div>
                <?php foreach ($products as $product) { ?>

                <div class="product-layout product-grid col-lg-3 col-md-4 col-xs-6">
                    <div class="row">
                    <div class="product-thumb">
                        <div class="wishlist-ghost" onclick="wishlist.add('<?php echo $product['product_id']; ?>');">
                            <i class="fa fa-heart-o"></i>
                         </div>
                         <?php 
                        $images = $product['images_new'];
                        ?>
                        <div class="category-image-rad">
                            <div class="image lazy-loader-category lazy-product" id="category_product_<?php echo $product['product_id']; ?>">
                                <div id="caategory_product_carousel_<?php echo $product['product_id']; ?>" class="owl-carousel">
                                    
                                        <div v-for="data_value in src" v-bind:class="[data_value.count === 0 ? 'item' : 'item'] " >
                                            <a href="<?php echo $product['href']; ?>">
                                            <img v-lazy="data_value.image" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive"/>
                                            </a>
                                        </div>
                                    
                                </div>
                                
                            </div>
                            <script type="text/javascript"><!--
                            new Vue({
                            	el: '#category_product_<?php echo $product['product_id']; ?>',
                            	data: {
                            		src: [
                              			{ image: '<?php echo $product['images_new']; ?>'
                            			},

                            		]
                            	}
                            });
                            $('#caategory_product_carousel_<?php echo $product['product_id']; ?>').owlCarousel({
                            	items: 1,
                            	singleItem: true,
                            	autoPlay: false,
                            	navigation: true,
                            	navigationText: ['<i class="fa fa-chevron-left fa-1x"></i>', '<i class="fa fa-chevron-right fa-1x"></i>'],
                            	pagination: true,
                            });
                            --></script>
                            <style>
#caategory_product_carousel_<?php echo $product['product_id']; ?> .item{
    width: 100%!important;
}
#caategory_product_carousel_<?php echo $product['product_id']; ?> img{
    width: 100%!important;
}
</style>
                        </div>
                        <div class="caption">
                            <div class="caption-range">
                                <h4 class="set-limit-textrow"><a href="<?php echo $product['href']; ?>"><?php if (strlen($product['name']) >= 60 )
                                        {
                                        echo substr($product['name'], 0, 60).' ...';
                                        } else {
                                        echo $product['name'];
                                        }?></a></h4>
                                <?php if ($product['price']) { ?>
                                <p class="price">
                                    <?php echo $product['price']; ?>
                                    
                                </p>
                                <p>
                                        
                                    </p>
                            </div>
                            <div class="info-location-seller">
                                <p><a class="store-seller-namedetails" href="<?php echo $product['seller_profile']; ?>">
                                        <?php echo $product['store_name']; ?></a>
                                    <div class="co-location-seller">
                                        <i class="fa fa-map-marker"></i>&nbsp;<?php echo $product['shop_zone']; ?>
                                   </div>
                                </p>
                            </div>
                            <?php } ?>
                           
                        </div>
                    </div>
                    </div>
                </div>
                <?php } ?>
        <div class="pagination-category-set">
            <span class="pull-left"></span>
            
        </div>
    </div>
    </div>
    </div>
    </div>
    </div>
        <?php }  else { ?>
            <div class="well flowover-auto">
                <h3 class="title-product-input text-center"><?php echo $text_empty; ?></h3>
            </div>
        <?php } ?>
        <?php if ($description) { ?>
        <div class="container" style="display:none;">
            <div class="row">
                <h2 class="desc-category-det"><?php echo $description; ?><h2>
            </div>
        </div>
        <?php } ?>
</div>
</div>
    {!! $footer !!}
@endsection