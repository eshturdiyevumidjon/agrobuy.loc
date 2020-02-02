<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
    <img src="<?=$path?>" alt="Logo" class="logo-popup-top">
    <h2><span>Регистрация</span></h2>
    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => Yii::t('app',"Login") ])->label(false) ?>

        <?= $form->field($model, 'email')->textInput(['type' => 'tel', 'placeholder' => '+ 998 __ ___ __ __' ])->label(false) ?>

        <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Придумайте пароль' ])->label(false) ?>

        <button type="submit" class="btn-template">Отправить код</button>
        <p class="text-center">или</p>
        <p>Уже есть аккаунт? <a href="#" class="link-popup">Войти</a></p>

    <?php ActiveForm::end(); ?>
