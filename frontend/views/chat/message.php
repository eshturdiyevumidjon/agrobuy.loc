<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$text = explode(' ', Yii::t('app', "Xabar yozish..."));
$res = '';
foreach ($text as $key => $value) {
    if($key == 1) $res .= ' <span>' . $value . '</span>';
    else $res = $value;
}

?>
<h2><?= $res ?></h2>
<?php $form = ActiveForm::begin([ 'options' => [ 'id' => 'chats-form' ], 'enableAjaxValidation' => true, ]); ?>
    <?= $form->field($model, 'message')->textArea(['rows' => 5, 'cols' => 20, 'placeholder' => Yii::t('app',"Xabar matni") ])->label(false) ?>
    <button type="submit" class="btn-template"><?= Yii::t('app',"Saqlash") ?></button>
<?php ActiveForm::end(); ?>