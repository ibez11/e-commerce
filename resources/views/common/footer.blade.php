<footer class="j-footer">
<div class="container">
    <div class="row">
<div class="o-layout__item u-6of12">
    <h3 class="c-brand c-brand--logo">
        <a class="c-brand__link" href="https://www.jastek-service.com/"><img src="{{$logo}}" alt="Logo Jastek" /></a>
        </h3 >
        <h5 class="c-brand c-brand--tagline u-mrgn-left--2">Situs jual beli online mudah & terpercaya</h5>
</div>
<div class="o-layout__item u-6of12">
    <div class="c-socmed-share u-align-right">
        <h5 class="c-brand c-brand--tagline c-socmed-follow__head">Kami ada disini:</h5>
        <ul class="c-socmed-follow__list">
        <li class="c-socmed-follow__item">
        <a target="_blank" class="c-socmed-follow__icon c-socmed-follow__icon--facebook" rel="nofollow" href="https://facebook.com/jastek">Facebook</a>
        </li>
        <li class="c-socmed-follow__item">
        <a target="_blank" class="c-socmed-follow__icon c-socmed-follow__icon--twitter" rel="nofollow" href="https://twitter.com/jastek">Twitter</a>
        </li>
        <li class="c-socmed-follow__item">
        <a target="_blank" class="c-socmed-follow__icon c-socmed-follow__icon--instagram" rel="nofollow" href="https://instagram.com/jastek/">Instagram</a>
        </li>
        <li class="c-socmed-follow__item">
        <a target="_blank" class="c-socmed-follow__icon c-socmed-follow__icon--gplus" rel="nofollow" href="https://plus.google.com/+jastekdotcom">Google+</a>
        </li>
        </ul>
    </div>
</div>
</div>
</div>
<hr style="padding-top: unset;">
<div class="container">
    <div class="row">
      <?php //if ($footerleft) { ?>
      <div class="col-sm-3-footer">
       <h5>Jastek</h5>
       <ul class="list-unstyled">
            <a href="#" target="_blank" rel="noopener"><li>About Us</li></a>
            <a href="#" target="_blank" rel="noopener"><li>Promo</li></a>
            <a href="#" target="_blank" rel="noopener"><li>Karir</li></a>
            <a href="#"><li>Blog</li></a>
        </ul>
      </div>
      <div class="col-sm-3-footer"> 
       <h5>Pembeli</h5>
       <ul class="list-unstyled">
           <a href="/buyer" target="_blank" rel="noopener"><li>Belanja di Jastek</li></a>
           <a href="#" target="_blank" rel="noopener"><li>Cara Berbelanja</li></a>
           <a href="#" target="_blank" rel="noopener"><li>Pemabayaran</li></a>
           <a href="#"><li>Pengembalian Dana</li></a>
        </ul>
       </div>
      <div class="col-sm-3-footer">
       <h5>Penjual</h5>
       <ul class="list-unstyled">
           <a href="#" target="_blank" rel="noopener"><li>Berjualan di Jastek</li></a>
           <a href="#" target="_blank" rel="noopener"><li>Bagaimana berjualan</li></a>
           <a href="#"><li>Gold Member</li></a>
           <a href="#" target="_blank" rel="noopener"><li>Iklan</li></a>
           <a href="#" target="_blank" rel="noopener"><li>Menarik Dana</li></a>
        </ul>
      </div>
      <div class="col-sm-3-footer-help">
       <h5>Bantuan</h5>
       <ul class="list-unstyled">
           <a href="#" target="_blank" rel="noopener"><li>Syarat dan Kondisi</li></a>
           <a href="#" target="_blank" rel="noopener"><li>Kebijakan Pribadi</li></a>
           <a href="#" target="_blank" rel="noopener"><li>Pusat Solusi</li></a>
           <a href="#" target="_blank" rel="noopener"><li>Kontak Kami</li></a>
        </ul>
      </div>
      <div class="col-sm-3-footer-sosmed" >
       <table width="100%" border="0">
            <tr>
              <td align="center"><a href="#"><img src="{{$google_play}}" height="80" class="item" alt="Jastek" /></a></td>
            </tr>
        </table>
        <br />
         
      </div>
    <?php //} ?>
    
    

    </div>
</div>
<hr/>
<div class="container">
    <div class="row">
<table style="float:left;">
    <tr>
        <td><p>© {{$year}} Hak Cipta Terpelihara PT. JASTEK </p></td>
    </tr>
</table>
      </div>
      </div>
<script>
function backTotopFunc() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}
</script>
<script>
$(window).scroll(function() {
   $("#BtnOnscrollspy").removeClass("remover-floatpush-top");
   if($(window).scrollTop() + $(window).height() > ($(document).height() - 325) ) {
       //you are at bottom
       $("#BtnOnscrollspy").addClass("remover-floatpush-top");
   }
});
</script>
</footer>