<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Advertisings */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="advertisings-form">

    <?php $form = ActiveForm::begin(); ?>
		<div class="row">
            <div class="col-md-12">
    			<?= $form->field($model, 'time')->textInput(['type' => 'number']) ?>
			</div>
		</div>
  
		<?php if (!Yii::$app->request->isAjax){ ?>
		  	<div class="form-group">
		        <?= Html::submitButton('Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		    </div>
		<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
