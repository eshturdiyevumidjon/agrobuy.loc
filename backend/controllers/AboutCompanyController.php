<?php

namespace backend\controllers;

use Yii;
use backend\models\AboutCompany;
use backend\models\AboutCompanySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\web\UploadedFile;

class AboutCompanyController extends Controller
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
        ];
    }

    public function actionChangeLogo()
    {
        $path = 'uploads/about-company/';  
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

    
    public function actionView($id = null)
    {    
        $model = AboutCompany::findOne($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);       

        if($request->isAjax){
           
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load($request->post()) && $model->save()){
                $model->image = UploadedFile::getInstance($model, 'image');
                $model->upload();
                return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];    
            }else{
                 return [
                    'title'=> "Изменить",
                    'size'=>"large",
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

    protected function findModel($id)
    {
        if (($model = AboutCompany::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
