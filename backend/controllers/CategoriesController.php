<?php

namespace backend\controllers;

use Yii;
use backend\models\Categories;
use backend\models\CategoriesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use backend\models\SubCategories;
use yii\web\HttpException;

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
        $model = new Categories();  

        if($request->isAjax){
            
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load($request->post()) && $model->save()){
                return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];         
            }else{           
                return [
                    'title'=> "Создать",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }
        }else{
           
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
       
    }

   
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);       

        if($request->isAjax){
           
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load($request->post()) && $model->save()){
                return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];    
            }else{
                 return [
                    'title'=> "Изменить",
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }else{
           
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    public function actionAddSubCategory($id)
    {
        $request = Yii::$app->request;
        $model = new SubCategories();
        $model->category_id = $id;

        Yii::$app->response->format = Response::FORMAT_JSON;
        if($model->load($request->post()) && $model->save()){
            return [
                'forceReload'=>'#crud-datatable-pjax',
                'title'=> "Суб-категория",
                'content'=>'<span class="text-success">Успешно выпольнено</span>',
                'forceClose'=>true,
            ];         
        }else{           
            return [
                'title'=> "Создать",
                'content'=>$this->renderAjax('_add_sub_category_form', [
                    'model' => $model,
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

        Yii::$app->response->format = Response::FORMAT_JSON;
        if($model->load($request->post()) && $model->save()){
            return [
                'forceReload'=>'#crud-datatable-pjax',
                'title'=> "Суб-категория",
                'content'=>'<span class="text-success">Успешно выпольнено</span>',
                'forceClose'=>true,
            ];         
        }else{           
            return [
                'title'=> "Создать",
                'content'=>$this->renderAjax('_add_sub_category_form', [
                    'model' => $model,
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
