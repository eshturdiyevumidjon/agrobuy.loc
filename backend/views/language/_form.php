<?php
use yii\helpers\Html;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;

?>

<div class="lang-form">
    <?php $form = ActiveForm::begin(); ?>
   
    <div class="row">
      <div class="col-md-6">
          <?= $form->field($model, 'url')->widget(\yii\widgets\MaskedInput::className(), ['mask' => 'aa','options'=>['placeholder'=>'ru']]) ?>
      </div>
      <div class="col-md-6">
         <?= $form->field($model, 'local')->textInput([]) ?>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
          <?= $form->field($model, 'name')->textInput(['maxlength' => true,'placeholder'=>'Русский']) ?>
      </div>
      <div class="col-md-6">
           <?= $form->field($model, 'status')->dropDownList($model->getStatus(), ['options'=>['0'=>['disabled'=>($model->default&& $model->id == 1)?true:false]]]); ?>
      </div>
    </div>
  <?php if (!Yii::$app->request->isAjax){ ?>
      <div class="form-group">
          <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
      </div>
  <?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
