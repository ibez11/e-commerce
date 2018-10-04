<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="ltr" lang="id" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="ltr" lang="id" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="ltr" lang="id">
<!--<![endif]-->

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Error 404</title>
	<base href="Marketplace" />


	<link rel="stylesheet" href="/css/stylesheet/error.css" rel="stylesheet" />
	<noscript>
	</noscript>
</head>

<body>
	<script type="text/javascript">
		var dev_width = $(window).width();
		// alert(dev_width);
		//if(dev_width>=768){

		$(window).scroll(function () {

			// if ( ($(this).scrollTop() > 30) && ($(window).width() >= 768) ){  
			if (($(this).scrollTop() > 30) && (dev_width >= 768)) {
				//$("#topbar").slideUp("slow");
				$('.has-verticalmenu').addClass("navbar-fixed-top");
			} else {
				//$("#topbar").slideDown("slow");
				$('.has-verticalmenu').removeClass("navbar-fixed-top");
			}
		});
	</script>
	<div class="error">
		<div id="outline">
			<div id="errorboxoutline">
				<div id="errorboxheader">
					<div class="error-value">404 </div>
					<div class="error-message">Artikel tidak ditemukan</div>

				</div>
				<div class="error-img">
				</div>

				<div id="errorboxbody">
					<p>Sebuah kesalahan telah terjadi saat memproses permintaan Anda.</p>
					<p>
						<strong>Silahkan coba salah satu halaman berikut:</strong>
						<a class="btn btn-primary" href="/index.php" title="Menuju ke halaman utama">Halaman Utama</a>
					</p>



				</div>
			</div>
		</div>
	</div>
</body>

</html>