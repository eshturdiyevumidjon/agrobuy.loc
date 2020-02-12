<?php
 
namespace api\modules\v1\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use api\modules\v1\models\Users;
use api\modules\v1\models\User;


class AppController extends \yii\rest\ActiveController
{ 	        
    public $modelClass = 'api\modules\v1\models\Users';
    public $enableCsrfValidation = false;

    public function init()
    {
        parent::init();
        \Yii::$app->user->enableSession = false;
    }

	public function behaviors()
	{
		$behaviors = parent::behaviors();
		$behaviors['authenticator'] = [
           'class'       => CompositeAuth::className(),
            'authMethods' => [
                \yii\filters\auth\HttpBearerAuth::className(),
            ],
         ];
        // remove authentication filter
        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);
		// add CORS filter
		$behaviors['corsFilter'] = [
			'class' => \yii\filters\Cors::className(),
			'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
            ],
		];

        // re-add authentication filter
        $behaviors['authenticator'] = $auth;
        // avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
        $behaviors['authenticator']['except'] = [
            'options',
            'restore-password',
            'change-password',
            'privacy',
            'send',
            'user-info'
        ];

        $behaviors[ 'access'] = [
            'class' =>  AccessControl::className(),
            //'only' => ['login', 'cabinet'],
            'rules' => [
                [
                    'allow' => true,
                    'actions'=>['user-info', 'send'],
                    'roles' => ['?'],
                ],                
                [
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ];
        
		return $behaviors;
	}
    
	public function actions()
    {
		$actions = parent::actions();
		unset($actions['create']);
		unset($actions['update']);
		unset($actions['delete']);
		unset($actions['view']);
		unset($actions['index']);
		return $actions;
	}

 //    // gruppa yaratish 1-qadam
 //    public function actionCreateGroup($page=0)
 //    {
 //        $body = Yii::$app->getRequest()->getBodyParams();
 //        $model = new Groups();
 //        $model->load(Yii::$app->getRequest()->getBodyParams(), '');

 //        $ids = ArrayHelper::getColumn(GroupsUser::find()->where(['user_id'=>Yii::$app->user->identity->id])->all(),'group_id');
 //        $query = Groups::find()->where(['!=','id',$ids]);

 //        $query->andFilterWhere([
 //            'category_id'=>$model->category_id,
 //            'subcategory_id'=>$model->subcategory_id,
 //            'region_id'=>$model->region_id,
 //            'district_id'=>$model->district_id
 //        ]);
 //        $groups = Groups::getGroupsListInCreateGroup($page,$query);

        
 //        // $query->andFilterWhere(['like', 'name', $this->name])
 //        //     ->andFilterWhere(['like', 'key', $this->key]);
        
 //        return $groups;
 //        // $groups = $query->all();
 //        // if ($model->validate()) {
 //        //     return [
 //        //         'model' => $model,
 //        //         'groups' => $groups,
 //        //     ];
 //        // }
 //        // else {
 //        //     throw new HttpException(422, json_encode($model->errors, JSON_UNESCAPED_UNICODE));
 //        // }
 //    }

 //    //gruppa yaratish 2-qadam o'zi alohida gruppa sozdat qilish
 //    public function actionCreateOwn()
 //    {
 //        $body = Yii::$app->getRequest()->getBodyParams();
 //        $model = new Groups();
 //        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
 //        if ($model->validate()) {
 //            $tags = explode(',',$model->tags);
 //            $str = [];
 //            foreach ($tags as $key => $value) {
 //                if(Tags::findOne($value)){
 //                    $str[] = $value;
 //                }else{
 //                    $new_tag = new Tags();
 //                    $new_tag->name = $value;
 //                    $new_tag->save();
 //                    $str[] = $new_tag->id;
 //                }
 //            }
 //            $model->tags = implode(',',$str);
 //            $model->save();
 //            $group_user = new GroupsUser();
 //            $group_user->user_id = Yii::$app->user->identity->id;
 //            $group_user->group_id = $model->id;
 //            $group_user->date_cr = Yii::$app->formatter->asDate(time(),'php: Y-m-d H:i');
 //            $group_user->save();
 //            $response = \Yii::$app->getResponse();
 //            $response->setStatusCode(202);
 //            return 
 //            [
 //                'id' => $model->id,
 //                'name' => $model->name,
 //                'type' => $model->type,
 //                'typeName' => $model->getTypeDescription(),
 //                'address' => $model->region->name . " " . $value->district->name,
 //                'category' => $model->category->name,
 //                'subcategory' => $model->subcategory->name,
 //                'desc' => $model->text,
 //                'startTime' => $model->begin_time,
 //                'endTime' => $model->end_time,
 //                'tags' => $model->tags,
 //                'week_days' => $model->week_days,
 //            ];
 //        }
 //        else {
 //            throw new HttpException(422, json_encode($model->errors, JSON_UNESCAPED_UNICODE));
 //        }
 //    }
    
 //    //gruppa yaratish 2-qadam bor biror guruhga qo'shilish
 //    public function actionJoinGroup()
 //    {
 //        $group_id = Yii::$app->getRequest()->getBodyParams()['group_id'];
 //        $group_user = new GroupsUser();
 //        $group_user->user_id = Yii::$app->user->identity->id;
 //        $group_user->group_id = $group_id;
 //        $group_user->date_cr = Yii::$app->formatter->asDate(time(),'php: Y-m-d H:i');
 //        if($group_user->save()){
 //            $group_user->group_id = (integer)$group_user->group_id;
 //            return $group_user;
 //        }else{
 //            throw new HttpException(422, json_encode($group_user->errors, JSON_UNESCAPED_UNICODE));
 //        }
 //    }

 //    //gruppadan chiqib ketish
 //    public function actionLeaveGroup()
 //    {
 //        $group_id = Yii::$app->getRequest()->getBodyParams()['group_id'];
 //        $user_id = Yii::$app->user->identity->id;

 //        $group_user = GroupsUser::find()->where(['user_id'=>$user_id,'group_id'=>$group_id])->one();
 //        if($group_user){
 //            $group_user->delete();
 //            $response = \Yii::$app->getResponse();
 //            $response->setStatusCode(202);
 //            $responseData = ['status' => true];
 //            return $responseData;
 //        }
 //    }

 //    //a'zo bo'lgan gruppalarning ro'yhati
 //    public function actionJoinedGroupsList($page = 0)
 //    {
 //        return Groups::getGroupsList($page, $is_me = 1);
 //    }

 //    //kursga qo'shilish
 //    public function actionJoinCourse()
 //    {
 //        $id = Yii::$app->getRequest()->getBodyParams()['courseId'];
 //        $model = new CourseUser();
 //        $model->user_id = Yii::$app->user->identity->id;
 //        $model->course_id = $id;
 //        $model->date_cr = Yii::$app->formatter->asDate(time(),'php: Y-m-d H:i');
 //        $model->save();
 //        $response = \Yii::$app->getResponse();
 //        $response->setStatusCode(202);
 //        return $model;
 //    }

 //    //a'zo bo'lgan kurslar ro'yhati
 //    public function actionJoinedCoursesList()
 //    {
 //        $id = Yii::$app->user->identity->id;
 //        $user_courses = CourseUser::find()->where(['user_id'=>$id])->all();

 //        $groups_id = \yii\helpers\ArrayHelper::getColumn($user_courses,'group_id');
 //        $courses = Courses::find()->where(['id'=>$groups_id])->all();
 //        $array = [];
 //        foreach ($courses as $value) {
 //            $array [] = [
 //                'id' => $value->id,
 //                'companyId' => $value->company_id,
 //                'name' => $value->name,
 //                'userCount' => $value->user_count,
 //                'description' => $value->text,
 //            ];
 //        }
 //        return $array;
 //    }
	
	// //advertising kelish kelmasligi    
 //    public function actionCheckAdvertising()
 //    {
 //    	$user = Yii::$app->user->identity;
 //        $check_advertising = Yii::$app->getRequest()->getBodyParams()['check_advertising'];

 //        $user->chek_advertising = $check_advertising;
 //        $user->save(false);

 //        $response = \Yii::$app->getResponse();
 //        $response->setStatusCode(202);

 //        return ['answer'=>'ok'];
 //    }

 //    //tilni o'zgartirish
 //    public function actionChangeLanguage()
 //    {
 //    	$user = Yii::$app->user->identity;
 //        $languages_id = Yii::$app->getRequest()->getBodyParams()['languages_id'];

 //        $user->language_id = $languages_id;
 //        $user->save(false);

 //        $response = \Yii::$app->getResponse();
 //        $response->setStatusCode(202);

 //        return ['answer'=>'ok'];
 //    }

 //    //change profil
 //    public function actionChangeProfil()
 //    {
 //    	$user = Yii::$app->user->identity;
 //        $languages_id = Yii::$app->getRequest()->getBodyParams()['languages_id'];
 //        $userFIO = Yii::$app->getRequest()->getBodyParams()['userFIO'];
 //        $userPhone = Yii::$app->getRequest()->getBodyParams()['userPhone'];

 //        $user->fio = $userFIO;
 //        $user->phone = $userPhone;
	//     $user->language_id = $languages_id;
 //        $user->save(false);

 //        $response = \Yii::$app->getResponse();
 //        $response->setStatusCode(202);

 //        return $user->getUsersMinValues();
 //    }

 //    public function actionSaveFirebaseToken()
 //    {
 //    	$user = Yii::$app->user->identity;
 //        $token = $user->access_token;
 //        $firebaseToken = Yii::$app->getRequest()->getBodyParams()['fireBaseToken'];

 //        $user = Users::find()->where(['access_token'=>$token])->one();
 //        $user->firebase_token = $firebaseToken;

 //        $user->save(false);
 //        $response = \Yii::$app->getResponse();

 //        $response->setStatusCode(202);

 //        return $user->getUsersMinValues();
 //    }

 //    public function actionSendAdvertising()
 //    {
    	
 //    }

 //    public function actionNewAlertCount()
 //    {
 //        return (integer)Alerts::find()->where(['user_id' => Yii::$app->user->identity, 'status' => 1 ])->count();
 //    }

 //    public function actionNewChatMessagesCount()
 //    {
 //        return (integer)ChatMessage::find()->where(['user_id' => Yii::$app->user->identity, 'is_read' => 0 ])->count();
 //    }
}