<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Banners */
$langs=backend\models\Lang::getLanguages();
?>
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
                        'attribute'=>'image',
                        'format'=>'raw',
                        'label'=>Yii::t('app','Image',null,$lang->url),
                        'value'=>function($data){
                            return $data->getImage('_columns');
                        },
                    ],

                    [
                        'attribute'=>'title',
                        'format'=>'html',
                        'label'=>Yii::t('app','Title',null,$lang->url),
                        'value'=>(($lang->url=="ru")?$model->title:$titles[$lang->url]),
                    ],
                    [
                        'attribute'=>'text',
                        'format'=>'html',
                        'label'=>Yii::t('app','Text',null,$lang->url),
                        'value'=>($lang->url=="ru")?$model->text:$texts[$lang->url],
                        'contentOptions' => ['class' => 'bg-red','style'=>'word-break: break-all;'],
                    ],
                    'link',
        ],
    ]) ?>
            
        </p>
     </div>
    <?php $i++; endforeach;?>
  </div>
</div>
