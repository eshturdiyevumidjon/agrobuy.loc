<?php

namespace backend\controllers;

use Yii;
use backend\models\Lang;
use backend\models\LangSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\web\UploadedFile;
use backend\models\CompanyLanguage;

/**
 * LanguageController implements the CRUD actions for Lang model.
 */
class LanguageController extends Controller
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
     * Lists all Lang models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new LangSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionChange($id)
    {
        $model=$this->findModel($id);
        if($model->status==1)
            {
                $status=0;
                Yii::$app->language='ru';
            }
        if($model->status==0)
            {
                $status=1;
            }

        if(Yii::$app->language==$model->url)
            Yii::$app->language='ru';
        
        Yii::$app->db->createCommand()->update('lang', ['status' => $status], [ 'id' => $model->id ])->execute();
        return $this->redirect(['index']);
    }

    public function actionChangeValues()
    {
        $id = $_POST['id'];
        $model = Lang::findOne($id);
        if($model->status == 0) {$model->status = 1;}
        else {$model->status = 0;}
        $model->save();
    }

    public function actionChangeValuesCompany()
    {   
        $user = Yii::$app->user->identity;
        $id = $_POST['id'];
        $model = CompanyLanguage::find()
            ->where(['language_id' => $id,'company_id'=>$user->company_id])->one();
        if($model->status == 1) {   $model->status = 0; }
        else {
            $model->status = 1;
        }
        $model->save();
    }

    /**
     * Displays a single Lang model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> Yii::t('app','Language'),
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('Ёпиш',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Ўзгартириш',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new Lang model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
     public function actionCreate()
    {
       $request = Yii::$app->request;
       $model = new Lang(); 
       $model->create = 1;
       if($request->isAjax){
           /*
           *  Process for ajax request
           */
           Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load($request->post()) && $model->save()){
               $src = \common\modules\translations\models\SourceMessage::find()->all();
                foreach ($src as $value) {
                   Yii::$app->db->createCommand()->insert('message', ['id' => $value->id,'language'=>$model->url])->execute();
                }
               $model->flag = UploadedFile::getInstance($model,'flag');
                if(!empty($model->flag))
                {
                    $model->flag->saveAs('uploads/flags/' . $model->id.'.'.$model->flag->extension);
                    Yii::$app->db->createCommand()->update('lang', ['image' =>'/uploads/flags/'. $model->id.'.'.$model->flag->extension], [ 'id' => $model->id ])->execute();
                }
               return [
                   'forceReload'=>'#crud-datatable-pjax',
                   'title'=> Yii::t('app','Create'),
                   'content'=>'<span class="text-success">'.Yii::t('app','Complete successfully').'</span>',
                   'footer'=> Html::button('Ёпиш',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                           Html::a('Яна яратиш',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
       
               ];       
           }else{         
               return [
                   'title'=> "Яратиш",
                   'content'=>$this->renderAjax('create', [
                       'model' => $model,
                   ]),
                   'footer'=> Html::button('Ёпиш',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                               Html::button('Сақлаш',['class'=>'btn btn-primary','type'=>"submit"])
       
               ];       
           }
       }else{
           /*
           *  Process for non-ajax request
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
     * Updates an existing Lang model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);       

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load($request->post()) && $model->save()){
                $model->flag = UploadedFile::getInstance($model,'flag');
                if(!empty($model->flag))
                {
                    if($model->image!=null&&file_exists('uploads/flags/'.$model->image))
                    {
                        unlink(('uploads/flags/'.$model->image));
                    }
                    $model->flag->saveAs('uploads/flags/' . $model->id.'.'.$model->flag->extension);
                    Yii::$app->db->createCommand()->update('user', ['image' =>'/uploads/flags/'. $model->id.'.'.$model->flag->extension], [ 'id' => $model->id ])->execute();
                }
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Тил",
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Ёпиш',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Ўзгартириш',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> 'Ўзгартириш',
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Ёпиш',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сақлаш',['class'=>'btn btn-primary','type'=>"submit"])
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
     * Delete an existing Lang model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $model=$this->findModel($id);
        if(file_exists('uploads/flags/'.$model->image)&&$model->image!=null)
        {
            unlink('uploads/flags/'.$model->image);
        }        
       
        Yii::$app->db->createCommand()->delete('message', ['language'=>$model->url])->execute();
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
     * Delete multiple existing Lang model.
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
            if($model->image!=null&&file_exists('uploads/flags/'.$model->image))
            {
                unlink(('uploads/flags/'.$model->image));
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
     * Finds the Lang model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Lang the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Lang::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }}
