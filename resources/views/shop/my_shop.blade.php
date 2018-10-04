@extends('layouts.app')
@section('content')
{!! $header !!}
<div class="container">
  <?php if ($error_warning) { ?>
  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
  <?php } ?>
	<div class="row">
		{!! $column_left !!}
    <div id="content" class="col-sm-9">
			<div class="row-page">
			<div class="right-side-control">
      	<h1>Informasi Toko</h1><br/><br/>
        <div id="banner-shop"> 
         @if ($banner)
              <img class="img-responsive image-page-kios" align="center" src="{{$banner}}" title="{{$shop_name}}" alt="{{$shop_name}}">
          @endif
          @if ($is_shop)
          <div class="user-change-shopbanner" id="upload-banner">
            <a class="btn btn--gray btn--small" href="javascript:void(0)">+ Ganti gambar</a>
          </div>
          @endif
      </div>
      <br/>
      <form action="{{ route('add_shop') }}"  method="POST" enctype="multipart/form-data" class="form-horizontal">
      {{ csrf_field() }}
        <fieldset>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-shop-name">Nama Toko</label>
            <div class="col-sm-10" id="shop_name">
                <?php if ($check_shop_name_value) { ?>
              <input type="text" name="shop_name" value="{{$shop_name}}" placeholder="Masukkan Nama Toko" id="input-shop-name" class="form-control" readonly/>
              <?php } else { ?>
              <input type="text" name="shop_name" value="{{$shop_name}}" placeholder="Masukkan Nama Toko" id="input-shop-name" class="form-control" />
              <?php } ?>
              <?php if ($error_shop_name) { ?>
              <div class="text-danger"><?php echo $error_shop_name; ?></div>
              <?php } ?>
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-description">Deskripsi Toko</label>
            <div class="col-sm-10">
	       <textarea name="shop_description" placeholder="Deskripsi Toko" id="input-shop-description" class="form-control">{{$shop_description}}</textarea>
            </div>
          </div>
         <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-shop-address">Alamat toko</label>
            <div class="col-sm-10">
              <input type="text" name="shop_address" value="{{$shop_address}}" placeholder="Alamat Toko" id="input-shop-address" class="form-control" />
              <?php if ($error_address) { ?>
              <div class="text-danger"><?php echo $error_address; ?></div>
              <?php } ?>
            </div>
          </div>
	
        </fieldset>
        <div class="buttons clearfix">
          <div class="pull-right">
            <input type="submit" value="Simpan" class="btn btn-primary" />
          </div>
        </div>
      </form>
</div>
</div>
</div>
</div>

<script type="text/javascript"><!--
$('#upload-banner').on('click', function(event){
    event.preventDefault();
    
	$('#form-upload').remove();
	
	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" value="" />{{ csrf_field() }}</form>');
	
	$('#form-upload input[name=\'file\']').trigger('click');
	
	if (typeof timer != 'undefined') {
    	clearInterval(timer);
	}

	timer = setInterval(function() {
		if ($('#form-upload input[name=\'file\']').val() != '') {
			clearInterval(timer);
			
			$.ajax({
				url: 'upload_files',
				type: 'post',		
				dataType: 'json',
				data: new FormData($('#form-upload')[0]),
				cache: false,
				contentType: false,
				processData: false,		
				beforeSend: function() {
//					$('#button-upload i').replaceWith('<i class="fa fa-circle-o-notch fa-spin"></i>');
//					$('#button-upload').prop('disabled', true);
				},
				complete: function() {
//					$('#button-upload i').replaceWith('<i class="fa fa-upload"></i>');
//					$('#button-upload').prop('disabled', false);
				},
				success: function(json) {
					if (json['error']) {
						alert(json['error']);
					}
					
					if (json['success']) {
                        var newcoll = {"_token": "{{ csrf_token() }}",'image_name': json['success']};
                        jQuery.ajax({
                            url:'my_shop/update_banner', 
                            type:'post',
                            data: newcoll,
                            success:function(results) {
                                $(".img-responsive image-page-kios").remove();
                                $("#banner-shop").html(results);
                                event.preventDefault(); 
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                            }
                        });

					}
				},			
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});	
		}
	}, 500);
});
//--></script>
<style>
    .stl_table {
        margin: auto;
        padding: 0px;
    }
</style>
</div>
{!! $footer !!}
@endsection