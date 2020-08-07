<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Users;
$images =  $post['uploaded_passport_files'];
$dir = Users::DIR_NAME_FOR_UPLOADING_PASSPORT_FILES;
$uploadDir = Users::TEMP_DIR_NAME;
?>
    <?php $form = ActiveForm::begin(['id' => '_passport', 'options' => ['method' => 'post', 'class' => 'edit-item', 'autocomplete'=>"off"]]); ?>
            <div class="title-edit"><?=Yii::t('app', "Pasport ma'lumotlari")?></div>
            <div class="edit-item-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-6">
                                <?= $form->field($model, 'passport_serial_number', ['options' => ['class' => 'form-group inpt-min']])->widget(\yii\widgets\MaskedInput::className(), [
                                    'mask' => 'AA',
                                    'class' => 'form-control',
                                ])->label(Yii::t('app', "Pasport seriyasi")) ?>
                            </div>
                            <div class="col-lg-6">
                                <?= $form->field($model, 'passport_number')->widget(\yii\widgets\MaskedInput::className(), [
                                    'mask' => '9999999',
                                    'class' => 'form-control',
                                ])->label(Yii::t('app', "Pasport nomeri")) ?>
                            </div>
                        </div>
                        <?= $form->field($model, 'passport_date', ['options' => ['class' => 'form-group inpt-min']])->textInput(['class' => 'form-control datetimepicker ', 'id'=>"dp1580923370520"])->label(Yii::t('app', "Berilgan vaqti")) ?>
                        <?= $form->field($model, 'passport_issue', ['options' => ['class' => 'form-group inpt-min']])->textInput(['class' => 'form-control',])->label(Yii::t('app', "Kim tomonidan berilgan")) ?>             
                    </div>
                </div>
                
                <div class="imagesList" id="ImageListPassport">
                  <?php if ($model->passport_file): ?>
                    <?php foreach (explode(",",$model->passport_file) as $value): ?>
                        <div class="image_preview_class">
                            <a class="img-ads" title="<?=$value?>">x</a>
                            <?php $ext = $model->isImage($value); if ($ext != ""): ?>
                                <span class="preview">
                                    <img src="/admin/uploads/exts/<?=$ext?>.png" data-new="0" data-name="<?=$value?>">
                                </span> 
                            <?php else: ?>
                                <span class="preview">
                                    <img src="<?=$dir.$value?>" data-new="0" data-name="<?=$value?>">
                                </span> 
                            <?php endif ?>
                        </div>
                    <?php endforeach ?>
                  <?php endif ?>
                  <?php if ($images): ?>
                    <?php foreach (explode(",",$images) as $key => $value): ?>
                        <div class="image_preview_class">
                            <a class="img-ads" title="<?=$value?>">x</a>
                            <?php $ext = $model->isImage($value); if ($ext): ?>
                                <span class="preview">
                                    <img src="/admin/uploads/<?=$ext?>.png" data-new="0" data-name="<?=$value?>">
                                </span> 
                            <?php else: ?>
                                <span class="preview">
                                    <img src="<?=$dir.$value?>" data-new="0" data-name="<?=$value?>">
                                </span> 
                            <?php endif ?>
                        </div>
                    <?php endforeach ?>
                  <?php endif ?>
                </div>
                <div class="row">
                    <div class="col-xl-9">
                        <input type="file" name="imagesProba" accept="image/*,.doc, .docx,.txt,.pdf" multiple="true" style="display: none" id="inputFilePassword">
                        <input type="hidden" name="uploaded_passport_files" id="uploaded_passport_files" value="<?=$images?>">
                        <input type="hidden" name="old_uploaded_passport_files" id="old_uploaded_passport_files" value="<?=$model->passport_file?>">
                        <div class="attach">
                          <?=Yii::t('app', "Foto biriktirish")?>&nbsp;&nbsp;&nbsp;
                          <label for="inputFilePassword">
                            <span class="multiple-photos">
                                    <div class="fileinput-button dz-clickable"></div>
                                </span>
                          </label>
                        </div> 
                    </div>
                    <div class="col-xl-3 col-lg-6 col-sm-12 col-12 text-right">
                        <?= Html::submitButton(Yii::t('app',"Saqlash"), ['class' => 'btn-template']) ?>
                    </div>
                </div>
            </div>
        <?php ActiveForm::end(); ?>

<?php 
$id = $model->id;
$this->registerJs(<<<JS
  var array = ["gif", "jpeg", "jpg", "png"];
  $("#inputFilePassword").on('change',function(e){
      namess = [];
      var files = e.target.files;
      var data = new FormData(); 
      $.each(files, function(i,file){
          var d = new Date();
          var new_name = d.getFullYear() + '-' + d.getMonth() + '-' + d.getDate() + '_' +d.getHours() + '-' + d.getMinutes() + '-' + d.getSeconds();  
          var filename = $( '#inputFilePassword' )[0].files[i].name;
          name = filename.split('.').shift();
          var ext = filename.split('.').pop();
          new_name = name + '(' + new_name + ")." + ext;
          data.append('file[]', $( '#inputFilePassword' )[0].files[i]) ; 
          data.append('names[]', new_name) ; 
          namess.push(new_name);
          template = '<div class="image_preview_class" data-id="'+ new_name +'"><a class="img-ads" title="'+new_name+'">x</a><span class="preview"><img src="/admin/uploads/zz.gif" data-id="'+ ext +'" data-name="'+ new_name +'" data-new="1"></span></div>';
          $("#ImageListPassport").append(template);
      });
      $.ajax({
        url: '/$nowLanguage/profile/save-img',
        type: 'POST',
        data: data,
        processData: false,
        contentType: false,
        success: function(success){
          new_names = "";
          for(var i=0; i < namess.length;i++){
            if(i != namess.length-1){
              new_names += namess[i] + ",";
            }else{
              new_names += namess[i];
            }
            var img = $('[data-id="' + namess[i] + '"]').children("span").children("img");
            if(array.indexOf(img.attr('data-id')) != -1){
                img.attr('src','$uploadDir'+namess[i]);
            }else{
                ext = img.attr('data-id');
                img.attr('src','/admin/uploads/exts/'+ext+'.png');
            }
          }
          old_files = $("#uploaded_passport_files").val();
          if(old_files)
            new_files = old_files + "," + new_names;
          else
            new_files = new_names;
            $("#uploaded_passport_files").val(new_files);
        },
        cache: false,
        xhr: function() {  // custom xhr
            myXhr = $.ajaxSettings.xhr();
            if (myXhr.upload) {
                return myXhr;
            }
        }
      });

    });
    $(document).on('click', "#ImageListPassport .img-ads", function(e){
       element = $(this).attr('title');
       files = ($("#uploaded_passport_files").val()).split(",");
       old_files = ($("#old_uploaded_passport_files").val()).split(",");
       var index = files.indexOf(element);
       if (index !== -1) {
        files.splice(index, 1);
        $("#uploaded_passport_files").val(files.join(","));
       }

       index = old_files.indexOf(element);
       if (index !== -1) {
        old_files.splice(index, 1);
        $("#old_uploaded_passport_files").val(old_files.join(","));
       }
       $.post('/$nowLanguage/profile/delete-passport-image?value='+element+'&id=$id',function(success){});
       e.preventDefault();
       e.target.parentElement.remove();
    });

    $(document).on('click', "#ImageListPassport img", function(e){
        ext = $(this).attr('data-id');
        if(ext){
            if(array.indexOf(ext) == -1){
            loc = '$uploadDir' + $(this).attr("data-name");
            alert(loc);
            }else{
                loc = $(this).attr("src");
            }
            window.open(loc, '_blank');
        }
       
    });
JS
)
?>
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
                var template = '<div class="image_preview_class"><span class="preview"><img src="'+e.target.result+'"></span></div>';
                $('.imagesList').append(template);
            };
        });
    });
});
JS
);
?>
<!-- <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('.img-ads').on('click',function() {
        var id = encodeURIComponent($(this).attr('data-id'));
        var path = encodeURIComponent($(this).attr('data-path'));
        var xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function(){
            if(xmlhttp.readyState == 4 && xmlhttp.status == 200){}
        }
        xmlhttp.open('GET', '/profile/remove-passport-file?id=' + id + '&path=' + path, true);
        xmlhttp.send();
        document.getElementById(path + "_" + id).remove();
    });
  });
</script> -->