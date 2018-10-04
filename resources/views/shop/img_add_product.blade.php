<button type="button" onclick="return removeimagerow('{{$image_row}}');" data-toggle="tooltip" class="user-add-img-product" >
<i class="i_image_product_form" aria-label="Hapus" alt="">Hapus</i>
</button>
<img src="{{$product_thumb}}" class="new-img-thumbnail-1" alt="" title="" data-placeholder="{{$product_thumb}}" />
<input type="hidden" name="product_image[{{$image_row}}][image]" value="{{$shop_product}}" id="input-image{{$shop_product}}" />
<input type="hidden" name="product_image[{{$image_row}}][sort_order]" value="" placeholder="1" class="form-control" />
<script type="text/javascript"><!--
$('input.chk').on('change', function() { 
    $('input.chk').not(this).prop('checked', false);  
});
//--></script>