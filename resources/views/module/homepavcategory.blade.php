<div class="container">
    <div class="row">
        <div class="home-side-control">
            <div class="col-md-12 hidden-sm hidden-xs">
                <div class="row">
                    <div class="display-other-category">
                        <div class="col-md-10">
                            <div class="display-other-categorytext">
                                <h3 class="full-left all-category"><?php echo $category_name; ?></h3>
                            </div>
                        </div>
                        <div class="col-md-2" style="width:unset;float: unset;">
                            <div class="display-other-categorybtn cat-homepav-desc">
                                {{$category_desc}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="home-category-bush">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="row">
                        <div id="carousel<?php echo $module; ?>" class="owl-carousel cat-tabs">
                          <?php foreach ($products as $product) { ?>
                          <div class="item">
                            <div class="product-layout">
                            <div class="product-thumb transition home">
                              <div class="image-lazy-profile">
                                  <div class="image" id="banner_product_<?php echo $product['product_id']; ?>" >
                                      <a href="p/{{$product['store_name_seo']}}/{{$product['name']}}" title="<?php echo $product['name']; ?>">
                                          <img v-for="item in src" v-lazy="item" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" />
                                      </a>
                                  </div>
                                  <script>
                                    new Vue({
                                    	el: '#banner_product_<?php echo $product['product_id']; ?>',
                                    	data: {
                                    		src: [
                                    			'<?php echo $product['thumb']; ?>'
                                    		]
                                    	}
                                    })	
                                    </script>
                              </div>
                              <div class="caption">
                                  <div class="caption-range">
                                    <h4 class="set-limit-textrow">
                                    <a href="p/{{$product['store_name_seo']}}/{{$product['name']}}" class="text-font-product" title="<?php echo $product['name']; ?>">
                                        <?php if (strlen($product['name']) >= 50 ) { 
                                        echo substr($product['name'], 0, 50);
                                        } else {
                                        echo $product['name'];
                                        }?></a>
                                    </h4>
                                    <!--<p><?php echo $product['description']; ?></p>-->
                                    <?php if ($product['price']) { ?>
                                   <p class="price"> 
                                      <?php echo $product['price']; ?>
                            	</p>
                            	<p>
                                    
                                    <?php } ?>
                              </p>
                            	
                        	</div>
                        	<div class="info-location-seller">
                                <div class="exact-group-infoseller">
                                    <span class="exact-location-seller">
                                        <i class="fa fa-map-marker"></i> Pekanbaru
                                    </span>    
                                    <span class="exact-store-name">
                                      <?php echo $product['store_name']; ?>
                                    </span>
                                </div>
                            </div>
                              </div>
                            </div>
                          </div>
                          </div>
                          <?php } ?>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>
<!-- </div> -->
<script type="text/javascript"><!--
$('#carousel<?php echo $module; ?>').owlCarousel({
	items: 6,
	autoPlay: false,
	navigation: true,
	navigationText: ['<i class="fa fa-angle-left fa-3x"></i>', '<i class="fa fa-angle-right fa-3x"></i>'],
	pagination: false
});
--></script>



<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>