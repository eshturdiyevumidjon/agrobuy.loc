<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<section class="personal-area">
    <div class="container">
    <h2>Востановление <span>пароля</span></h2> <br>
    <p><?= Yii::t('app',"Telefon raqamingizga kodli xabar yuborildi") ?></p> <br>
    <?php $form = ActiveForm::begin([ 'options' => [ 'id' => 'password-form' ], /*'enableAjaxValidation' => true,*/ ]); ?>

        <?= $form->field($model, 'code')->textInput(['autofocus' => true, 'placeholder' => Yii::t('app',"Kodni kiriting") ])->label(false) ?>

        <?= $form->field($model, 'password')->textInput(['autofocus' => true, 'placeholder' => Yii::t('app',"Yangi parol") ])->label(false) ?>

        <?= $form->field($model, 'new_password')->textInput(['autofocus' => true, 'placeholder' => Yii::t('app',"Takroriy parol") ])->label(false) ?>

        <button type="submit" class="btn-template"><?= Yii::t('app',"Parolni tiklash") ?></button>
    <?php ActiveForm::end(); ?>
  </div>
</section>