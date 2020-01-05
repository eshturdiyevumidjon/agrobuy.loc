<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Ads */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ads-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-5">
            <?= $form->field($model, 'user_id')->dropDownList($model->getUsersList(),[]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>        
        <div class="col-md-3">
            <?= $form->field($model, 'type')->dropDownList($model->getType(),[]) ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'category_id')->dropDownList($model->getCategoryList(),[]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'subcategory_id')->dropDownList($model->getSubcategoryList(),[]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'price')->textInput(['type' => 'number']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <?= $form->field($model, 'city_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'unit_price')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'text')->textarea(['rows' => 2]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5">
            <div class="col-md-12">
                <div id="image">
                    <?=$model->getImage()?>
                </div>
            </div>
            <div class="col-md-12">
                <?= $form->field($model, 'imageFiles')->fileInput(['class'=>"image_input"]); ?>
            </div>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'treaty')->checkBox() ?>
        </div>
    </div>


	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
<?php 
$this->registerJs(<<<JS
    
$(document).ready(function(){
    var fileCollection = new Array();

    $(document).on('change', '.image_input', function(e){
        var files = e.target.files;
        $.each(files, function(i, file){
            fileCollection.push(file);
            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function(e){
                var template = '<img style="width:100%; max-height:300px;" src="'+e.target.result+'"> ';
                $('#image').html('');
                $('#image').append(template);
            };
        });
    });
});
JS
);
?>