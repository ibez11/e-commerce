@extends('layouts.app') 
@section('content')
{!! $header !!}
<div class="container">
<ul class="breadcrumb">
    @foreach ($breadcrumbs as $breadcrumb)
    <li><a href="{{$breadcrumb['href']}}">{{ $breadcrumb['text']}}</a></li>
    @endforeach
</ul>
  <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
  <?php } ?>
  
    <div class="row">
    {!! $column_left !!}
    <div id="content" class="col-sm-9">
    <div class="row-page">
    <div class="right-side-control">

	<h1>Tambah Produk</h1>
       <div class="panel-body panel-product">
        <div class="well">
          <div class="row">
            <div class="col-md-6">
            </div>
        </div>

        <form action="@if($product_id){{route('edit_product',['_id' =>  $product_id])}}@else{{route('add_product')}}@endif" method="post" enctype="multipart/form-data" id="form-product">
        {{ csrf_field() }} 
        <div class="addproducts-side-control mb-20">
        <h3 class="title-product-input">Info Produk</h3>
        <hr>
    <div class="tab-content">
        <div class="form-group">
            <label class="col-md-2 control-label">Tambah Gambar</label>
            <div class="tab-pane active col-sm-9" id="tab-image" > 
                <table class="table table-striped table-hover" >
                  <tbody>
                    <tr>
                      <td class="text-left" style="border-top: unset; background-color: unset;">
                    <div id="row-image">
                        <div id="image-product"> 
                        <?php $image_row = 0; ?>
                        <?php foreach ($product_images as $product_image) { ?>
                        <div class="col-sm-3-footer col-xs-6 text-center" id="image-row<?php echo $image_row; ?>" >
                        
                          <button class="user-add-img-product" type="button" onclick="return removeimagerow('<?php echo $image_row; ?>');" data-toggle="tooltip" >
                          <i class="i_image_product_form" aria-label="Hapus" alt="">Hapus</i>
                          </button>
                          <img src="<?php echo $product_image['thumb']; ?>" alt="<?php echo $placeholder; ?>" title="<?php echo $placeholder; ?>" class="new-img-thumbnail-1"/>
                          <input type="hidden" name="product_image[<?php echo $image_row; ?>][sort_order]" value="<?php echo $product_image['sort_order']; ?>" id="input-image" />
                              <?php if (isset($name_image)) { ?>
                              <?php if ($product_image['thumb1'] == $name_image) { ?>
                              <input type="hidden" name="product_image[<?php echo $image_row; ?>][image]" value="<?php echo $product_image['thumb1']; ?>" id="input-image<?php echo $image_row; ?>" />
                            <?php } else { ?>
                            <input type="hidden" name="product_image[<?php echo $image_row; ?>][image]" value="<?php echo $product_image['thumb1']; ?>" id="input-image<?php echo $image_row; ?>" />
                            <?php } ?>
                            <?php } ?>
                          </div>
                        
                        <?php $image_row++; ?>
                         <?php } ?>
                         <div id="test1">
                             
                         </div>
                         
                        <div class="col-sm-3-footer col-xs-6 text-center" id="upload-thumb-image-product">
                            <div class="row-page">
                                <a href="javascript:void(0)" class="new-img-thumbnail-1"><img src="<?php echo $thumb_no_image; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
                            </div>
                        </div>
                         </div>
                    </div>
                      </td>
                      
                  </tr>
                  </tbody>
                </table>
            </div>
        </div>
        <div class="form-group">
                    <label class="col-md-2 control-label" for="input-name1">Nama Produk</label>
                    <div class="col-sm-9">
                      <input type="text" name="name" value="<?php echo $name; ?>" placeholder="Masukkan Nama Produk" id="input-name<?php echo 1; ?>" class="form-control" />
                      <?php if (isset($error_name)) { ?>
                      <div class="text-danger"><?php echo $error_name; ?></div>
                      <?php } ?>
                    </div>
                  </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-category"><span data-toggle="tooltip" title="Kategori">Kategori</span></label>
                    <div class="col-sm-3">
                    
                        <select name="category_product" id="input-category-product" class="form-control">
                            <?php if($category_id) { ?>
                            <option value="0" ><?php echo 'Please Select'; ?></option>
                            <?php } else { ?>
                            <option value="0" selected="selected"><?php echo 'Please Select'; ?></option>
                            <?php } ?>
                            @foreach ($new_product_categories as $product_category)
                            @if ($product_category['category_id'] == $category_id)
                            <option value="{{$product_category['category_id']}}" selected="selected">{{$product_category['name']}}</option>
                            @else
                            <option value="{{$product_category['category_id']}}">{{$product_category['name']}}</option>
                            @endif
                            @endforeach
                        </select>
                      <?php if (isset($error_product_category)) { ?>
                      <div class="text-danger">Error</div>
                      <?php } ?>
                    </div>
                    <?php if (isset($error_product_sub_category0)) { ?>
                    <div id="input-sub-category0-div" >
                    <?php } else { ?>
                    <div id="input-sub-category0-div" style="display:none;">
                    <?php } ?>
                        <div class="col-sm-3">
                            <select name="sub_category_product0" id="input-sub-category0-product" class="form-control">
                                <option value="0"><?php echo 'Please Select'; ?></option>
                            </select>
                          <?php if (isset($error_product_sub_category0)) { ?>
                          <div class="text-danger"><?php echo $error_product_sub_category0; ?></div>
                          <?php } ?>
                        </div>
                    </div>
                    <?php if (isset($error_product_sub_category1)) { ?>
                    <div id="input-sub-category1-div" >
                    <?php } else { ?>
                    <div id="input-sub-category1-div" style="display:none;">
                    <?php } ?>
                        <div class="col-sm-3">
                            <select name="sub_category_product1" id="input-sub-category1-product" class="form-control">
                                <option value="0"><?php echo 'Please Select'; ?></option>
                            </select>
                          <?php if (isset($error_product_sub_category1)) { ?>
                          <div class="text-danger"><?php echo $error_product_sub_category1; ?></div>
                          <?php } ?>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        
        
        <div class="addproducts-side-control mb-20">
            <h3 class="title-product-input">Masukkan Harga</h3>
            <hr>
                <fieldset id="data">
              
               <div class="form-group">
                <label class="col-sm-2 control-label" for="input-minimum"><span data-toggle="tooltip" title="Minimum">Minimum</span></label>
                <div class="col-sm-9">
                  <input type="text" name="minimum" value="<?php echo $minimum; ?>" placeholder="Minimum pembelian" id="input-minimum" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-price">Harga</label>
                <div class="col-sm-9">
                  <input type="text" name="price" value="{{$price}}" placeholder="Masukkan Harga" id="input-price" class="form-control" />
                  <?php if (isset($error_price)) { ?>
                      <div class="text-danger"><?php echo $error_price; ?></div>
                    <?php } ?>
                </div>
              </div>
        </div>
        
        <div class="addproducts-side-control mb-20"> 
             <h3 class="title-product-input">Management Produk</h3> 
            <hr>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status">Status</label>
                <div class="col-sm-9">
                  <select name="status" id="input-status" class="form-control">
                    <?php if ($status) { ?>
                    <option value="1" selected="selected">Enable</option>
                    <option value="0">Disabled</option>
                    <?php } else { ?>
                    <option value="1">Enable</option>
                    <option value="0" selected="selected">Disabled</option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <br/>
              <br/>
              <br/>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-quantity">Kuantiti</label>
                <div class="col-sm-9">
                  <input type="text" name="quantity" value="<?php echo $quantity; ?>" placeholder="Masukkan Kuantiti" id="input-quantity" class="form-control" />
                </div>
              </div>
              <br/>
              <br/>
              <br/>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-quantity">Status Stok</label>
                <div class="col-sm-9">
                  <input type="text" name="stock_status" value="{{$stock_status}}" placeholder="Masukkan stok barang Anda" id="input-stock-status" class="form-control" />
                </div>
              </div>
        </div>
        
        <div class="addproducts-side-control mb-20">
            <h3 class="title-product-input">Deskripsi Produk</h3>
            <hr>
              <div class="form-group" >
                <label class="col-sm-2 control-label" for="input-description">Deskripsi</label>
                <div class="col-sm-9">
                    <?php if (isset($product_description)) { ?>
                        <textarea name="product_description"  placeholder="Masukkan Deskripsi" id="input-description" class="form-control" style="height: 300px;"><?php echo $product_description; ?></textarea>
                    <?php } else { ?>
                        <textarea name="product_description"  placeholder="Masukkan Deskripsi" id="input-description" class="form-control" style="height: 300px;"></textarea>
                    <?php } ?>
                  
                  <?php if (isset($error_product_description)) { ?>
                      <div class="text-danger"><?php echo $error_product_description; ?></div>
                  <?php } ?>
                </div>
              </div>
        </div>
              <div class="addproducts-side-control mb-20">
                <h3 class="title-product-input">Shipping</h3> 
                <hr>  
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-weight">Berat</label> 
                    <div class="col-sm-9">
                      <input type="text" name="weight" value="<?php echo $weight; ?>" placeholder="Masukkan Berat dalam Gram" id="input-weight" class="form-control" />
                      <?php if (isset($error_weight)) { ?>
                          <div class="text-danger"><?php echo $error_weight; ?></div>
                        <?php } ?>
                    </div>
                  </div>
              </div>
              </fieldset>
        </form>
      </div>
      <div class="pull-right btn-back">
      <button type="submit" form="form-product" data-toggle="tooltip" title="Simpan" name="submit" class="btn btn-primary" value="save">Simpan<i class="fa "></i></button>
      </div>
      </div>
     </div>
     </div>
     <script type="text/javascript"><!--
     var image_row = '<?php echo $image_row; ?>';
if (image_row >= 4) {
    $('#img-loading-upload').hide();
}
var image_row_temp = '<?php echo $image_row; ?>';
if (image_row_temp >= 4) {
    $('#img-loading-upload').hide();
}
     $('#upload-thumb-image-product').on('click', function(event){
    event.preventDefault();
    
    
	$('#form-upload').remove();
	
	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;">{{ csrf_field() }}<input type="file" name="file" value="" /></form>');
	
	$('#form-upload input[name=\'file\']').trigger('click');
	
	if (typeof timer != 'undefined') {
    	clearInterval(timer);
	}

	timer = setInterval(function() {
		if ($('#form-upload input[name=\'file\']').val() != '') {
			clearInterval(timer);
			
			divgen_temp  = '<div class="col-sm-3-footer col-xs-6 text-center" id="temp-image-row' + image_row_temp + '" ><div class="rad-image-upload lazy-image"></div>';
            divgen_temp += '</div>';
            $('#test1').append(divgen_temp);
            //$("#image-row"+ image_row_temp).html('');
            image_row_temp++;
            
			$.ajax({
				url: '{{route('upload_files')}}', 
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
            var newcoll = {"_token": "{{ csrf_token() }}",'name_image': json['success'],'image_row': image_row};
                jQuery.ajax({
                    url:'{{route('update_image_product')}}',
                    type:'post',
                    data: newcoll,
                    success:function(results) {
                        divgen  = '<div class="col-sm-3-footer col-xs-6 text-center" id="image-row' + image_row + '" >';
                        
                        divgen += '</div>';
                        $('#temp-image-row'+ image_row).remove();
                        $('#test1').append(divgen);
                        $("#image-row"+ image_row).html(results);
                        image_row++;
                        var number_of_test1 = $("#test1").children().length;
                        var number_or_image_product = $("#image-product").children().length - 2;
                        var sum_two_div = number_of_test1 + number_or_image_product;
                        if ($("#test1").children().length >= 4) {
                            $('#upload-thumb-image-product').hide();
                        }
                        if(sum_two_div >= 5) {
                            $('#upload-thumb-image-product').hide();
                        }
                        event.preventDefault();
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        $('#temp-image-row'+ image_row).remove();
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
function removeimagerow(row_remove) {
    if($("#upload-thumb-image-product").css('display') == 'none') {
        $('#upload-thumb-image-product').css("display", "block");
        $('#image-row'+row_remove).remove();
    } else {
        $('#image-row'+row_remove).remove();
    }
};
     //--></script>
     </div>
     </div>
     </div>
     {!! $footer !!}
@endsection