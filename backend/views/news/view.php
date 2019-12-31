<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\News */
$langs=backend\models\Lang::getLanguages();

?>
<div class="news-view">
 <ul class="nav nav-pills" style="margin-top:2px;">
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
                        'attribute'=>'fone',
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
                        'value'=>(($lang->url=="kr")?$model->title:$titles[$lang->url]),
                    ],
                    [
                        'attribute'=>'text',
                        'format'=>'html',
                        'label'=>Yii::t('app','Text',null,$lang->url),
                        'value'=>($lang->url=="kr")?$model->text:$texts[$lang->url],
                        'contentOptions' => ['style'=>'word-break: break-all;'],
                    ],
                    'date',
                    
        ],
    ]) ?>
            
        </p>
     </div>
    <?php $i++; endforeach;?>
  </div>
</div>