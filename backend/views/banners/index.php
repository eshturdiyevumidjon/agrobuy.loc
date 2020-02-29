<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use backend\models\AboutCompany;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\BannersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "Баннеры";
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);
$aboutCompany = AboutCompany::findOne(1);
if($aboutCompany->view_banners == 1) $title = 'Отключить слайдера';
if($aboutCompany->view_banners == 0) $title = 'Включить слайдера';

?>
<div class="panel panel-inverse user-index">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" title="Во весь экран" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" title="Обновить" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
        </div>
        <h4 class="panel-title"><?=$this->title?></h4>
    </div>
    <div class="panel-body">
        <div id="ajaxCrudDatatable">
                <?=GridView::widget([
                    'id'=>'crud-datatable',
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'pjax'=>true,
                    'tableOptions' => ['class' => 'table table-bordered'],
                    'columns' => require(__DIR__.'/_columns.php'),
                    'panelBeforeTemplate' =>    Html::a('Добавить <i class="fa fa-plus"></i>', ['create'],
                    ['role'=>'modal-remote','title'=> 'Добавить пользователя','class'=>'btn btn-success']).'&nbsp;' . 
                     Html::a($title, ['/about-company/edit-banner'],
                    ['role'=>'modal-remote','title'=> 'Отключить/Включить слайдера','class'=>'btn btn-warning']),
                    'striped' => true,
                    'condensed' => true,
                    'responsive' => true,          
                    'panel' => [
                        'type' => 'primary', 
                        
                        'headingOptions' => ['style' => 'display: none;'],
                        'after'=>BulkButtonWidget::widget([
                                    'buttons'=>Html::a('<i class="glyphicon glyphicon-trash"></i>&nbsp;'.Yii::t('app','Delete All'),
                                        ["bulk-delete"] ,
                                        [
                                            "class"=>"btn btn-danger btn-xs",
                                            'role'=>'modal-remote-bulk',
                                            'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                                            'data-request-method'=>'post',
                                            'data-confirm-title'=>Yii::t('app','Are you sure?'),
                                            'data-confirm-message'=>Yii::t('app','Are you sure want to delete this item')
                                        ]),
                                ]).                        
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
