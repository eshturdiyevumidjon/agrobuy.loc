            ,
<?php
use yii\widgets\DetailView;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use yii\helpers\Url;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

CrudAsset::register($this);
$this->title = 'Уюшма ҳақида';
if (!file_exists('uploads/about-company/' . $model->logo) || $model->logo == null) {
    $path = 'http://' . $_SERVER['SERVER_NAME'].'/backend/web/img/no-logo.png';
} else {
    $path = 'http://' . $_SERVER['SERVER_NAME'].'/backend/web/uploads/about-company/'.$model->logo;
}
$this->title = "О компаниях";
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="panel panel-inverse" data-sortable-id="ui-widget-14" style="">
        <div class="panel-heading">
            <div class="panel-heading-btn">

                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
            </div>
            <!-- <h3 class="pane-title"> -->
                <a class="btn btn-sm btn-info"   role="modal-remote" href="<?=Url::toRoute(['update', 'id' => $model->id])?>"><i class="fa fa-pencil"> Изменить</i> </a> 
            <!-- </h3> -->
        </div>
        <div class="panel-body">
            <?php Pjax::begin(['enablePushState' => false, 'id' => 'crud-datatable-pjax']) ?>
                <div class="col-md-2">
                    <img src="<?= $path?>" style = "width:150px; height:150px;object-fit: cover;">
                </div> 
                <div class="col-md-10 table-view" > 
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'project_name',
                            'phone',
                            'link',
                            'telegram',
                            'facebook',
                            'google',
                            'email:email',

                        ],
                    ]) ?>
                </div>
            <?php Pjax::end() ?>
        </div>
    </div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>

    