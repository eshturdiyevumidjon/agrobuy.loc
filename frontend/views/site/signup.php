<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
    <img src="<?=$path?>" alt="Logo" class="logo-popup-top">
    <h2><span><?= Yii::t('app',"Ro'yxatdan o'tish") ?></span></h2>
    <?php $form = ActiveForm::begin([ 'options' => [ 'id' => 'register-form' ], 'enableAjaxValidation' => true, ]); ?>

        <?= $form->field($model, 'login')->textInput(['autofocus' => true, 'placeholder' => Yii::t('app',"Login") ])->label(false) ?>

        <?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::className(), [
            'mask' => '+\9\9899-999-99-99',
            'options' => [
                'placeholder' => '+998-99-999-99-99',
                'class'=>'form-control',
            ]
        ])->label(false) ?>

        <?= $form->field($model, 'password')->passwordInput(['placeholder' => Yii::t('app',"Parol o'ylab toping") ])->label(false) ?>

        <!-- <button type="submit" class="btn-template"><?php // Yii::t('app',"Kodni yuborish") ?></button> -->
        <button type="submit" class="btn-template"><?= Yii::t('app',"Ro'yxatdan o'tish") ?></button>
        <p class="text-center"><?= Yii::t('app',"yoki") ?></p>
        <p>
            <?= Yii::t('app',"Sizda akkaunt bormi?") ?> 
            <a href="#" data-touch="false" onclick="$.fancybox.close();" data-fancybox data-src="#avtorization" value="/<?=$nowLanguage?>/site/login" class="link-popup avtorization_class">
                <?= Yii::t('app',"Kirish") ?>                
            </a>
        </p>

    <?php ActiveForm::end(); ?>

<div id="avtorization" style="display: none;" class="popup-style">
    <div id="avtorizationContent"></div>
</div>

<?php 
$this->registerJs(<<<JS
$(function () {
    $('.avtorization_class').on('click', function () {
        $('#avtorization').find('#avtorizationContent').load($(this).attr('value'));
    });   
});
JS
)
?>