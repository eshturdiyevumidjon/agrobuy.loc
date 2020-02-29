<?php

?>
<div class="ads-container">
    <?php
        if($model->usersCatalogs != null) $catalogTitle = Yii::t('app',"Mening katalogimdan o'chirish");
        else $catalogTitle = Yii::t('app',"Mening katalogimga qo'shish");
    ?>
    <?php if($model->user_id == Yii::$app->user->identity->id) { ?>
        <div class="dropdown-person three_point">
            <button type="button" class="" data-toggle="dropdown">
                <svg enable-background="new 0 0 512 512" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="256" cy="256" r="64"></circle>
                    <circle cx="256" cy="448" r="64"></circle>
                    <circle cx="256" cy="64" r="64"></circle>
                </svg>
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="/ads/edit?id=<?=$model->id?>"><?= Yii::t('app',"E'lonni tahrirlash") ?></a>
                <a class="dropdown-item premium_ads" href="#" data-touch="false" value="/<?=$nowLanguage?>/ads/premium?id=<?=$model->id?>" data-fancybox data-src="#ad-promotion" ><?=Yii::t('app', "Targ'ib qilish")?></a>
                <a class="dropdown-item" href="/ads/status?id=<?=$model->id?>"><?= Yii::t('app',"Faollashtirish/O'chirish") ?></a>
                <a class="dropdown-item delete_ads" href="#" data-touch="false" value="/<?=$nowLanguage?>/ads/delete-form?id=<?=$model->id?>" data-fancybox data-src="#delete-ads-popup" ><?=Yii::t('app', "E'lonni o'chirish")?></a>
                <a class="dropdown-item" href="/ads/catalog?id=<?=$model->id?>"><?= $catalogTitle ?></a>
            </div>
        </div>
    <?php } ?>
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