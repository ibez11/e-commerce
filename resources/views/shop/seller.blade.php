@extends('layouts.app')
@section('content')
{!! $header !!}
<div class="container">
	<div class="row">
		{!! $column_left !!}
    <div id="content" class="col-sm-9">
			<div class="row-page">
			<div class="right-side-control">
      	<br/><br/>
        <div id="banner-shop"> 
         @if ($banner)
              <img class="img-responsive image-page-kios" align="center" src="{{$banner}}" title="{{$shop_name}}" alt="{{$shop_name}}">
          @endif
      </div>
      <br/>
      <header>
      <div class="user-header"> 
        <div class="user-header__user-name">
            <h1 class="u-txt--xlarge u-mrgn-bottom--2">
                {{$shop_name}}
            </h1>
        </div>
      </div>
      </header>
      <div id="content" class="col-sm-9" style="width:100%">
            <div class="row-page">
                <div class="tab-product-sellp clearfix">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Produk</a></li>
                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Shop Description</a></li>
                    </ul>
                    <div class="tab-content">
        					<div role="tabpanel" class="tab-pane active" id="home">
        								<section id="sidebar-main" class="col-sm-12">
        								<div class="container-fluid" class="wrapper clearfix">
        									<!-- products -->
        									@if ($products)
        									<div class="row">
        										@foreach ($products as $product)
        										<div class="col-md-3 col-sm-4 col-xs-6">
        											<div class="row">
        											<div class="product-thumb">
        												<?php 
        												$images = $product['images_new'];
        												?>
        												<div class="seller-page-rad">
        													<div class="image lazy-loader-sellerpage" id="seller_profile_app_<?php echo $product['product_id']; ?>">
        														<div id="seller_product_carousel_<?php echo $product['product_id']; ?>" class="owl-carousel">
        															<div v-for="data_value in src" v-bind:class="[data_value.count === 0 ? 'item' : 'item'] " >
        																<a href="<?php echo $product['href']; ?>">
        																<img v-lazy="data_value.image" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive"/>
        																</a>
        															</div>
        														</div>
        													</div>
        													<script>
        														new Vue({
        															el: '#seller_profile_app_<?php echo $product['product_id']; ?>',
        															data: {
        																src: [
        																	
        																	
        																	{ image: '<?php echo $product['images_new']; ?>'
        																	},
        																	
        																]
        															}
        														});
        														$('#seller_product_carousel_<?php echo $product['product_id']; ?>').owlCarousel({
        															items: 1,
        															singleItem: true,
        															autoPlay: false,
        															navigation: true,
        															navigationText: ['<i class="fa fa-chevron-left fa-1x"></i>', '<i class="fa fa-chevron-right fa-1x"></i>'],
        															pagination: true,
        														});
        														</script>
        														<style>
        														#seller_product_carousel_<?php echo $product['product_id']; ?> .item{
        															width: 100%!important;
        														}
        														#seller_product_carousel_<?php echo $product['product_id']; ?> img{
        															width: 100%!important;
        														}
        														</style>
        														</div>
        														<div class="caption">
        															<h4 class="set-limit-textrow"><a href="<?php echo $product['href']; ?>">
        																	<?php if (strlen($product['name']) >= 50 ) {
        																echo substr($product['name'], 0, 40).' ...';
        																} else {
        																echo $product['name'];
        																}?></a></h4>
        														<?php if ($product['price']) { ?>
        														<p class="price">
        															
        															<?php echo $product['price']; ?>

        														</p>
        														<?php } ?>
        													</div>
        											    </div>
        											</div>
        										</div>
        										@endforeach
        									</div>
        									@else
        									<p><?php echo $text_empty; ?></p>
        									<div class="buttons">
        										<div class="pull-right">
        											<a href="<?php echo $continue; ?>"class="btn btn-primary"><?php echo $button_continue; ?></a>
        										</div>
        									</div>
        									@endif
        									<!-- end of products -->
        								</div>
        								<?php //echo $ui; ?>
        					</div>
        					<div role="tabpanel" class="tab-pane" id="profile">
        						<div id="shop">
        							<div class="profile-header-bottom">
        								<?php if($shop_description){ ?>
        								<p><?php echo $shop_description; ?></p>
        								<?php  } ?>
        							</div>
        						</div>
        					</div>
        				</div>
                </div>
            </div>
        </div>
</div>
</div>
</div>
</div>

<style>
    .stl_table {
        margin: auto;
        padding: 0px;
    }
</style> 
</div> 
{!! $footer !!}
@endsection