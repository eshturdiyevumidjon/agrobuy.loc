<?php

use yii\helpers\Html;

?>
<section class="premium-ads">
    <div class="container">
        <div class="row has-item-product">
            <?php foreach ($usersCatalog as $cat) { 
                $ads = $cat->ads;
            ?>
            <div class="col-xl-3 col-lg-4 col-6">
                <div class="item-product">
                      <a href="#">
                        <div class="item-product-img">
                            <img src="<?=$ads->getImage('main_page')?>" alt="">
                        </div>
                        <h3><?=$ads->title?></h3>
                        <p><?= Yii::t('app',"Kategoriya") ?>: <span><?=$ads->category->title?></span></p>
                        <div class="discount">
                          <?php if($ads->old_price != null) { ?>
                            <s><?=$ads->old_price?> <?=$ads->currency->name?></s>
                            <b><?=$ads->price?> <?=$ads->currency->name?></b>
                          <?php } else {?>
                            <b><?=$ads->price?> <?=$ads->currency->name?></b>
                          <?php } ?>
                        </div>
                        <div class="address-item-product">
                            <?=$ads->city_name?>
                        </div>
                        <div class="block-id-product">
                          <span><?= $ads->getDate($ads->date_cr)?></span>
                          <span>№: <?=$ads->id?></span>
                        </div>
                      </a>
                </div>
            </div>
        <?php } ?>
        </div>
    </div>
</section>

<?php 
$this->registerJs(<<<JS
  $(function () {
    $('.set_star').on('click', function () {
        var str = $(this).attr('id');
        res = str.split("-");
        var id = parseInt(res[1]);
        var lang = $(this).attr('lang');
        $.get('/' + lang + '/site/favorite-add', {id:id, type:'1'}, function(data){ });
    });
    $('.remove_star').on('click', function () {
        var str = $(this).attr('id');
        res = str.split("-");
        var id = parseInt(res[1]);
        var lang = $(this).attr('lang');
        $.get('/' + lang + '/site/favorite-add', {id:id, type:'1'}, function(data){ });
    });
  });
JS
)
?>