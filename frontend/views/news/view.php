<?php

    use yii\helpers\Html;
?>

<section class="sample">
    <div class="container">
        <h2 class="title"> <?=$model['title']?> </h2>
        <div class="row align-items-center"> 
            <div class="col-lg-6">
                <p><?=$model['text']?></p>
            </div>
            <?php if($model['video'] != null && $model['video'] != '') { ?>
                <div class="col-lg-6 straw">
                    <iframe width="1519" height="586" src="<?=$model['video']?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
                    <p><?=$model['video_title']?></p>
                </div>
            <?php } ?>
        </div>
        <div class="row one-year">
            <?php if($model['sort_title'] != null && $model['sort_title'] != '') { ?>
            <div class="col-lg-6">
                <div class="select-sort">
                    <h4><?=$model['sort_title']?></h4>
                    <ul>
                        <?php foreach ($model['sort_items'] as $value) { if($value != null) { ?>
                            <li><?=$value?></li>
                        <?php } }?>
                    </ul> 
                </div>
            </div>
            <?php } ?>
            <?php if($model['landing_title'] != null && $model['landing_title'] != '') { ?>
            <div class="col-lg-6">
                <div class="select-sort sorted-two">
                    <h4><?=$model['landing_title']?></h4>
                    <p><?=$model['landing_text']?></p>
                    <p class="important-text">
                        <b><?= Yii::t('app',"Muhim") ?>!!!</b> <?=$model['important']?>
                    </p>
                </div>
            </div>
            <?php } ?>
        </div>
        <?php if(count($sort) > 0) { ?>
        <table class="table table-sample">
            <thead>
                <tr>
                    <th scope="col"><?= Yii::t('app',"Sort") ?></th>
                    <th scope="col"><?= Yii::t('app',"Nomlanishi") ?></th>
                    <th scope="col"><?= Yii::t('app',"Og'irligi") ?></th>
                    <th scope="col"><?= Yii::t('app',"Hosildorlik") ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sort as $value) { ?>
                    <tr>
                        <td><?=$value->sort_name?></td>
                        <td><?=$value->name?></td>
                        <td><?=$value->weight?></td>
                        <td><?=$value->productivity?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php } ?>
    </div>
    <?php if(count($slider) > 0) { ?>
    <div class="growing pagination-styles">
        <div class="container">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php foreach ($slider as $value) { ?>
                        <div class="swiper-slide">
                            <a href="<?=$value->link?>" data-fancybox="gallery">
                                <div class="new-slider-img">
                                    <img src="<?=$value->getImage('main_page')?>" alt="">
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="swiper-button-next">
            <svg enable-background="new 0 0 492.004 492.004" version="1.1" viewBox="0 0 492 492" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><path d="m382.68 226.8-218.95-218.94c-5.064-5.068-11.824-7.86-19.032-7.86s-13.968 2.792-19.032 7.86l-16.124 16.12c-10.492 10.504-10.492 27.576 0 38.064l183.86 183.86-184.06 184.06c-5.064 5.068-7.86 11.824-7.86 19.028 0 7.212 2.796 13.968 7.86 19.04l16.124 16.116c5.068 5.068 11.824 7.86 19.032 7.86s13.968-2.792 19.032-7.86l219.15-219.14c5.076-5.084 7.864-11.872 7.848-19.088 0.016-7.244-2.772-14.028-7.848-19.108z"/>
            </svg>
        </div>
        <div class="swiper-button-prev">
            <svg enable-background="new 0 0 492 492" version="1.1" viewBox="0 0 492 492" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><path d="m198.61 246.1 184.06-184.06c5.068-5.056 7.856-11.816 7.856-19.024 0-7.212-2.788-13.968-7.856-19.032l-16.128-16.12c-5.06-5.072-11.824-7.864-19.032-7.864s-13.964 2.792-19.028 7.864l-219.15 219.14c-5.084 5.08-7.868 11.868-7.848 19.084-0.02 7.248 2.76 14.028 7.848 19.112l218.94 218.93c5.064 5.072 11.82 7.864 19.032 7.864 7.208 0 13.964-2.792 19.032-7.864l16.124-16.12c10.492-10.492 10.492-27.572 0-38.06l-183.85-183.85z"/>
            </svg>
        </div>
    </div>
    <?php } ?>
    <?php if($model['growing_title'] != null && $model['growing_title'] != '') { ?>
    <div class="container">
        <h3><?=$model['growing_title']?></h3>
        <p><?=$model['growing_text']?></p>
        <ul class="sample-sun">
            <?php foreach ($model['growing_items'] as $value) { if($value != null) { ?>
                <li><?=$value?></li>
            <?php } } ?>
        </ul>
    </div>
    <?php } ?>
</section>