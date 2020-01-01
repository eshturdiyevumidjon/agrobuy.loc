<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

?>

<div class="users-form">

    <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'passport_serial_number')->widget(\yii\widgets\MaskedInput::className(), [
                    'mask' => 'AA',
                ]) ?>

                </div>
            <div class="col-md-4">
                <?= $form->field($model, 'passport_number')->widget(\yii\widgets\MaskedInput::className(), [
                    'mask' => '9999999',
                ]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'passport_date')->widget(
                    DatePicker::className(), [
                        'inline' => false,
                        'language' => 'ru',
                        'clientOptions' => [
                                'autoclose' => true,
                            'maxlength' => true,
                            'format' => 'dd.mm.yyyy'
                        ]
                ])?>
            </div>
        </div>
        <div class="row">
             <div class="col-md-12">
                <?= $form->field($model, 'passport_issue')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
             <div class="col-md-6">
                <?= $form->field($model, 'passport_image')->fileInput([ /*'class'=>"image_input", 'id'=>'inputFile'*/ ]); ?>
            </div>           
        </div>
    </div>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
