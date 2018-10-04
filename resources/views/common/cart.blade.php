@extends('layouts.app') @section('content') {!! $header !!} 
<div class="container">
<ul class="breadcrumb">
        @foreach ($breadcrumbs as $breadcrumb)
        <li>
            <a href="{{$breadcrumb['href']}}">{{ $breadcrumb['text']}}</a>
        </li>
        @endforeach
    </ul>
  <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i>
    <?php echo $success; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>
  <?php if ($error_warning) { ?>
  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>
    <?php echo $error_warning; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>
  <div class="row">
    <?php $class = 'col-sm-12'; ?>
    <div id="content" class="<?php echo $class; ?>">
      <div class="row">
        <div class="col-md-7">
          <div class="row-page">
            <div class="left-side-atc generic-side-control mb-10">
              <div class="title-product-input">
                <h1>Belanjaan Kamu</h1>
              </div>
              <hr>
              <form action="" method="post" enctype="multipart/form-data">
                <?php foreach ($products as $product) { ?>
                <div class="atc-form-rowgroup">
                  <div class="details-atc-product">
                    <?php if ($product['thumb']) { ?>
                    <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>"
                        title="<?php echo $product['name']; ?>" class="img-thumbnail atc-thumb-images" /></a>
                    <?php } ?>
                    <div class="description-details-atc">
                      <div class="text-left">
                        <a class="rate-title" href="<?php echo $product['href']; ?>">
                          <?php echo $product['name']; ?></a>
                        <?php if (!$product['stock']) { ?>
                        <span class="text-danger">***</span>
                        <?php } ?>
                        <div class="text-left">
                          <?php echo $product['price']; ?>
                        </div>
                      </div>
                    </div>
                    <td class="text-left">
                      <div class="input-group col-md-3">
                        <input type="text" name="quantity[<?php echo $product['cart_id']; ?>]" value="<?php echo $product['quantity']; ?>"
                          size="1" class="form-control" />
                        <span class="input-group-btn">
                          <button type="submit" data-toggle="tooltip" title="Ubah" class="btn btn-link"><i class="fa fa-refresh"></i></button>
                          <button type="button" data-toggle="tooltip" title="Hapus" class="btn btn-danger" onclick="cart.remove('<?php echo $product['cart_id']; ?>');"><i
                              class="fa fa-times-circle"></i></button>
                        </span>
                      </div>
                    </td>
                  </div>
                </div>
                <?php } ?>
            </div>
          </div>
        </div>
        </form>
        <div class="col-md-5 control-affix-product">
          <div class="row-page">
            <div class="approx-atc-cart">
              <?php foreach ($totals as $total) { ?>
              <div class="text-rightside-atc"><strong>
                  <?php echo $total['title']; ?>:</strong></div>
              <?php echo $total['text']; ?>
              <?php } ?>
            </div>
            <div class="buttons clearfix row-btn-cart">
              <?php if(!$checkout_empty) { ?>
              Keranjang belaja kamu kosong!!
              <?php } ?>
              <?php if($checkout_empty) { ?>
              <div class="col-sm-6">
                <a href="Lanjutkkan" class="btn btn-block btn-lg btn-link">Belanja terus</a>
              </div>
              <div class="col-sm-6">
                <a href="{{$checkout}}" class="btn btn-block btn-lg btn-primary">Bayar</a> 
              </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  {!! $footer !!}
  @endsection