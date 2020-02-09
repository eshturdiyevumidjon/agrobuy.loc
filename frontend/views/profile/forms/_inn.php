<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
    <?php $form = ActiveForm::begin(['id' => '_inn', 'options' => ['method' => 'post', 'class' => 'edit-item', ]]); ?>
        <div class="title-edit"><?=Yii::t('app', "Jis. yoki yur. shaxs haqida mu'lumot")?></div>
        <div class="edit-item-body">
            <div class="row">
                <div class="col-lg-5 col-sm-12 col-12">
                    <!-- <div class="form-group inpt-min">
                        <label for="">ИНН</label>
                        <input type="text" class="form-control">
                    </div> -->
                    <?= $form->field($model, 'inn')->textInput(['class' => 'form-control', 'type' => 'number'])->label(Yii::t('app', "INN")) ?>
                </div>
                <div class="col-lg-7 col-sm-12 col-12 text-right">
                    <?= Html::submitButton(Yii::t('app',"Saqlash"), ['class' => 'btn-template']) ?>
                </div>
            </div>
        </div>
    <?php ActiveForm::end(); ?>