<?php

namespace backend\controllers;

use Yii;
use backend\models\Settings;
use backend\models\Translates;
use backend\models\SettingsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use backend\models\Lang;
use yii\helpers\Html;

/**
 * SettingsController implements the CRUD actions for Settings model.
 */
class SettingsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Settings models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new SettingsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Settings model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            $model = $this->findModel($id);
            Yii::$app->response->format = Response::FORMAT_JSON;

            $translations = Translates::find()->where(['table_name'=>$model->tableName(),'field_id'=>$model->id])->all();
            foreach ($translations as $key => $value) {
                switch ($value->field_name) {
                    case 'title':
                        $translation_name[$value->language_code] = $value->field_value;
                        break;
                    default:
                        $translation_value[$value->language_code] = $value->field_value;
                        break;
                }
            }

            return [
                    'title'=> Yii::t('app','Settings'),
                    'size'=>'large',
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                        'names'=>$translation_name,
                        'values'=>$translation_value,
                    ]),
                    'footer'=> Html::button(Yii::t('app','Close'),['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a(Yii::t('app','Edit'),['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new Settings model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Settings();  
        $langs = Lang::getLanguages();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            $post = $request->post();
            if($model->load($post)){

                $attr = Settings::NeedTranslation();
                foreach ($langs as $lang) {
                        $l = $lang->url;
                        if($l == 'ru')
                        {
                            if(!$model->save())
                              return [
                                'title'=> Yii::t('app','Create'),
                                'size'=>'large',
                                'content'=>$this->renderAjax('create', [
                                    'model' => $model,
                                ]),
                                'footer'=> Html::button(Yii::t('app','Close'),['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                            Html::button(Yii::t('app','Save'),['class'=>'btn btn-primary','type'=>"submit"])
                    
                            ]; 
                           else continue;
                        }
                    foreach ($attr as $key=>$value) {
                       $t=new Translates();
                       $t->table_name=$model->tableName();
                       $t->field_id=$model->id;
                       $t->field_name=$key;
                       $t->field_value=$post["Settings"][$value][$l];
                       $t->field_description=$value;
                       $t->language_code=$l;
                       $t->save();
                    }
                }
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> Yii::t('app',"Create"),
                    'size'=>'normal',
                    'content'=>'<span class="text-success">Create Settings success</span>',
                    'footer'=> Html::button(Yii::t('app','Close'),['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Create More',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> Yii::t('app',"Create"),
                    'size'=>'large',
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button(Yii::t('app','Close'),['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button(Yii::t('app','Save'),['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
       
    }

    /**
     * Updates an existing Settings model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $post=$request->post();
        $langs = Lang::getLanguages();
        $model = $this->findModel($id); 

        if($request->isAjax){


             $translations = Translates::find()->where(['table_name' => $model->tableName(),'field_id' => $model->id])->all();
                foreach ($translations as $key => $value) {
                   switch ($value->field_name) {
                        case 'name':
                            $translation_name[$value->language_code] = $value->field_value;
                            break;
                        default:
                            $translation_value[$value->language_code] = $value->field_value;
                            break;
                    }                
                }
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
           if($model->load($request->post()) && $model->save()){
              $attr = Settings::NeedTranslation();
                
                foreach ($langs as $lang) {
                       
                        $l = $lang->url;
                        if($l == 'ru')
                        {
                           continue;
                        }
                      foreach ($attr as $key=>$value) {
                          $t = Translates::find()->where(['table_name' => $model->tableName(),'field_id' => $model->id,'language_code' => $l,'field_name'=>$key]);
                          if($t->count() == 1){
                             $tt = $t->one();
                             $tt->field_value=$post["Settings"][$value][$l];
                             $tt->save();
                           }
                           else{
                               $tt=new Translates();
                               $tt->table_name=$model->tableName();
                               $tt->field_id=$model->id;
                               $tt->field_name=$key;
                               $tt->field_value=$post["Settings"][$value][$l];
                               $tt->field_description=$value;
                               $tt->language_code=$l;
                               $tt->save();
                           }
                      }
                }

               $translations=Translates::find()->where(['table_name' => $model->tableName(),'field_id' => $model->id])->all();
                foreach ($translations as $key => $value) {
 
                switch ($value->field_name) {
                    case 'name':
                        $translation_name[$value->language_code] = $value->field_value;
                        break;
                    default:
                        $translation_value[$value->language_code] = $value->field_value;
                        break;
                }
            } 
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'forceClose'=>true,
                    // 'title'=> Yii::t('app','Settings'),
                    // 'size'=>'large',
                    // 'content'=>$this->renderAjax('view', [
                    //     'model' => $model,
                    // ]),
                    // 'footer'=> Html::button(Yii::t('app','Close'),['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                    //         Html::a(Yii::t('app','Edit'),['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> Yii::t('app','Update'),
                    'size'=>'large',
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'names'=>$translation_name,
                        'values'=>$translation_value,
                    ]),
                    'footer'=> Html::button(Yii::t('app','Close'),['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button(Yii::t('app','Save'),['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Finds the Settings model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Settings the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Settings::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
