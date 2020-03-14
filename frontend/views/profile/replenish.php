<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = Yii::t('app',"Hisobni to'ldirish");
?>

<section class="replenish">
    <div class="container">
        <h2 class="title"><?= Yii::t('app',"Hisobni to'ldirish") ?></h2>
        <?php $form = ActiveForm::begin(); ?>
            <div class="form-top">
                <p><?= Yii::t('app',"Summani tanlang") ?></p>
                <div class="replenish-main">
                    <?php $i = 0; foreach ($pliceList as $price) { $i++; ?>
                        <div class="form-group radio-style">
                            <input type="radio" name="summ" value="<?=$price->price?>" <?=$i == 1 ? 'checked=""' : ''?>id="rad<?=$i?>">
                            <label for="rad<?=$i?>"><?=$price->price?> <?= Yii::t('app',"So'm") ?></label>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="form-top">
                <p><?= Yii::t('app',"To'lov usulini tanlang") ?></p>
                <div class="replenish-main-puy">
                    <div class="form-group">
                        <input type="radio" id="puy1" value="payme" name="puy" checked="">
                        <label for="puy1"><img src="/images/payme.png" alt=""></label>
                    </div>
                    <div class="form-group">
                        <input type="radio" id="puy2" value="click" name="puy">
                        <label for="puy2"><img src="/images/click.png" alt=""></label>
                    </div>
                    <div class="form-group">
                        <input type="radio" id="puy3" value="upay" name="puy">
                        <label for="puy3"><img src="/images/uber.png" alt=""></label>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn-template"><?= Yii::t('app',"Hisobni to'ldirish") ?></button>
                    </div>
                </div>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</section>