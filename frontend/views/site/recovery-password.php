<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
    <img src="<?=$path?>" alt="Logo" class="logo-popup-top">
    <h2><span><?= Yii::t('app',"Parolni tiklash") ?></span></h2>
    <?php $form = ActiveForm::begin([ 'options' => [ 'id' => 'register-form' ], 'enableAjaxValidation' => true, ]); ?>

        <?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::className(), [
            'mask' => '+\9\9899-999-99-99',
            'options' => [
                'placeholder' => '+998-99-999-99-99',
                'class'=>'form-control',
            ]
        ])->label(false) ?>

        <button type="submit" class="btn-template"><?= Yii::t('app',"Parolni tiklash") ?></button>

    <?php ActiveForm::end(); ?>

    <div id="registration" style="display: none;" class="popup-style">
        <div id="registrationContent"></div>
    </div>

<?php 
$this->registerJs(<<<JS
$(function () {
    $('.registration_class').on('click', function () {
        $('#registration').find('#registrationContent').load($(this).attr('value'));
    });
    $('.recovery_password_class').on('click', function () {
        $('#recovery-password').find('#recoveryContent').load($(this).attr('value'));
    });
});
JS
)
?>