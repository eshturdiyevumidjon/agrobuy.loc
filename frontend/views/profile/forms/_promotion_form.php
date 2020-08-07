<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
<?php if($status == 2) echo "<p class='error_promotion'>" . Yii::t('app', "Pullik xizmat vaqtinchalik mavjud emas. Administratorga murojaat qiling") . '<br>' . $session->getTerms(5) . '<br>' . $session->getTerms(6) . "</p>";
else { ?>
<?php $form = ActiveForm::begin([ 'options' => [ 'id' => 'ads-form' ], 'enableAjaxValidation' => true, ]); ?>
    <h2><?=$promotion->name?></h2>
    <div class="dropdown">
        <div class="ad-promo-button">
            <?php if(count($usersAds) > 0) { ?>
            <input type="hidden" name="ads" id="ads" value="<?=$usersAds[0]->id?>">
                <div class="ad-1">
                    <img src="<?=$usersAds[0]->getImage('main_page')?>" id="now_ads_img" alt="">
                </div>
                <div class="ad-2" id="now_ads_title">
                    <?=$usersAds[0]->title?>
                </div>
                <div class="ad-2" id="now_ads_id">
                    <?=$usersAds[0]->id?>
                </div>
            <?php } ?>
            <span id="dropdownMenuButton">
                <img src="/images/right-arrow-green.png" alt="">
            </span>
        </div>
        <div class="drops">
            <div class="title-drops">
                <div class="ad-promo-button">
                    <div>
                        №
                    </div>
                    <div class="ad-2 min-bord" style="font-weight: 500; text-align: center;">
                        <?=Yii::t('app', "Foto")?>
                    </div>
                    <div class="ad-2" style="font-weight: 500; text-align: center;">
                        <?=Yii::t('app', "E'lon sarlavhasi")?>
                    </div>
                    <div class="ad-2" style="font-weight: 500; text-align: center;">
                        <?=Yii::t('app', "E'lon nomeri")?>
                    </div>
                </div>
            </div>
            <?php $i = 0; foreach ($usersAds as $ads) { $i++;?>
            <a href="#" class="ads_list" data-id="<?=$ads->id?>" data-title="<?=$ads->title?>" data-path="<?=$ads->getImage('main_page')?>" >
                <div class="ad-promo-button">
                    <div>
                        <?=$i?>
                    </div>
                    <div class="ad-1">
                        <img src="<?=$ads->getImage('main_page')?>" alt="">
                    </div>
                    <div class="ad-2">
                        <?=$ads->title?>
                    </div>
                    <div class="ad-2">
                        <?=$ads->id?>
                    </div>
                </div>
            </a>
            <?php } ?>
        </div>
    </div>

    <button type="submit" class="btn-template"><?= Yii::t('app',"Amalga oshirish") ?></button>
<?php ActiveForm::end(); ?>

<?php } ?>

      <script type="text/javascript">

        $('.ads_list').on('click', function () {
            $("#ads").attr("value", $(this).attr('data-id'));
            $("#now_ads_img").attr("src", $(this).attr('data-path'));
            $("#now_ads_title").html($(this).attr('data-title'));
            $("#now_ads_id").html($(this).attr('data-id'));
            $("#dropdownMenuButton").toggleClass('');
        });

        $('span#dropdownMenuButton').on('click', function(){
            $(this).toggleClass('actived');
            $('.drops').slideToggle(100);
        });

        $('.drops>a').on('click', function(){
            $('span#dropdownMenuButton').removeClass('actived');
            $('.drops').slideUp(100);
        });

      </script>