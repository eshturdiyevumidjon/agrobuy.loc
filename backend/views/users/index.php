<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

$this->title = "Пользователи";
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="panel panel-inverse user-index">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" title="Во весь экран" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" title="Обновить" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
        </div>
        <h4 class="panel-title">Пользователи </h4>
    </div>
    <div class="panel-body">
        <div id="ajaxCrudDatatable">
            <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'tableOptions' => ['class' => 'table table-bordered'],
            'pjax'=>true,
            'rowOptions' => function ($model){
                if($model->access == 1) return ['style'=>'background:white'];
                else return ['class' => 'danger'];
            },
            'columns' => require(__DIR__.'/_columns.php'),
            'panelBeforeTemplate' => Html::a('Добавить <i class="fa fa-plus"></i>', ['create'],
                    ['role'=>'modal-remote','title'=> 'Добавить пользователя','class'=>'btn btn-success']).'&nbsp;' . 
                    Html::a('История удалении', ['history'],
                    ['data-pjax'=>'0','title'=> 'История удалении','class'=>'btn btn-warning']),
            'striped' => true,
            'condensed' => true,
            'responsive' => true,
            'panel' => [
            'headingOptions' => ['style' => 'display: none;'],
            'after'=>
            '<div class="clearfix"></div>',
            ]
            ])?>
        </div>
    </div>
</div>

<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "options" => [
        "tabindex" => false,
    ],
    "footer"=>"",
])?>
<?php Modal::end(); ?>
