<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$text = explode(' ', Yii::t('app', "E'tirozningizni yuboring"));
$res = '';
foreach ($text as $key => $value) {
    if($key == 1) $res .= ' <span>' . $value . '</span>';
    else $res = $value;
}
?>
<h2><?= $res ?></h2>
<?php $form = ActiveForm::begin([ 'options' => [ 'id' => 'complaints-form' ], 'enableAjaxValidation' => true, ]); ?>
    <?= $form->field($model, 'text')->textArea(['rows' => 10, 'cols' => 30, 'placeholder' => Yii::t('app',"E'tirozningizni batafsil bayon eting") ])->label(false) ?>
    <button type="submit" class="btn-template"><?= Yii::t('app',"E'tirozningizni yuboring") ?></button>
<?php ActiveForm::end(); ?>