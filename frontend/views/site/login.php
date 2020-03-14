<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
    <img src="<?=$path?>" alt="Logo" class="logo-popup-top">
    <h2><span><?= Yii::t('app',"Avtorizatsiya") ?></span></h2>

    <?php $form = ActiveForm::begin([ 'options' => [ 'id' => 'login-form' ], 'enableAjaxValidation' => true, ]); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => Yii::t('app',"Login") ])->label(false) ?>

        <?php // $form->field($model, 'password', ['options' => ['class' => 'form-group password_hidden']])->passwordInput(['placeholder' => Yii::t('app', "Parol")])->label(false) ?>
        <!-- <span id="password_hidden_show"></span> -->

        <div class="form_group password_hidden">
            <?= $form->field($model, 'password')->label(false)->passwordInput([ 'type' => 'password', 'placeholder' => Yii::t('app', "Parol")])->label(false) ?>
            <span id="password_hidden_show"></span>
        </div>

        <div class="text-left">
            <a href="#" data-touch="false" onclick="$.fancybox.close();" data-fancybox data-src="#recovery-password" value="/<?=$nowLanguage?>/site/recovery-password" class="link-popup recovery_password_class">
                <?= Yii::t('app',"Parolni unutdingizmi?") ?>                
            </a>
        </div>

        <button type="submit" class="btn-template"><?= Yii::t('app',"Avtorizatsiyadan o'tish") ?></button>
        <p class="text-center"><?= Yii::t('app',"yoki") ?></p>
        <a href="#" data-touch="false" onclick="$.fancybox.close();" data-fancybox data-src="#registration" value="/<?=$nowLanguage?>/site/signup" class="link-popup registration_class">
            <?= Yii::t('app',"Registratsiyadan o'tish") ?>
        </a>

    <?php ActiveForm::end(); ?>

<div id="registration" style="display: none;" class="popup-style">
    <div id="registrationContent"></div>
</div>

<div id="recovery-password" style="display: none;" class="popup-style">
    <div id="recoveryContent"></div>
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
    $('span#password_hidden_show').on('click', function(){
        $(this).toggleClass('active');
        if($(this).hasClass('active')){
            $(this).prev().find('input').attr('type', 'text'); 
        }
        else{
            $(this).prev().find('input').attr('type', 'password'); 
        }
    });
});
JS
)
?>