<?php

namespace backend\controllers;

use Yii;
use common\models\Users;
use common\models\UsersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\web\UploadedFile;

/**
 * UsersController implements the CRUD actions for Users model.
 */
class UsersController extends Controller
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
     * Lists all Users models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Users model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionChangeAvatar()
    {
        $path = 'uploads/avatars/';  
        $img = $_POST['name'];
        $tmp = $_FILES['file']['tmp_name'];

        $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
        if($user->image!=null&&file_exists($path.$img))
        {
            unlink(($path.$img));
        }
        $path = $path. $img; 
        if(move_uploaded_file($tmp,$path)) 
        {
        }
    }

    /**
     * Creates a new Users model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionChange($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);       

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load($request->post()) && $model->save()){
                
                return [
                    'forceClose' => true,
                    'forceReload'=>'#profile-pjax',
                ];    
            }else{
                 return [
                    'title'=> "Изменить",
                    'size' => "large",
                    'content'=>$this->renderAjax('change', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Отмена',['class'=>'btn btn-primary pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить',['class'=>'btn btn-info','type'=>"submit"])
                ];        
            }
        }
        else{
            echo "ddd";
        }
    }

    public function actionProfile()
    {
        $request = Yii::$app->request;
        return $this->render('profile', [
        ]);        
    }
    
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Users();  

        if ($model->load($request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } 
        else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
       
    }

    /**
     * Updates an existing Users model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionChangePersonal($id, $type)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        if($model->birthday != null) $model->birthday = date("d.m.Y", strtotime($model->birthday ));
        Yii::$app->response->format = Response::FORMAT_JSON;
        if($model->load($request->post()) && $model->save()){
            $model->image = UploadedFile::getInstance($model, 'image');
            $model->upload();
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];    
        }
        else{
            $fileName = '';
            if($type == 1) $fileName = 'forms/personal';
            if($type == 2) $fileName = 'forms/legal';
            if($type == 3) $fileName = 'forms/passport';
            if($type == 4) $fileName = 'forms/fiz_yur';
            if($type == 5) $fileName = 'forms/request';
            return [
                 'title'=> "Изменить пользователя",
                 'size' =>'large',
                 'content'=>$this->renderAjax($fileName, [
                     'model' => $model,
                 ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
    }

    /**
     * Delete an existing Users model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        if ($id != 1)$model = Users::findOne($id);
        if(file_exists('uploads/avatars/'.$model->avatar )&&$model->avatar != null)
        {
            unlink('uploads/avatars/'.$model->avatar );
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
     * Delete multiple existing Users model.
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
            if(file_exists('uploads/avatars/'.$model->avatar )&&$model->avatar != null)
            {
                unlink('uploads/avatars/'.$model->avatar );
            }
            if($pk !=1)$model->delete();
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
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
