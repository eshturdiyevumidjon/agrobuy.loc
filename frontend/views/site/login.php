<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
    <img src="<?=$path?>" alt="Logo" class="logo-popup-top">
    <h2><span><?= Yii::t('app',"Avtorizatsiya") ?></span></h2>

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => Yii::t('app',"Login") ])->label(false) ?>

        <?= $form->field($model, 'password')->passwordInput(['placeholder' => Yii::t('app', "Parol")])->label(false) ?>

        <div class="text-left">
            <a href="#" class="link-popup"><?= Yii::t('app',"Parolni unutdingizmi?") ?></a>
        </div>

        <button type="submit" class="btn-template"><?= Yii::t('app',"Avtorizatsiyadan o'tish") ?></button>
        <p class="text-center"><?= Yii::t('app',"yoki") ?></p>
        <a data-fancybox data-src="#registration" value="/<?=$nowLanguage?>/site/signup" class="link-popup registration_class">
          <?= Yii::t('app',"Registratsiyadan o'tish") ?> </a>

    <?php ActiveForm::end(); ?>

<!-- <img src="/images/logo.png" alt="" class="logo-popup-top">
      <h2><span>Авторизация</span></h2>
      <form>
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Логин">
        </div>
        <div class="form-group">
          <input type="password" class="form-control" placeholder="Пароль">
        </div>
        <div class="text-left">
          <a href="#" class="link-popup">Забыли пароль?</a>
        </div>
        <button type="submit" class="btn-template">Авторизоваться</button>
        <p class="text-center">или</p>
        <a href="#" class="link-popup">Зарегистрироваться</a>
      </form>
 -->