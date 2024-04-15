<?php

namespace backend\controllers;

use Yii;
use backend\models\Categories;
use backend\models\SubCategories;
use backend\models\CategoriesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\web\HttpException;
use backend\models\Lang;
use yii\web\UploadedFile;
use backend\models\Translates;

class CategoriesController extends Controller
{
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

    public function beforeAction($action)
    {
        if(Yii::$app->user->identity->id === null) return $this->redirect(['/site/login']);
        $type = Yii::$app->user->identity->type;

        if($action->id =='index' || $action->id =='view')
        {   
            if($type != 1 && $type != 2) {
                throw new HttpException(403,'У вас нет разрешения на доступ к этому действию.');
            }
        }

        if($action->id =='create')
        {   
            if($type != 1 && $type != 2) {
                throw new HttpException(403,'У вас нет разрешения на доступ к этому действию.');
            }
        }

         if($action->id =='update')
        {   
            if($type != 1 && $type != 2) {
                throw new HttpException(403,'У вас нет разрешения на доступ к этому действию.');
            }
        }

        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    
    public function actionIndex()
    {    
        $searchModel = new CategoriesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $request = Yii::$app->request;
        $post = $request->post();
        $model = new Categories();  
        $langs = Lang::getLanguages();

        if($request->isAjax){
            
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load($post) && $model->save()) {
                $attr = Categories::NeedTranslation();
                foreach ($langs as $lang) {
                    $l = $lang->url;
                    if($l == 'kr') {
                        if(!$model->save()) {
                            return [
                                'title'=> Yii::t('app','Create'),
                                'content'=>$this->renderAjax('create', [
                                    'model' => $model,
                                    'titles' => null,
                                    'post' => $post,
                                    'langs' => $langs,
                                ]),
                                'footer'=> Html::button(Yii::t('app','Close'),['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button(Yii::t('app','Save'),['class'=>'btn btn-primary','type'=>"submit"])
                            ];
                        }
                        else continue;
                    }
                    foreach ($attr as $key=>$value) {
                        $t = new Translates();
                        $t->table_name = $model->tableName();
                        $t->field_id = $model->id;
                        $t->field_name = $key;
                        $t->field_value = $post["Categories"][$value][$l];
                        $t->field_description = $value;
                        $t->language_code = $l;
                        $t->save();
                    }
                }
                
                $model->trash = UploadedFile::getInstance($model,'trash');
                $dir = 'uploads/category/';
                if(!empty($model->trash)) {   
                    if($model->trash != null && file_exists($dir.$model->trash)) {
                        unlink(($dir.$model->trash));
                    }
                    $name = $model->id . "-" . time();
                    $model->trash->saveAs($dir . $name . '.' . $model->trash->extension);
                    Yii::$app->db->createCommand()->update('category', ['image' => $name . '.' . $model->trash->extension], [ 'id' => $model->id ])->execute();
                }
                return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];         
            }
            else {           
                return [
                    'title'=> Yii::t('app','Create'),
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'titles' => null,
                        'post' => $post,
                        'langs' => $langs,
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }
        }       
    }
   
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $langs = Lang::getLanguages();
        $post = $request->post();

        $translation_title = [];

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            $translations = Translates::find()->where(['table_name' => $model->tableName(), 'field_id' => $model->id])->all();
            foreach ($translations as $key => $value) {
                $translation_title[$value->language_code] = $value->field_value;
            }
            if($model->load($request->post()) && $model->save()) {
                $model->trash = UploadedFile::getInstance($model,'trash');
                $dir = 'uploads/category/';
                if(!empty($model->trash)) {   
                    if($model->trash != null && file_exists($dir.$model->trash)) {
                        unlink(($dir.$model->trash));
                    }
                    $name = $model->id . "-" . time();
                    $model->trash->saveAs($dir . $name . '.' . $model->trash->extension);
                    Yii::$app->db->createCommand()->update('category', ['image' => $name . '.' . $model->trash->extension], [ 'id' => $model->id ])->execute();
                }

                $attr = Categories::NeedTranslation();
                foreach ($langs as $lang) {
                    $l = $lang->url;
                    if($l == 'kr') {
                       continue;
                    }
                    foreach ($attr as $key => $value) {
                        $t = Translates::find()->where(['table_name' => $model->tableName(),'field_id' => $model->id, 'language_code' => $l,'field_name' => $key]);
                        if($t->count() == 1) {
                            $tt = $t->one();
                            $tt->field_value = $post["Categories"][$value][$l];
                            $tt->save();
                        }
                        else{
                            $tt=new Translates();
                            $tt->table_name = $model->tableName();
                            $tt->field_id = $model->id;
                            $tt->field_name = $key;
                            $tt->field_value = $post["Categories"][$value][$l];
                            $tt->field_description = $value;
                            $tt->language_code = $l;
                            $tt->save();
                        }
                    }
                }
                $translations = Translates::find()->where(['table_name'=>$model->tableName(),'field_id'=>$model->id])->all();
                foreach ($translations as $key => $value) {
                    $translation_title[$value->language_code] = $value->field_value;
                }
                if($model->save()) {
                    return [
                        'forceReload' => '#crud-datatable-pjax',
                        'forceClose' => true,
                    ];
                }
                else {
                    return [
                        'title'=> Yii::t('app','Update'),
                        'size'=>'large',
                        'content'=>$this->renderAjax('update', [
                            'model' => $model,
                            'titles' => $translation_title,
                            'post' => $post,
                            'langs' => $langs,
                        ]),
                        'footer'=> Html::button(Yii::t('app','Close'),['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::button(Yii::t('app','Save'),['class'=>'btn btn-primary','type'=>"submit"])
                    ];
                }
            }else{
                 return [
                    'title'=> "Изменить",
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'titles'=>$translation_title,
                        'post' => $post,
                        'langs' => $langs,
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }
        }
    }

    public function actionAddSubCategory($id)
    {
        $request = Yii::$app->request;
        $model = new SubCategories();
        $model->category_id = $id;
        $post = $request->post();
        $langs = Lang::getLanguages();

        $translation_name = [];

        Yii::$app->response->format = Response::FORMAT_JSON;
        if($model->load($request->post()) && $model->save()){
            $attr = SubCategories::NeedTranslation();
                foreach ($langs as $lang) {
                        $l = $lang->url;
                        if($l == 'kr')
                        {
                            if(!$model->save())
                              return [
                                'title'=> Yii::t('app','Create'),
                                'content'=>$this->renderAjax('_add_sub_category_form', [
                                    'model' => $model,
                                    'translation_name'=>$translation_name,
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
                       $t->field_value=$post["SubCategories"][$value][$l];
                       $t->field_description=$value;
                       $t->language_code=$l;
                       $t->save();
                    }
                }

            return [
                'forceReload'=>'#crud-datatable-pjax',
                'title'=> "Суб-категория",
                'content'=>'<span class="text-success">Успешно выпольнено</span>',
                'forceClose'=>true,
            ];         
        }else{           
            return [
                'title'=> Yii::t('app','Create'),
                'content'=>$this->renderAjax('_add_sub_category_form', [
                    'model' => $model,
                    'translation_name'=>$translation_name,

                ]),
                'footer'=> Html::button('Закрыть',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
            ];
        }
    }

    public function actionUpdateSub($id)
    {
        $request = Yii::$app->request;
        $model = SubCategories::findOne($id);
        $langs = Lang::getLanguages();
        $post=$request->post();

        $translation_name = [];

         $translations = Translates::find()->where(['table_name'=>$model->tableName(),'field_id'=>$model->id])->all();
            foreach ($translations as $key => $value) {
                $translation_name[$value->language_code] = $value->field_value;
            }

        Yii::$app->response->format = Response::FORMAT_JSON;
        if($model->load($request->post()) && $model->save()){
            $attr = SubCategories::NeedTranslation();
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
                             $tt->field_value=$post["SubCategories"][$value][$l];
                             $tt->save();
                           }
                           else{
                               $tt=new Translates();
                               $tt->table_name=$model->tableName();
                               $tt->field_id=$model->id;
                               $tt->field_name=$key;
                               $tt->field_value=$post["SubCategories"][$value][$l];
                               $tt->field_description=$value;
                               $tt->language_code=$l;
                               $tt->save();
                           }
                      }
                }
                $translations = Translates::find()->where(['table_name'=>$model->tableName(),'field_id'=>$model->id])->all();
                foreach ($translations as $key => $value) {
                    $translation_name[$value->language_code] = $value->field_value;
                }
                if($model->save())
                    return [
                        'forceReload'=>'#crud-datatable-pjax',
                        'forceClose'=>true,
                    ];  
                else
                    return [
                        'title'=> Yii::t('app','Update'),
                        'size'=>'large',
                        'content'=>$this->renderAjax('_add_sub_category_form', [
                            'model' => $model,
                            'translation_name'=>$translation_name,
                        ]),
                        'footer'=> Html::button(Yii::t('app','Close'),['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                    Html::button(Yii::t('app','Save'),['class'=>'btn btn-primary','type'=>"submit"])
                    ];        
        }else{           
            return [
                'title'=> Yii::t('app','Create'),
                'content'=>$this->renderAjax('_add_sub_category_form', [
                    'model' => $model,
                    'translation_name'=>$translation_name,

                ]),
                'footer'=> Html::button('Закрыть',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
            ];
        }
    }

  
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if($request->isAjax){
           
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            
            return $this->redirect(['index']);
        }


    }
     public function actionDeleteSub($id)
    {
        $request = Yii::$app->request;
        SubCategories::findOne($id)->delete();

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
   
    public function actionBulkDelete()
    {        
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); 
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if($request->isAjax){
            
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
           
            return $this->redirect(['index']);
        }
       
    }

    protected function findModel($id)
    {
        if (($model = Categories::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
