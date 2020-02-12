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

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'text')->textArea(['rows' => 10, 'cols' => 30, 'placeholder' => Yii::t('app',"E'tirozningizni batafsil bayon eting") ])->label(false) ?>

        <button type="submit" class="btn-template"><?= Yii::t('app',"E'tirozningizni yuboring") ?></button>

    <?php ActiveForm::end(); ?>

    <!-- <h2>Отправьте <span>жалобу</span></h2>
      <form>
        <div class="form-group">
          <textarea name="" class="form-control" cols="30" rows="10" placeholder="Подробно опишите причину жалобы..."></textarea>
        </div>
        <div class="text-right w-100">
          <button type="submit" class="btn-template">Отправить жалобу</button>
        </div>
      </form> -->