<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Promotions */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="promotions-form">

    <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            </div>
            
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'days')->textInput(['type'=>'number']) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'price')->textInput(['type'=>'number']) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'premium')->checkBox() ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'top')->checkBox() ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'text')->textarea(['rows' => 3]) ?>
            </div>
        </div>


	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
