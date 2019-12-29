<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="users-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-9">
            <div>
                <?= $form->field($model, 'inn')->textInput(['maxlength' => true]) ?>
            <div class="col-md-6">
                <?php if( $user->type == 1) { ?>
                    <?= $form->field($model, 'type')->dropDownList(($model->type == 4 || $model->type == 3) ? $model->getTypeEdu() : $model->getType(), ['prompt' => 'Выберите должность','disabled'=>($model->type == 4 || $model->type == 3)? true : false ]) ?>
                <?php } ?>
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
