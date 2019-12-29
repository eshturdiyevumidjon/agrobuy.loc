<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;


?>

<div class="users-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-9">
            <div class="col-md-6">
                <?= $form->field($model, 'passport_serial_number')->widget([
    'name' => 'input-3',
    'mask' => '9',
    'clientOptions' => ['repeat' => 10, 'greedy' => false]
]);
?>

            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'passport_number')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'birthday')->widget(
                DatePicker::className(), [
                    'inline' => false,
                    'language' => 'ru',
                    'clientOptions' => [
                            'autoclose' => true,
                        'maxlength' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ])
            ?>
            </div>
             <div class="col-md-6">
                <?= $form->field($model, 'passport_date')->textInput(['maxlength' => true]) ?>
            </div>
             <div class="col-md-6">
                <?= $form->field($model, 'passport_issue')->textInput(['maxlength' => true]) ?>
            </div>
             <div class="col-md-6">
                <?= $form->field($model, 'passport_file')->textInput(['maxlength' => true]) ?>
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
