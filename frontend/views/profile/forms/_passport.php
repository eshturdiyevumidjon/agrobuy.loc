    <form class="edit-item">
        <div class="title-edit">Паспортные данные</div>
            <div class="edit-item-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group inpt-min">
                                    <label for="">Серия <br>паспорта</label>
                                    <input type="text" class="form-control">
                                </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">Номер <br>паспорта</label>
                      <input type="text" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="form-group inpt-min">
                  <label for="">Дата <br>рождения</label>
                  <input type="text" class="form-control datetimepicker hasDatepicker" placeholder="01.01.2019" id="dp1580923370520">
                </div>
                <div class="form-group inpt-min">
                  <label for="">Кем <br>выдан</label>
                  <input type="text" class="form-control">
                </div>                
              </div>
            </div>

            <div class="row">
              <div class="col-xl-6 col-lg-12">
                <div class="attach inpt-min ">
                  <label for="rad">Прикрепить <br> фото</label>
                  <span class="multiple-photos">
                    Можно загрузить несколько фото <button class="fileinput-button dz-clickable"></button>
                  </span>
                </div> 
              </div>
              <div class="col-xl-3 col-lg-6 attach fda-rew">
                <a href="#">Прикрепить файл</a>
              </div>
              <div class="col-xl-3 col-lg-6 col-sm-12 col-12 text-right">
                <button type="submit" class="btn-template">Сохранить</button>
              </div>
              <div class="col-12">
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


          </div>
        </form>