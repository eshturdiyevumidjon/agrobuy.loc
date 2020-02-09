<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
    <?php $form = ActiveForm::begin(['id' => '_inn', 'options' => ['method' => 'post', 'class' => 'edit-item', ]]); ?>
        <div class="title-edit"><?=Yii::t('app', "Jis. yoki yur. shaxs haqida mu'lumot")?></div>
        <div class="edit-item-body">
            <div class="row">
                <div class="col-lg-6 col-sm-12 col-12">
                    <?= $form->field($model, 'inn', ['options' => ['class' => 'form-group inpt-min']])->widget(\yii\widgets\MaskedInput::className(), [
                        'mask' => '999999999',
                        'class' => 'form-control',
                    ])->label(Yii::t('app', "INN")) ?>
                </div>
                <div class="col-lg-6 col-sm-12 col-12 text-right">
                    <?= Html::submitButton(Yii::t('app',"Saqlash"), ['class' => 'btn-template']) ?>
                </div>
            </div>
        </div>
    <?php ActiveForm::end(); ?>