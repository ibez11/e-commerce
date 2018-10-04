<div class="col-sm-12">
    <div class="row">
            <div class="slider-cads-bush"><div class="lazy-loader-slider">
                
                <div id="slideshow<?php echo $module; ?>" class="owl-carousel" style="opacity: 1;">
                  <?php foreach ($banners as $banner) { ?> 
                  <div class="item">
                    <?php if ($banner['link']) { ?>
                    <a href="<?php echo $banner['link']; ?>" title="<?php echo $banner['title']; ?>" target="_blank" rel="noopener">
                        <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive"/>
                        <div class="cads-top-right">
                            <a href="https://cads.niagamonster.com" target="_blank" rel="noopener">
                            </a>
                        </div>
                    </a>
                    <?php } else { ?>
                    <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" />
                    <?php } ?>
                  </div>
                  <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript"><!--
$('#slideshow<?php echo $module; ?>').owlCarousel({
	items: 6,
	autoPlay: 10000,
	singleItem: true,
	navigation: true,
	navigationText: ['<i class="fa fa-angle-left fa-3x"></i>', '<i class="fa fa-angle-right fa-3x"></i>'],
	pagination: false
});
--></script>
