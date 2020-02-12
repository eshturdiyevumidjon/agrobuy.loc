<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="users-form">

    <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'check_phone')->checkbox(['maxlength' => true]) ?>
            </div>
              <div class="col-md-6">
                <?= $form->field($model, 'check_mail')->checkbox(['maxlength' => true]) ?>
            </div>
              <div class="col-md-6">
                <?= $form->field($model, 'check_passport')->checkbox(['maxlength' => true]) ?>
            </div>
              <div class="col-md-6">
                <?= $form->field($model, 'check_car')->checkbox(['maxlength' => true]) ?>
            </div>
        </div>
  
    <?php if (!Yii::$app->request->isAjax){ ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>