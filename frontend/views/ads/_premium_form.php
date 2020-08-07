<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
<?php if(count($promotions) > $status) { ?>
<?php $form = ActiveForm::begin([ 'options' => [ 'id' => 'promotion-form' ], 'enableAjaxValidation' => true, ]); ?>
    <div class="premium_form">
            <?php $i = 0; foreach ($promotions as $value) { $i++; ?>
                <div class="form-group">
                    <input type="radio" id="promotion<?=$i?>" value="<?=$value['id']?>" <?= $value['status'] != 1 ? 'disabled=""' : "" ?>  name="promotion" >
                    <label for="promotion<?=$i?>">
                        <div class="prem-vip-item">
                            <div class="prem-vip-img">
                                <img src="<?=$value['getImage']?>" alt="">
                            </div>
                            <div class="prem-vip-date"><?=$value['name']?></div>
                            <?php 
                                if($value['status'] == 1) echo "<p>" . $value['text'] . "</p>"; 
                                else echo "<p style='color:red;font-weight:bold;'>" . $value['text'] . "</p>"; 
                            ?>
                            <span class="prem-vip-price"><?=$value['price']?> <?= Yii::t('app',"So'm") ?></span>
                        </div>
                    </label>
                </div>
            <?php } ?>
    </div>
    <button type="submit" class="btn-template"><?= Yii::t('app',"Amalga oshirish") ?></button>
<?php ActiveForm::end(); ?>
<?php } else {?>
    <div class="premium_form">
        <span class="ads_text_error"><?= Yii::t('app',"Siz bu pullik xizmatni sotib olgansiz. Muddat tugashini kuting") ?></span>
        <span class="vip_text">VIP до <?= date('d.m.Y', strtotime($model->premium_date) )?> </span>
        <span class="top_text">Топ до <?= date('d.m.Y', strtotime($model->top_date) )?></span>
    </div>
<?php } ?>