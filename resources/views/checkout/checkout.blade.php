@extends('layouts.app') @section('content') {!! $header !!}
<div class="container">
   <?php if ($error_warning) { ?>
   <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>
      <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
   </div>
   <?php } ?>
   <div class="row">
   <form action="{{route('pay')}}" method="post" enctype="multipart/form-data" id="form-checkout">
    {{ csrf_field() }} 
      <?php $class = 'col-sm-12'; ?>
      <div id="content" class="<?php echo $class; ?>">
         <div class="row">
            <div class="col-md-7">
               <div class="row-page">
                  <div class="left-side-atc generic-side-control mb-10">
                     <div class="title-product-input">
                        <h1>Detail Pembeli</h1>
                     </div>
                     <hr>
                     
                        <div class="atc-form-rowgroup">
                           <div class="details-atc-product">
                              <div class="form-group required">
                                 <label class="col-sm-6 control-label" for="input-name-received">Nama Penerima</label>
                                 <div class="col-sm-10">
                                    <input type="text" name="name_receive" value="{{$received_name}}" placeholder="Masukkan Nama penerima" id="input-name-received" class="form-control"/>
                                    <?php if ($error_received_name) { ?>
                                    <div class="text-danger"><?php echo $error_received_name; ?></div>
                                    <?php } ?>
                                 </div>
                              </div>
                              <div class="form-group required">
                                 <label class="col-sm-6 control-label" for="input-phone">Telepon/Handphone</label>
                                 <div class="col-sm-10">
                                    <input type="text" name="phone" value="{{$phone}}" placeholder="Masukkan Telepon/Handphone" id="input-phone" class="form-control"/>
                                    <?php if ($error_received_name) { ?>
                                    <div class="text-danger"><?php echo $error_received_name; ?></div>
                                    <?php } ?>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="atc-form-rowgroup">
                        <div class="details-atc-product">
                              <div class="form-group required">
                                 <label class="col-sm-6 control-label" for="input-provinsi-name">Masukkan Alamat</label>
                                 <div class="col-sm-10">
                                    <textarea name="address" class="form-control">Masukkan alamat</textarea>
                                    <?php if ($error_received_name) { ?>
                                    <div class="text-danger"><?php echo $error_received_name; ?></div>
                                    <?php } ?>
                                 </div>
                              </div>
                           </div>
                           <div class="details-atc-product">
                              <div class="form-group required">
                                 <label class="col-sm-6 control-label" for="input-provinsi-name">Provinsi</label>
                                 <div class="col-sm-10">
                                    <select name="zone_id" id="input-zone" class="form-control">
                                       <option value="" selected>Pilih Provinsi</option>
                                       @foreach($zones as $zone)
                                       <option value="{{$zone['zone_id']}}" selected>{{$zone['name']}}</option>
                                       @endforeach
                                    </select>
                                    <?php if ($error_received_name) { ?>
                                    <div class="text-danger"><?php echo $error_received_name; ?></div>
                                    <?php } ?>
                                 </div>
                              </div>
                           </div>
                           <div class="details-atc-product">
                              <div class="form-group required">
                                 <label class="col-sm-6 control-label" for="input-provinsi-name">Kota</label>
                                 <div class="col-sm-10">
                                    <select name="state_id" id="input-state" class="form-control">
                                       <option value="" selected>Pilih Kota</option>
                                    </select>
                                    <?php if ($error_received_name) { ?>
                                    <div class="text-danger"><?php echo $error_received_name; ?></div>
                                    <?php } ?>
                                 </div>
                              </div>
                           </div>
                           <div class="details-atc-product">
                              <div class="form-group required">
                                 <label class="col-sm-6 control-label" for="input-provinsi-name">Kecamatan</label>
                                 <div class="col-sm-10">
                                    <select name="district_id" id="input-district" class="form-control">
                                       <option value="" selected>Pilih Kecamatan</option>
                                    </select>
                                    <?php if ($error_received_name) { ?>
                                    <div class="text-danger"><?php echo $error_received_name; ?></div>
                                    <?php } ?>
                                 </div>
                              </div>
                           </div>
                        </div>
                        
                  </div>
                  </div>
                  <div class="row-page">
                  <div class="left-side-atc generic-side-control mb-10">
                  <div class="title-product-input">
                  <h1>Detail Belanjaan Kamu</h1>
                  </div>
                  <hr>
                  <?php foreach ($products as $product) { ?>
                
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
                  </div>
                
                <?php } ?>
                  </div>
                  </div>
            </div>
            <div class="col-md-5 control-affix-product">
               <div class="row-page">
                  <div class="title-product-input">
                     <h1>Ringkasan Belanjaan</h1>
                  </div>
                  <hr>
                  <div class="approx-atc-cart">
                     @foreach ($totals as $total)
                     <div class="text-rightside-atc"><strong>
                        {{$total['title']}}:</strong>
                     </div>
                     {{$total['text']}}
                     @if($total['title'] == 'Sub Total') 
                     <input type="text" style="display:none;" name="sub-total" value="{{$total['price']}}" id="input-sub-total" class="form-control"/>
                     @endif
                     @endforeach
                  </div>
                  <div class="buttons clearfix row-btn-cart">
                     <?php if(!$checkout_empty) { ?>
                     Keranjang belaja kamu kosong!!
                     <?php } ?>
                     <?php if($checkout_empty) { ?>
                     <div>
                     <button type="submit" form="form-checkout" data-toggle="tooltip" title="Simpan" name="submit" class="btn btn-block btn-lg btn-primary" value="pay">Bayar</button>
                     </div>
                     <?php } ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   </form>
</div>
<script type="text/javascript"><!--
   $('#input-zone').change(function() {
    $.ajax({
		url: '/location/zone',
    type: 'post',
    data: { 'zone_id': this.value, "_token": "{{ csrf_token() }}"},
		dataType: 'json',
		beforeSend: function() { 
			
		},
		complete: function() {
			$('.fa-spin').remove();
		},
		success: function(json) {
			
			html = '<option value="">Pilih Kota</option>';
      for (i = 0; i < json['state'].length; i++) {
          html += '<option value="' + json['state'][i]['state_id'] +'" selected="selected">' + json['state'][i]['name'] + '</option>';
      }

			$('#input-state').html(html);
			$('#input-state').trigger('change');
		
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});

  $('#input-state').on('change', function() {
	$.ajax({
		url: '/location/state',
    type: 'post',
    data: { 'state_id': this.value, "_token": "{{ csrf_token() }}"},
		dataType: 'json',
		beforeSend: function() {
			
		},
		complete: function() {
			$('.fa-spin').remove();
		},
		success: function(json) {
			html = '<option value="">Pilih Kecamatan</option>';
			if (json['district'] && json['district'] != '') {
				for (i = 0; i < json['district'].length; i++) {
					html += '<option value="' + json['district'][i]['district_id'] +'"';

				
					html += '>' + json['district'][i]['name'] + '</option>';
				}
			} else {
				html += '<option value="0" selected="selected">Tidak ada</option>';
			}

			$('#input-district').html(html);
			//$('#collapse-payment-address select[name=\'district_id\']').trigger(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});
});
   //-->
</script>
{!! $footer !!}
@endsection