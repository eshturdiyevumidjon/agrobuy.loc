<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model backend\models\Banners */
/* @var $form yii\widgets\ActiveForm */
$i=0;
$langs=backend\models\Lang::getLanguages();

?>

<div class="categories-form">

    <?php $form = ActiveForm::begin([ 'options' => ['method' => 'post', 'enctype' => 'multipart/form-data']]); ?>
   
    <div class="row">
        <div class="col-md-12">
              <ul class="nav nav-pills" style="margin-top:2px;">
                  <?php foreach($langs as $lang):?>
                  <li class="<?=($i==0)?'active':''?>">
                      <a data-toggle="tab" href="#<?=$lang->url?>"><?=(isset(explode('-',$lang->name)[1])?explode('-',$lang->name)[1]:$lang->name)?></a>
                </li>
                  <?php $i++; endforeach;?>
              </ul>

              <div class="tab-content">
                <?php $i=0; foreach($langs as $lang):?>
                 <div id="<?=$lang->url?>" class="tab-pane fade <?=($i==0)?'in active':''?>">
                    <p>
                        <?php if($lang->url=='kr'): ?>
                             <div class="row">
                         <?= $form->field($model, 'name')->textInput()->label(Yii::t('app','Title',null/*,$lang->url*/)) ?>
                       
                        </div>
                        <?php else: ?>
                            <div class="row">
                         <?= $form->field($model, 'translation_name['.$lang->url.']')->textInput(['value'=>$titles[$lang->url]])->label(Yii::t('app','Title',null,$lang->url)) ?>
                        </div>
                        <?php endif;?>    
                    </p>
                 </div>
                <?php $i++; endforeach;?>
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
