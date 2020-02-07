<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
?>        

<div class="tab-my-ads">
    <div class="row">
    	<?php foreach ($myAdsdataProvider->getModels() as $ads) { 
            if($ads->usersCatalogs != null) $catalogTitle = Yii::t('app',"Mening katalogimdan o'chirish");
            else $catalogTitle = Yii::t('app',"Mening katalogimga qo'shish");
        ?>
        <div class="col-xl-3 col-lg-4 col-6">
            <div class="item-product">
                <div class="dropdown-person">
                    <button type="button" class="" data-toggle="dropdown">
                        <svg enable-background="new 0 0 512 512" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="256" cy="256" r="64"></circle>
                            <circle cx="256" cy="448" r="64"></circle>
                            <circle cx="256" cy="64" r="64"></circle>
                        </svg>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/ads/edit?id=<?=$ads->id?>"><?= Yii::t('app',"E'lonni tahrirlash") ?></a>
                        <a class="dropdown-item" href="/ads/premium?id=<?=$ads->id?>"><?= Yii::t('app',"Rag'batlantirish") ?></a>
                        <a class="dropdown-item" href="/ads/status?id=<?=$ads->id?>"><?= Yii::t('app',"Faollashtirish/O'chirish") ?></a>
                        <a class="dropdown-item delete_ads" href="#" value="/<?=$nowLanguage?>/ads/delete-form?id=<?=$ads->id?>" data-fancybox data-src="#delete-ads-popup" ><?=Yii::t('app', "E'lonni o'chirish")?></a>
                        <a class="dropdown-item" href="/ads/catalog?id=<?=$ads->id?>"><?= $catalogTitle ?></a>
                    </div>
                </div>
                <?php if($ads->status == 2) { ?>
                    <div class="sub-prime status">
                        <!-- <img src="/images/crown.png" alt=""> -->
                        <?= Yii::t('app',"Faollashtirilmagan") ?>
                    </div>
                <?php } ?>
                <a href="#">
                    <div class="item-product-img">
                      	<img src="<?=$ads->getImage('main_page')?>" alt="">
                    </div>
                    <h3><?=$ads->title?></h3>
                    <p><?= Yii::t('app',"Kategoriya") ?>: <span> <?=$ads->category->title?> </span></p>
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

    <nav aria-label="Page navigation example" class="my-nav-bottom">
        <?= LinkPager::widget([
            'pagination' => $myAdsdataProvider->pagination,
            //Css option for container
            'options' => ['class' => 'pagination'],
            //First option value
            'firstPageLabel' => '<svg enable-background="new 0 0 444.531 444.531" version="1.1" viewBox="0 0 444.53 444.53" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                      <path d="m213.13 222.41 138.75-138.76c7.05-7.043 10.567-15.657 10.567-25.841 0-10.183-3.518-18.793-10.567-25.835l-21.409-21.416c-7.039-7.04-15.654-10.561-25.834-10.561s-18.791 3.521-25.841 10.561l-186.15 185.86c-7.044 7.043-10.566 15.656-10.566 25.841s3.521 18.791 10.566 25.837l186.15 185.86c7.05 7.043 15.66 10.564 25.841 10.564s18.795-3.521 25.834-10.564l21.409-21.412c7.05-7.039 10.567-15.604 10.567-25.697 0-10.085-3.518-18.746-10.567-25.978l-138.75-138.47z"></path>
                    </svg>',
            //Last option value
            'lastPageLabel' => '<svg enable-background="new 0 0 46.02 46.02" version="1.1" viewBox="0 0 46.02 46.02" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                        <path d="m14.757 46.02c-1.412 0-2.825-0.521-3.929-1.569-2.282-2.17-2.373-5.78-0.204-8.063l12.758-13.418-12.745-13.325c-2.177-2.275-2.097-5.885 0.179-8.063 2.277-2.178 5.886-2.097 8.063 0.179l16.505 17.253c2.104 2.2 2.108 5.665 0.013 7.872l-16.504 17.361c-1.123 1.177-2.626 1.773-4.136 1.773z"></path>
                    </svg>',
            //Previous option value
            'prevPageLabel' => 'prev',
            //Next option value
            'nextPageLabel' => 'next',
            //Current Active option value
            'activePageCssClass' => 'active',
            //Max count of allowed options
            'maxButtonCount' => 15,
            // Css for each options. Links
            'linkOptions' => ['class' => 'page-link'],
            'disabledPageCssClass' => 'disabled_last_next_button',
            // Customzing CSS class for navigating link
            'prevPageCssClass' => 'disabled_a',
            'nextPageCssClass' => 'disabled_a',
            'firstPageCssClass' => 'p-first',
            'lastPageCssClass' => 'p-last',
        ]);
        ?>
    </nav>
</div>