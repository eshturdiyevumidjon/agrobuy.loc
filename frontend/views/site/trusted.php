<?php

use yii\helpers\Html;

$text = explode(' ', Yii::t('app', "Ularga ishonishadi"));
$res = '';
foreach ($text as $key => $value) {
    if(($key + 1) === count($text)) $res .= '<span>' . $value . '</span>';
    else $res .= $value . ' ';
}

if(!Yii::$app->user->isGuest) $avt = true; 
else $avt = false;

?>
    <h2 class="title"> <?= $res ?> </h2>
    <div class="row has-item-product">
    <?php foreach ($trustedAds as $ads) { 

        if($avt) {
            $fav = $ads->getStar($favorites);
            if($fav) {
                $star = '<img src="/images/star-full.png" alt="" id="remove-'.$ads->id.'" class="remove_star" lang="'.$nowLanguage.'">
                    <img src="/images/star-free.png" alt="" id="set-'.$ads->id.'" class="set_star" lang="'.$nowLanguage.'">';
            }
            else {
                $star = '<img src="/images/star-free.png" alt="" id="set-'.$ads->id.'" class="set_star" lang="'.$nowLanguage.'">
                    <img src="/images/star-full.png" alt="" id="remove-'.$ads->id.'" class="remove_star" lang="'.$nowLanguage.'">';
            }
        }
        else {
            $star = '<a data-fancybox data-src="#avtorization" value="/' . $nowLanguage . '/site/login" class="avtorization_class"><img src="/images/star-free.png" alt=""><img src="/images/star-free.png" alt=""></a>';
        }
    ?>
        <div class="col-xl-3 col-lg-4 col-6">
            <div class="item-product">
                <span class="star-item">
                    <?= $star ?>
                </span>
                <div class="sub-prime trust">
                    <?=Yii::t('app',"Ishonishadi")?>
                </div>
                <a href="/ads/view?id=<?=$ads->id?>">
                    <div class="item-product-img">
                        <img src="<?=$ads->getImage('main_page')?>" alt="">
                    </div>
                    <h3><?=$ads->title?></h3>
                    <p> <?= Yii::t('app',"Kategoriya") ?> : <span> <?=$ads->category->title?> </span> </p>
                    <div class="discount">
                        <?php if($ads->old_price != null) { ?>
                            <s><?=$ads->old_price?> <?=$ads->currency->name?></s>
                            <b><?=$ads->price?> <?=$ads->currency->name?></b>
                        <?php } else {?>
                            <b><?=$ads->price?> <?=$ads->currency->name?></b>
                        <?php } ?>
                    </div>
                    <div class="address-item-product">
                        <?=$ads->getAddress()?>
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