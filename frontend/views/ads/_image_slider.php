<?php

?>
<div class="ads-container">
    <div class="swiper-container gallery-top">
        <div class="swiper-wrapper">
            <?php foreach ($model->getImagesPath() as $path) { ?>
                <div class="swiper-slide" style="background-image:url(<?=$path?>)"></div>
            <?php } ?>
        </div>
    </div>
    <div class="swiper-container gallery-thumbs">
        <div class="swiper-wrapper">
            <?php foreach ($model->getImagesPath() as $path) { ?>
                <div class="swiper-slide" style="background-image:url(<?=$path?>)"></div>
            <?php } ?>
        </div>
    </div>
    <div class="ads-container-bottom">
        <div class="address-item-product">
            <?=$model->getAddress()?>
        </div>
        <div class="block-id-product">
            <span><?= $model->getDate($model->date_cr)?></span>
            <span>№ : <?=$model->id?></span>
   		</div>
  	</div>
</div>