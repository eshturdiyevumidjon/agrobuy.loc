<?php

namespace backend\controllers;

use Yii;
use backend\models\Banners;
use backend\models\BannersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use backend\models\Lang;
use yii\web\UploadedFile;
use backend\models\Translates;

/**
 * BannersController implements the CRUD actions for Banners model.
 */
class BannersController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
          'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
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
     * Lists all Banners models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new BannersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Banners model.
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
                        $translation_title[$value->language_code] = $value->field_value;
                        break;
                    default:
                        $translation_text[$value->language_code] = $value->field_value;
                        break;
                }
            }
            return [
                    'title'=>Yii::t('app','Banners'),
                    'content'=>$this->renderAjax('view', [
                        'model'=>$model,
                        'titles'=>$translation_title,
                        'texts'=>$translation_text,
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
     * Creates a new Banners model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Banners();  
        $langs = Lang::getLanguages();
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            $post = $request->post();
            if($model->load($post)){
                $model->save();
                  $attr = Banners::NeedTranslation();
                  foreach ($langs as $lang) {
                          $l = $lang->url;
                          if($l == 'kr')
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
                         $t->field_value=$post["Banners"][$value][$l];
                         $t->field_description=$value;
                         $t->language_code=$l;
                         $t->save();
                      }
                  }
                  $model->upload();
                
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'size'=>'normal',
                     'title'=> Yii::t('app','Create'),
                    'content'=>'<span class="text-success">'.Yii::t('app','Complete successfully').'</span>',
                    'footer'=> Html::button(Yii::t('app','Close'),['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                           Html::a(Yii::t('app','Create more'),['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                     'title'=> Yii::t('app','Create'),
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
     * Updates an existing Banners model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        $request = Yii::$app->request;
        $langs = Lang::getLanguages();
        $post=$request->post();
        $model = $this->findModel($id);

        $translation_text = [];
        $translation_title = [];

        if($request->isAjax){
            
          $translations = Translates::find()->where(['table_name'=>$model->tableName(),'field_id'=>$model->id])->all();
                foreach ($translations as $key => $value) {
                    switch ($value->field_name) {
                        case 'title':
                            $translation_title[$value->language_code] = $value->field_value;
                            break;
                        default:
                            $translation_text[$value->language_code] = $value->field_value;
                            break;
                    }
                }

            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load($request->post())){
                $model->save();
                $model->upload();

                $attr = Banners::NeedTranslation();
                
                foreach ($langs as $lang) {
                       
                        $l = $lang->url;
                        if($l == 'kr')
                        {
                           continue;
                        }
                      foreach ($attr as $key=>$value) {
                          $t = Translates::find()->where(['table_name' => $model->tableName(),'field_id' => $model->id,'language_code' => $l,'field_name'=>$key]);
                          if($t->count() == 1){
                             $tt = $t->one();
                             $tt->field_value=$post["Banners"][$value][$l];
                             $tt->save();
                           }
                           else{
                               $tt=new Translates();
                               $tt->table_name=$model->tableName();
                               $tt->field_id=$model->id;
                               $tt->field_name=$key;
                               $tt->field_value=$post["Banners"][$value][$l];
                               $tt->field_description=$value;
                               $tt->language_code=$l;
                               $tt->save();
                           }
                      }
                }
                $translations = Translates::find()->where(['table_name'=>$model->tableName(),'field_id'=>$model->id])->all();
                foreach ($translations as $key => $value) {
                    switch ($value->field_name) {
                        case 'title':
                            $translation_title[$value->language_code] = $value->field_value;
                            break;
                        default:
                            $translation_text[$value->language_code] = $value->field_value;
                            break;
                    }
                }
            if($model->save())
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'forceClose'=>true,
                ];  
                else{
                           
                 return [
                    'title'=> Yii::t('app','Update'),
                    'size'=>'large',
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'titles'=>$translation_title,
                        'texts'=>$translation_text,
                    ]),
                    'footer'=> Html::button(Yii::t('app','Close'),['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button(Yii::t('app','Save'),['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }  
            }else{
                           
                 return [
                    'title'=> Yii::t('app','Update'),
                    'size'=>'large',
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'titles'=>$translation_title,
                        'texts'=>$translation_text,
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
                $model->upload();

                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing Banners model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $dir = 'uploads/banners/';
        $request = Yii::$app->request;
        $model=$this->findModel($id);
        Translates::deleteAll(['table_name' => $model->tableName(),'field_id' => $id]);
        if(file_exists($dir.$model->image)&&$model->image!=null)
        {
            unlink($dir.$model->image);
        }
        $model->delete();    
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }


    }

     /**
     * Delete multiple existing Banners model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkDelete()
    {        
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            Translates::deleteAll(['table_name' => $model->tableName(),'field_id' => $id]);
            if(file_exists($dir.$model->image)&&$model->image!=null)
            {
                unlink($dir.$model->image);
            }
            $model->delete();
        }

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
       
    }

    /**
     * Finds the Banners model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Banners the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Banners::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
