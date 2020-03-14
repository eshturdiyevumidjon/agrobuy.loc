<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

if (!file_exists('uploads/about-company/' . $model->logo) || $model->logo == null) {
    $path = 'http://' . $_SERVER['SERVER_NAME'].'/backend/web/img/no-logo.png';
} else {
    $path = 'http://' . $_SERVER['SERVER_NAME'].'/backend/web/uploads/about-company/'.$model->logo;
}
?>

<div class="companies-form">

    <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-md-3">
               <div id="image" class="col-md-12">
                    <?=Html::img($path, [
                        'style' => 'margin-top: 50px;',
                        /*'class'=>'img-circle',*/
                    ])?>
                </div>
                <br>
                <div class="col-md-12">
                    <?= $form->field($model, 'image')->fileInput(['class'=>"image_input",'id'=>'inputFile']); ?>
                    <?= $form->field($model, 'logo')->hiddenInput(['id'=>'logo'])->label(false); ?>
                </div>
            </div>
            <div class="col-md-9">
                <div class="col-md-6">
                    <?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::className(), [
                      'mask' => '+\9\9899-999-99-99',
                     'options' => [
                          'placeholder' => '+998-99-999-99-99',
                         'class'=>'form-control',
                     ]
                    ]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-12">
                     <?= $form->field($model, 'mail')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                     <?= $form->field($model, 'premium_ads_count')->textInput(['type' => 'number','min' => 1]) ?>
                </div>
                <div class="col-md-6">
                     <?= $form->field($model, 'top_ads_count')->textInput(['type' => 'number','min' => 1]) ?>
                </div>
                <div class="col-md-12">
                     <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
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
  $("#inputFile").on('change',function(e){
  var files = e.target.files;

    $.each(files, function(i,file){
        var reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = function(e){
            var template = '<img style="object-fit: cover; width:150px; height:150px;" src="'+e.target.result+'" > ';
            $('#image').html('');
            $('#image').append(template);
          };
      });

     var data = new FormData() ; 
     var d = new Date();
     var new_name_photo = d.getTime() + Math.floor(Math.random() * 101000);  
     var ext = $( '#inputFile' )[0].files[0].type.slice(6);
     new_name_photo = new_name_photo + "." + ext;

     data.append('file', $( '#inputFile' )[0].files[0]) ; 
     data.append('name', new_name_photo) ;
     data.append('id', $( '#isNew' ).val()) ;
     $("#logo").val(new_name_photo);
     $.ajax({
     url: '/admin/about-company/change-logo',
     type: 'POST',
     data: data,
     processData: false,
     contentType: false,
     success: function(data){ 
      }
     });
    return false;
});

$(document).ready(function(){
    var fileCollection = new Array();

    $(document).on('change', '.image_input', function(e){
        var files = e.target.files;
        $.each(files, function(i, file){
            fileCollection.push(file);
            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function(e){
                var template = '<img style="width:150px; height:150px; object-fit: cover;" class="img-circle"  src="'+e.target.result+'"> ';
                $('#image').html('');
                $('#image').append(template);
            };
        });
    });
});
JS
);
?>

