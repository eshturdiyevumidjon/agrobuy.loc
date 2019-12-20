<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\web\JsExpression;
use jakharbek\categories\models\Categories;

use common\modules\langs\widgets\LangsWidgets;
use dosamigos\ckeditor\CKEditor;
use kartik\editable\Editable;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $model common\modules\translations\models\SourceMessage */

$this->title = Yii::t('app','Create Source Message');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app','Source Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid container-fixed-lg m-t-20">

    <div class="panel panel-transparent">

        <div class="panel-body no-padding">
            <div class="panel panel-default">
                <div class="panel-body page-header-block">

                    <h2><?= Html::encode($this->title) ?></h2>

                </div>

            </div>

        </div>

        <div class="panel-body no-padding row-default">

            <div class="row">

                <div class="tab-content source-message-create">

                    <?=  $this->render('_form', [
                        'model' => $model,
                    ]) ?>

                </div>

            </div>
        </div>

    </div>

</div>
