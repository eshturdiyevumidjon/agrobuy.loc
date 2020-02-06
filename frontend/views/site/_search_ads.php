<?php

use yii\helpers\Html;

$text = explode(' ', Yii::t('app',"Pullik e'lonlar"));
$res = '';
foreach ($text as $key => $value) {
  	if($key === 0) $res = '<span>' . $value . '</span>';
  	else $res .= ' ' . $value;
}

if(!Yii::$app->user->isGuest) $avt = true; 
else $avt = false;

?>
<!--     <img src="<?=$path?>" alt="Logo" class="logo-popup-top">
    <h2><span>Регистрация</span></h2> -->

<div class="main-category-items">
	<?php foreach ($dataProvider->getModels() as $ads) { 
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
	    <div class="category-item-product item-product">
	        <span class="star-item">
	            <?= $star ?>
	        </span>
	        <a href="#">
	            <div class="item-product-img">
	                <img src="<?=$ads->getImage('main_page')?>" alt="">
	            </div>
	            <div class="category-item-product-left">
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
	            </div>
	            <div class="category-item-product-right">
	                <div class="cat-reviews">
	                    <b><?=Yii::t('app',"Reyting")?>:</b><span><?=$ads->user->getReyting()?></span>
	                </div>
	                <div class="cat-reviews">
	                    <b><?=Yii::t('app',"Ishonch")?>:</b><span><?=$ads->user->getStarCount()?>/5</span>
	                </div>
	                <p><?=$ads->text?></p>
	            </div>
	        </a>
	    </div>
	<?php } ?>
</div>
            <nav aria-label="Page navigation example" class="my-nav-bottom">
              <ul class="pagination">
                <li class="page-item">
                  <a class="page-link disabled" href="#" aria-label="Next">                    
                    <svg enable-background="new 0 0 444.531 444.531" version="1.1" viewBox="0 0 444.53 444.53" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                      <path d="m213.13 222.41 138.75-138.76c7.05-7.043 10.567-15.657 10.567-25.841 0-10.183-3.518-18.793-10.567-25.835l-21.409-21.416c-7.039-7.04-15.654-10.561-25.834-10.561s-18.791 3.521-25.841 10.561l-186.15 185.86c-7.044 7.043-10.566 15.656-10.566 25.841s3.521 18.791 10.566 25.837l186.15 185.86c7.05 7.043 15.66 10.564 25.841 10.564s18.795-3.521 25.834-10.564l21.409-21.412c7.05-7.039 10.567-15.604 10.567-25.697 0-10.085-3.518-18.746-10.567-25.978l-138.75-138.47z"></path>
                    </svg>
                  </a>
                </li>
                <li class="page-item"><a class="page-link active" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                  <a class="page-link" href="#" aria-label="Previous">
                    <!--?xml version="1.0" encoding="UTF-8"?-->
                    
                    <svg enable-background="new 0 0 46.02 46.02" version="1.1" viewBox="0 0 46.02 46.02" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                        <path d="m14.757 46.02c-1.412 0-2.825-0.521-3.929-1.569-2.282-2.17-2.373-5.78-0.204-8.063l12.758-13.418-12.745-13.325c-2.177-2.275-2.097-5.885 0.179-8.063 2.277-2.178 5.886-2.097 8.063 0.179l16.505 17.253c2.104 2.2 2.108 5.665 0.013 7.872l-16.504 17.361c-1.123 1.177-2.626 1.773-4.136 1.773z"></path>
                    </svg>
                  </a>
                </li>
              </ul>
            </nav>
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