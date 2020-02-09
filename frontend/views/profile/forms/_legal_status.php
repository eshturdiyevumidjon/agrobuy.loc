<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
    <?php $form = ActiveForm::begin(['id' => '_legal_status', 'options' => ['method' => 'post', 'class' => 'edit-item', ]]); ?>
        <div class="title-edit"><?=Yii::t('app', "Huquqiy maqomi")?></div>
        <div class="edit-item-body">
            <div class="row">
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="form-group radio-style">
                        <input type="radio" name="Users[legal_status]" <?=$model->legal_status == 1 ? 'checked' : ''?> value="1" id="radi1">
                        <label for="radi1"><?=Yii::t('app', "Jis. shaxs")?></label>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="form-group radio-style">
                        <input type="radio" name="Users[legal_status]" <?=$model->legal_status == 2 ? 'checked' : ''?> value="2" id="radi2">
                        <label for="radi2"><?=Yii::t('app', "Yakka tadbirkor yoki yur. shaxs")?></label>
                    </div>
                </div>
                <div class="col-lg-5 col-sm-12 col-12 text-right">
                    <?= Html::submitButton(Yii::t('app',"Saqlash"), ['class' => 'btn-template']) ?>
                </div>
            </div>
        </div>
    <?php ActiveForm::end(); ?>