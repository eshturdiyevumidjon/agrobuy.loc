<?php

    use yii\helpers\Html;
?>
<section class="news">
    <div class="container">
        <h2 class="title">
            <span><?= Yii::t('app',"Xabarlar") ?></span>
        </h2>
    </div>
    <div class="container for-swiper-container">
        <div class="swiper-container swiper-news">
            <div class="swiper-wrapper">
                <?php foreach ($news as $value) { ?>
                <div class="swiper-slide">
                    <a href="/news/view?id=<?=$value['id']?>">
                        <div class="new-slider-img">
                            <img src="<?=$value['image']?>" alt="<?=$value['title']?>">
                        </div>
                        <h3><?=$value['title']?></h3>
                        <p><?=$value['text']?></p>
                        <div class="news-date">
                            <?=$value['date']?>
                        </div>
                    </a>
                </div>
                <?php } ?>
            </div>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <a href="/news" class="btn-template"><?= Yii::t('app',"Barchasini ko'rish") ?></a>
    </div>
</section>