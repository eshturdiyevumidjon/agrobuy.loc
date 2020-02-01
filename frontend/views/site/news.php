<?php

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
            <?php foreach ($news as $value) {
              ?>
              <div class="swiper-slide">
                <a href="#">
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
            <?php
            } ?>
          </div>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
      </div>
    </section>