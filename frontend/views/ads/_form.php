<?php

	use yii\helpers\Html;

?>

<section class="creating-ads">
    <div class="container">
        <h2 class="title">Создайте объявление</h2>  
        <form action="#">
          	<div class="row">
            	<div class="col-lg-2 col-sm-4 col-6">
              		<div class="form-group radio-style">
                		<input type="radio" name="buy" id="radi1">
                		<label for="radi1">Продать</label>
              		</div>
            	</div>
	            <div class="col-lg-2 col-sm-4 col-6">
	              	<div class="form-group radio-style">
	                	<input type="radio" name="buy" id="radi2">
	                	<label for="radi2">Купить</label>
	              	</div>
	            </div>
	            <div class="col-lg-4 col-sm-4 col-12">
	              	<div class="form-group radio-style">
	                	<input type="radio" name="buy" id="radi3">
	                	<label for="radi3">Добавить в каталог</label>
	              	</div>
	            </div>
          	</div>
          	<hr>
          	<div class="row">
            	<div class="col-xl-9">
              		<div class="attach">
                		<label for="rad">Прикрепить <br> фото</label>
                		<span class="multiple-photos">
                  			Можно загрузить несколько фото <button class="fileinput-button dz-clickable"></button>
                		</span>
                		<a href="#">Прикрепить файл</a>
              		</div> 
              <div class="dropzone-body">
                    <!-- HTML heavily inspired by https://blueimp.github.io/jQuery-File-Upload/ -->
                    <div id="actions" class="row" style="display: none;">
                        <div class="col-lg-7">
                          <!-- The fileinput-button span is used to style the file input field as button -->
                          <span class="btn btn-success fileinput-button dz-clickable">
                              <i class="glyphicon glyphicon-plus"></i>
                              <span>Add files...</span>
                          </span>
                          <button type="submit" class="btn btn-primary start">
                              <i class="glyphicon glyphicon-upload"></i>
                              <span>Start upload</span>
                          </button>
                          <button type="reset" class="btn btn-warning cancel">
                              <i class="glyphicon glyphicon-ban-circle"></i>
                              <span>Cancel upload</span>
                          </button>
                        </div>

                        <div class="col-lg-5">
                          <!-- The global file processing state -->
                          <span class="fileupload-process">
                            <div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                              <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress=""></div>
                            </div>
                          </span>
                        </div>
                    </div>
                    <div class="files" id="previews">
                        
                    </div>
              </div>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-xl-9">
              <div class="form-group create-select-style">
                <label for="">Выберите <br>категорию</label>
                <select name="" id="" class="js-select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                  <option value=""></option>
                  <option value="">option1</option>
                  <option value="">option2</option>
                  <option value="">option3</option>
                </select><span class="select2 select2-container select2-container--default" dir="ltr" style="width: 101.2px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2--container"><span class="select2-selection__rendered" id="select2--container" title=""></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
              </div>
              <div class="form-group create-select-style">
                <label for="">Выберите <br>подкатегорию</label>
                <select name="" id="" class="js-select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                  <option value=""></option>
                  <option value="">option1</option>
                  <option value="">option2</option>
                  <option value="">option3</option>
                </select><span class="select2 select2-container select2-container--default" dir="ltr" style="width: 101.2px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2--container"><span class="select2-selection__rendered" id="select2--container" title=""></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
              </div>
              <div class="form-group create-select-style">
                <label for="">Добавьте<br>город, регион</label>
                <select name="" id="" class="js-select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                  <option value=""></option>
                  <option value="">option1</option>
                  <option value="">option2</option>
                  <option value="">option3</option>
                </select><span class="select2 select2-container select2-container--default" dir="ltr" style="width: 101.2px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2--container"><span class="select2-selection__rendered" id="select2--container" title=""></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
              </div>
              <div class="form-group create-input-style">
                <label for="">Заголовок<br>объявления</label>
                <input type="text" maxlength="70">
              </div>
              <div class="form-group create-textarea-style">
                <label for="">Подробно опишите объявление</label>
                <textarea name="" id="" maxlength="9000"></textarea>
              </div>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-xl-9">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group create-bottom-style">
                    <label for="">Укажите цену</label>
                    <input type="number">
                  </div>
                </div> 
                <div class="col-sm-6">
                  <div class="form-group create-bottom-style">
                    <label for="">Цена за</label>
                    <input type="text" placeholder="Введите единицу" data-toggle="tooltip" title="" name="secondname" data-original-title="Тонна, кг, ящик и т.д.">
                  </div>
                </div> 
              </div>
            </div>
            <div class="col-lg-3">
              <div class="form-group radio-style treat">
                <input type="checkbox" id="treaty">
                <label for="treaty">Договорная</label>
              </div>
            </div>
          </div>
          <hr>
          <div class="text-center">
            <button type="submit" class="btn-template">Опубликовать объявление</button>
          </div>
        </form>     
      </div>
    </section>