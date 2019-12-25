<?php
use common\modules\langs\models\Langs;
use common\modules\langs\widgets\LangsWidgets;
use common\modules\translations\models\SourceMessage;
use yii\helpers\Html;
use kartik\editable\Editable;
use kartik\select2\Select2;

$langs=\backend\models\Lang::find()->where(['url'=>$id])->one();
$sources = SourceMessage::find()->messages()->all();
$data = \yii\helpers\ArrayHelper::map(\backend\models\Lang::find()->all(),'url','name');

$this->params['breadcrumbs'][] = ['label' => "Переводы", 'url' => ['/language/index']];

$tarjima = "Переводы";
$this->title = "Список переводы";
$this->params['breadcrumbs'][] = $this->title;
$s = 0;
$count = 0;
?>
<style type="text/css">
    .content-header h1{
        display: none;
    }
    .footer {
    position: static !important;
}
</style>
<div class="panel panel-primary" style="margin-top: 30px;">
    <div class="panel-heading"><h4><?=$this->title;?></h4></div>
    <div class="">
        <div class="container-fluid container-fixed-lg m-t-20">
            <div class="panel-transparent">

                <div class="panel-body no-padding">

                    <div class="panel panel-default">

                        <div class="panel-body page-header-block">

                            <h2><?= Html::encode($this->title) ?></h2>

                            <?= Html::a(Yii::t('app','Create'), ['create','id'=>$id], ['class' => 'btn btn-success']) ?>

                        </div>

                    </div>

                </div>  

                <div class="panel-body no-padding">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="pull-left">
                                    <h2><?=$tarjima;?></h2>
                                </div>
                            </div>
                            <div class="col-md-6">
                                 <div class="pull-right">
                                    <?=Html::a('Назадь',['/language/index'],['class'=>'btn btn-warning','style'=>'margin-top:20px;'])?>
                                </div>
                            </div>
                        </div>
                        <BR>
                        <div class="table-responsive">
                            <div class="input-group pull-left form-group">
                                <input type="text" class="form-control" placeholder="Поиск..." id="myInput">
                                <div class="input-group-btn">
                                  <button class="btn btn-default" type="submit">
                                    <i class="glyphicon glyphicon-search"></i>
                                  </button>
                                </div>
                            </div>
                            <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Источники</th>
                                <th>
                                    <?= $id; ?> (<?=$langs->name?>)
                                </th>
                               
                            </tr>
                            </thead>
                                <tbody id="myTable">
                                <?php foreach ($sources as $source): $messages = $source->messages;?>
                                    <?php $s++;?>
                                    <tr>
                                        <td>
                                            <?=$source->id?>
                                        </td>
                                        <td style="word-break:all;width:45%;">
                                            <?=$source->message?>
                                        </td>
                                        <?php foreach ($messages as $message): ?>
                                            <?php
                                                $value_lang = $message->translation;
                                                if($message->language == $id):
                                            ?>
                                            <td align="left">
                                                <?php
                                                $count = $count + 1;
                                                $lang_code = $message->language;
                                                echo Editable::widget([
                                                    'name'=>'translation['.$lang_code.']['.$source->id.']',
                                                    'asPopover' => true,
                                                    'inputType' => Editable::INPUT_TEXTAREA,
                                                    'value' => $value_lang,
                                                    'header' => Yii::t('app','Name'),
                                                    'size'=>'md',
                                                    'options' => ['class'=>'form-control',  'rows'=>5, 
                                                        'placeholder'=> Yii::t('app','Enter notes...')
                                                    ]
                                                ]);
                                                ?>
                                            </td>
                                        <?php endif; endforeach;?>
                                       
                                    </tr>
                                <?php endforeach;?>
                               
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$this->registerJs(<<<JS
    $(document).ready(function(){
      $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    })
JS
);
?>