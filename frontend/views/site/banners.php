<?php 

?>
<section class="main-slider swiper-container">
    <div class="swiper-wrapper">
    <?php foreach ($banners as $banner) { ?>
        <div class="swiper-slide" style="background-image: url(<?=$banner['image']?>);">
          	<div class="container">
            	<div class="main-content-slider">
            		<h1><?=$banner['title']?></h1>
            		<p><?=$banner['text']?></p>
            		<a href="<?=$banner['link']?>" class="btn" target="_blank"><?= Yii::t('app',"Batafsil") ?></a>
            	</div> 
          	</div>
        </div>
    <?php } ?>
    </div>
    <div class="swiper-pagination"></div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
</section>