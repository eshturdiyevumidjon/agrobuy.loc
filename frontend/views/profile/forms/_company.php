<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Users;

$images =  isset($post['uploaded_company_files']) ? $post['uploaded_company_files'] : null;

$dir = Users::DIR_NAME_FOR_UPLOADING_COMPANIES_FILES;
$uploadDir = Users::TEMP_DIR_NAME;
?>
    <?php $form = ActiveForm::begin(['id' => '_company', 'options' => ['method' => 'post', 'class' => 'edit-item', 'autocomplete'=>"off"]]); ?>
        <div class="title-edit"><?=Yii::t('app', "Kompaniyani qo'shish uchun ariza")?></div>
        <div class="edit-item-body">
            <div class="row">
                <div class="col-lg-6">
                    <?= $form->field($model, 'company_name', ['options' => ['class' => 'form-group inpt-min']])->textInput(['class' => 'form-control'])->label(Yii::t('app', "Kompaniya nomi")) ?>
                </div>
            </div>
            <div class="imagesList" id="ImageListCompany">
              <?php if ($model->company_files): ?>
                <?php foreach (explode(",",$model->company_files) as $value): ?>
                    <div class="image_preview_class">
                        <a class="img-ads" title="<?=$value?>">x</a>
                        <?php $ext = $model->isImage($value); if ($ext != ""): ?>
                            <span class="preview">
                                <img src="/admin/uploads/exts/<?=$ext?>.png" data-new="0" data-name="<?=$value?>" >
                            </span> 
                        <?php else: ?>
                            <span class="preview">
                                <img src="<?=$dir.$value?>" data-new="0" data-name="<?=$value?>" >
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
                                <img src="/admin/uploads/<?=$ext?>.png" data-new="0" data-name="<?=$value?>" >
                            </span> 
                        <?php else: ?>
                            <span class="preview">
                                <img src="<?=$dir.$value?>" data-new="0" data-name="<?=$value?>" >
                            </span> 
                        <?php endif ?>
                    </div>
                <?php endforeach ?>
              <?php endif ?>
            </div>
            <div class="row">
                <div class="col-xl-9">
                    <input type="file" name="imagesProba" accept="image/*,.doc, .docx,.txt,.pdf" multiple="true" style="display: none" id="inputFileCompany">
                    <input type="hidden" name="uploaded_company_files" id="uploaded_company_files" value="<?=$images?>">
                    <input type="hidden" name="old_uploaded_company_files" id="old_uploaded_company_files" value="<?=$model->company_files?>">
                    <div class="attach">
                      <?=Yii::t('app', "Foto biriktirish")?>&nbsp;&nbsp;&nbsp;
                      <label for="inputFileCompany">
                        <span class="multiple-photos">
                                <div class="fileinput-button dz-clickable"></div>
                            </span>
                      </label>
                    </div> 
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-xl-9">
                    <div class="main-list-of-required">
                        <p><span><?=Yii::t('app', "Kerakli fayllar ro'yxati")?></span> <img src="/images/right-arrow-green.png" alt=""></p>
                        <ul style="display: none;">
                            <li>ИНН</li>
                            <li>Свидетельство о регистрации Юр лица</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-xl-3 col-sm-12 col-12 text-right">
                    <?= Html::submitButton(Yii::t('app',"So'rov yuborish"), ['class' => 'btn-template']) ?>
                </div>
            </div>
        </div>
    <?php ActiveForm::end(); ?>


<?php 
$id = $model->id;
$this->registerJs(<<<JS
  var array = ["gif", "jpeg", "jpg", "png"];
  $("#inputFileCompany").on('change',function(e){
      namess = [];
      var files = e.target.files;
      var data = new FormData(); 
      $.each(files, function(i,file){
          var d = new Date();
          var new_name = d.getFullYear() + '-' + d.getMonth() + '-' + d.getDate() + '_' +d.getHours() + '-' + d.getMinutes() + '-' + d.getSeconds();  
          var filename = $( '#inputFileCompany' )[0].files[i].name;
          name = filename.split('.').shift();
          var ext = filename.split('.').pop();
          new_name = name + '(' + new_name + ")." + ext;
          data.append('file[]', $( '#inputFileCompany' )[0].files[i]) ; 
          data.append('names[]', new_name) ; 
          namess.push(new_name);
          template = '<div class="image_preview_class" data-id="'+ new_name +'"><a class="img-ads" title="'+new_name+'">x</a><span class="preview"><img src="/admin/uploads/zz.gif" data-id="'+ ext +'" data-name="'+ new_name +'" data-new="1"></span></div>';
          $("#ImageListCompany").append(template);
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
          old_files = $("#uploaded_company_files").val();
          if(old_files)
            new_files = old_files + "," + new_names;
          else
            new_files = new_names;
            $("#uploaded_company_files").val(new_files);
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
    $(document).on('click', "#ImageListCompany .img-ads", function(e){
       element = $(this).attr('title');
       files = ($("#uploaded_company_files").val()).split(",");
       old_files = ($("#old_uploaded_company_files").val()).split(",");
       var index = files.indexOf(element);
       if (index !== -1) {
        files.splice(index, 1);
        $("#uploaded_company_files").val(files.join(","));
       }

       index = old_files.indexOf(element);
       if (index !== -1) {
        old_files.splice(index, 1);
        $("#old_uploaded_company_files").val(old_files.join(","));
       }
       $.post('/$nowLanguage/profile/delete-company-image?value='+element+'&id=$id',function(success){});
       e.preventDefault();
       e.target.parentElement.remove();
    });

    $(document).on('click', "#ImageListCompany img", function(e){
        ext = $(this).attr('data-id');
        if(ext){
            if(array.indexOf(ext) == -1){
            loc = '$uploadDir' + $(this).attr("data-name");
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

    $(document).on('change', '.image_input_company', function(e){
        var files = e.target.files;
        $.each(files, function(i, file){
            fileCollection.push(file);
            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function(e){
                var template = '<div class="image_preview_class"><span class="preview"><img src="'+e.target.result+'"></span></div>';
                $('#imagesListCompany').append(template);
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
        xmlhttp.open('GET', '/profile/remove-company-file?id=' + id + '&path=' + path, true);
        xmlhttp.send();
        document.getElementById(path + "_" + id).remove();
    });
  });
</script> -->