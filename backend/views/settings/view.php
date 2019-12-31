<?php

use yii\widgets\DetailView;
$langs=backend\models\Lang::getLanguages();

/* @var $this yii\web\View */
/* @var $model backend\models\Settings */
$this->title = Yii::t('app', 'Settings');
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/settings/index']];
$this->params['breadcrumbs'][] = Yii::t('app','View');
?>
 <div class="panel panel-inverse" data-sortable-id="ui-widget-14" style="">
    <div class="panel-heading">
        <h4 class="panel-title"><?=Yii::t('app','View')?></h4>
    </div>
    <div class="panel-body">
           <div class="banners-view">
         <ul class="nav nav-tabs" style="margin-top:2px;">
            <?php foreach($langs as $lang):?>
            <li class="<?=($i==0)?'active':''?>">
                <a data-toggle="tab" href="#<?=$lang->url?>"><?=(isset(explode('-',$lang->name)[1])?explode('-',$lang->name)[1]:$lang->name)?></a>
            </li>
            <?php $i++; endforeach;?>
           </ul>
          <div class="tab-content">   
             
            <?php $i=0; foreach($langs as $lang):?>
             <div id="<?=$lang->url?>" class="tab-pane fade <?=($i==0)?'in active':''?>">
                <p>
                      <?php
                  
                      echo DetailView::widget([
                        'model' => $model,
                         'attributes' => [ 
                            [
                                'attribute'=>'name',
                                'format'=>'raw',
                                'label'=>Yii::t('app','Title',null,$lang->url),
                                'value'=>(($lang->url=="kr")?$model->name:$names[$lang->url]),
                            ],
                            [
                                'attribute'=>'value',
                                'format'=>'raw',
                                'label'=>Yii::t('app','Text',null,$lang->url),
                                'value'=>($lang->url=="kr")?$model->value:$values[$lang->url],
                                'contentOptions' => ['style'=>'word-break: break-all;'],
                            ],
                           'key',
                            'priority',
                            'view_in_footerser_id',
                ],
            ]) ?>
                    
                </p>
             </div>
            <?php $i++; endforeach;?>
          </div>
        </div>
    </div>
</div>
