<?php

use yii\helpers\Html;

if(!Yii::$app->user->isGuest) $avt = true; 
else $avt = false;

$text = explode(' ', Yii::t('app',"O'xshash e'lonlar"));
$res = '';
foreach ($text as $key => $value) {
	if($key == 1) $res .= ' <span>' . $value . '</span>';
	else $res = $value;
}

?>

<section class="ads">
    <div class="container">
        <h1><?=$model->title?></h1>
        <div class="row">
          	<div class="col-lg-7">
            	<?= $this->render('_image_slider', [
		  	        'nowLanguage' => $nowLanguage,
		  	        'model' => $model,
		  	        'identity' => $identity,
		  	    ]) ?>
          	</div>
          	<div class="col-lg-5">
          		<?= $this->render('_owner', [
		  	        'nowLanguage' => $nowLanguage,
		  	        'model' => $model,
		  	        'identity' => $identity,
                'path' => $path,
		  	    ]) ?>
          	</div>
          	<div class="col-lg-7 ads-about">
            	<h5><?=$model->title?></h5>
            	<p><textarea style="border: 0; resize: none; outline: none"><?=$model->text?></textarea></p>
          	</div>
        </div>
    </div>
</section>

<section class="similar-ads pagination-styles">
    <div class="container">
        <h2 class="title"><?=$res?></h2>
        <div class="swiper-container">
            <div class="swiper-wrapper">

            	<?php foreach ($likedAds as $ads) { 
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
              	<div class="swiper-slide">
                	<div class="item-product">
                  		<span class="star-item">
                    		<?= $star ?>
                  		</span>
                  		<div class="sub-prime premium">
                    		<img src="/images/crown.png" alt="">
                    		Премиум
                  		</div>
                  		<a href="/ads/view?id=<?=$ads->id?>">
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
        </div>
    </div>
    <div class="swiper-pagination d-sm-none"></div>
    <div class="swiper-button-next">
        <svg enable-background="new 0 0 492.004 492.004" version="1.1" viewBox="0 0 492 492" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><path d="m382.68 226.8-218.95-218.94c-5.064-5.068-11.824-7.86-19.032-7.86s-13.968 2.792-19.032 7.86l-16.124 16.12c-10.492 10.504-10.492 27.576 0 38.064l183.86 183.86-184.06 184.06c-5.064 5.068-7.86 11.824-7.86 19.028 0 7.212 2.796 13.968 7.86 19.04l16.124 16.116c5.068 5.068 11.824 7.86 19.032 7.86s13.968-2.792 19.032-7.86l219.15-219.14c5.076-5.084 7.864-11.872 7.848-19.088 0.016-7.244-2.772-14.028-7.848-19.108z"/></svg>
    </div>
    <div class="swiper-button-prev">
        <svg enable-background="new 0 0 492 492" version="1.1" viewBox="0 0 492 492" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><path d="m198.61 246.1 184.06-184.06c5.068-5.056 7.856-11.816 7.856-19.024 0-7.212-2.788-13.968-7.856-19.032l-16.128-16.12c-5.06-5.072-11.824-7.864-19.032-7.864s-13.964 2.792-19.028 7.864l-219.15 219.14c-5.084 5.08-7.868 11.868-7.848 19.084-0.02 7.248 2.76 14.028 7.848 19.112l218.94 218.93c5.064 5.072 11.82 7.864 19.032 7.864 7.208 0 13.964-2.792 19.032-7.864l16.124-16.12c10.492-10.492 10.492-27.572 0-38.06l-183.85-183.85z"/></svg>
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