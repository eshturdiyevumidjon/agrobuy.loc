<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
<?php $form = ActiveForm::begin([ 'options' => [ 'id' => 'promotion-form' ], 'enableAjaxValidation' => true, ]); ?>
    <div class="form-top">
        <div class="replenish-main-puy">
            <?php $i = 0; foreach ($promotions as $value) { $i++; ?>
                <div class="form-group">
                    <input type="radio" id="promotion<?=$i?>" value="<?=$value->id?>" name="promotion" <?=$i < 2 ? 'checked=""' : "" ?> >
                    <label for="promotion<?=$i?>">
                        <div class="prem-vip-item">
                            <div class="prem-vip-img">
                                <img src="<?=$value->getImage('main_page')?>" alt="">
                            </div>
                            <a class="prem-vip-date"><?=$value->name?></a>
                            <p><?=$value->text?></p>
                            <span class="prem-vip-price"><?=$value->price?> <?= Yii::t('app',"So'm") ?></span>
                        </div>
                    </label>
                </div>
            <?php } ?>
        </div>
    </div>
    <button type="submit" class="btn-template"><?= Yii::t('app',"Amalga oshirish") ?></button>
<?php ActiveForm::end(); ?>