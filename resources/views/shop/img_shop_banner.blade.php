<img class="img-responsive image-page-kios" align="center" src="{{$banner_shop}}" title="Shop Banner" alt="Shop Banner">
<div class="user-change-shopbanner" id="upload-banner">
    <a class="btn btn--gray btn--small" href="javascript:void(0)">+ Ganti gambar</a>
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