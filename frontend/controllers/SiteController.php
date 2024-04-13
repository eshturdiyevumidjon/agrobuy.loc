<?php
namespace frontend\controllers;

use Yii;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;
use yii\base\InvalidArgumentException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\widgets\ActiveForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\Sessions;
use frontend\models\RecoveryForm;
use frontend\models\PasswordForm;
use frontend\models\CodeForm;
use backend\models\Banners;
use backend\models\Settings;
use backend\models\News;
use backend\models\AdvertisingItems;
use backend\models\UsersBall;
use common\models\Category;
use common\models\Ads;
use common\models\UsersPromotion;
use common\models\Favorites;
use common\models\AdsSearch;
use common\models\Users;
use common\models\LoginFormUser;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $session = new Sessions();
        $adv = $session->getMainAdv();
        $news = News::getAllNewsList();
        $trustedAds = UsersBall::getTrustedAds();
        $about_company = $session->getCompany();
        $banners = Banners::getAllBannersList();
        $categories = Category::getAllCategoryList();
        $favorites = Favorites::find()->where(['type' => 1])->all();
        $districts = $session->getAreaList();

        $premiumAds = Ads::find()
            ->joinWith(['category', 'user', 'currency'])
            ->where(['ads.premium' => 1])
            ->andWhere(['ads.status' => 1])
            ->limit(8)
            ->orderBy(['rand()' => SORT_DESC])
            ->all();

        $reklama = AdvertisingItems::find()
            ->joinWith('advertising')
            ->where(['advertising_id' => $adv->id])
            ->orderBy(['rand()' => SORT_DESC])
            ->all();

        foreach ($reklama as $value) {
            $value->view_count = $value->view_count + 1;
            $value->save();
        }

        $newAds = Ads::find()
            ->joinWith(['category', 'currency'])
            ->where(['ads.status' => 1])
            ->limit(4)
            ->orderBy(['date_cr' => SORT_DESC, 'id' => SORT_DESC])
            ->all();

        return $this->render('index', [
            'banners' => $banners,
            'districts' => $districts,
            'about_company' => $about_company,
            'categories' => $categories,
            'news' => $news,
            'reklama' => $reklama,
            'newAds' => $newAds,
            'premiumAds' => $premiumAds,
            'favorites' => $favorites,
            'trustedAds' => $trustedAds,
            'nowLanguage' => Yii::$app->language,
        ]);
    }

    public function actionFavoriteAdd($id, $type)
    {
        $fav = Favorites::find()->where([ 'field_id' => $id, 'type' => $type])->one();
        if($fav != null) $fav->delete();
        else {
            $fav = new Favorites();
            $fav->user_id = Yii::$app->user->identity->id;
            $fav->type = $type;
            $fav->field_id = $id;
            $fav->save();
        }
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        $session = new Sessions();
        $request = Yii::$app->request;
        $model = new LoginFormUser();
        $about_company = $session->getCompany();
        $siteName = Yii::$app->params['siteName'];

        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/backend/web/uploads/about-company/' . $about_company->logo)) {
            $path = $siteName . '/backend/web/img/no-logo.png';
        } else {
            $path = $siteName . '/backend/web/uploads/about-company/' . $about_company->logo;
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if($model->load($request->post()) && $model->validate() ) {
            $user = Users::find()->where(['login' => $model->username])->one();
            if($user != null && $user->access == 1) {
                $model->login();
                return $this->goBack();
            } else {
                throw new HttpException(403, $user->access_comment);
            }
        }
        else {
            return $this->renderAjax('login', [
                'model' => $model,
                'path' => $path,
                'nowLanguage' => Yii::$app->language,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $request = Yii::$app->request;
        $model = new SignupForm();
        $session = new Sessions();
        $about_company = $session->getCompany();
        $siteName = Yii::$app->params['siteName'];

        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/backend/web/uploads/about-company/' . $about_company->logo)) {
            $path = $siteName . '/backend/web/img/no-logo.png';
        } else {
            $path = $siteName . '/backend/web/uploads/about-company/' . $about_company->logo;
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if($model->load($request->post()) && $model->validate() && $model->signup()){

            $user = Users::find()->where(['phone' => $model->phone])->one();
            $code = rand(100000,999999);
            $user->access = 3;
            $user->code_for_phone = '' . $code;
            if($user->save(false)) {
                $phone = str_replace('+', '', $user->phone);
                $phone = str_replace('-', '', $phone);
                $phone = str_replace(' ', '', $phone);
                $result = $user->sendSms($phone, $user->code_for_phone, $user->getSmsAccessToken());
            }

            return $this->redirect(['/site/code']);

            $loginForm = new LoginFormUser();
            $loginForm->username = $model->login;
            $loginForm->password = $model->password;
            $loginForm->validate();
            $loginForm->login();

            if($loginForm->validate() && $loginForm->login() ) {
                return $this->redirect(['/profile']);
            } else {
                return $this->renderAjax('signup', [
                    'model' => $model,
                    'path' => $path,
                    'nowLanguage' => Yii::$app->language,
                ]);
            }
        } else {
            return $this->renderAjax('signup', [
                'model' => $model,
                'path' => $path,
                'nowLanguage' => Yii::$app->language,
            ]);
        }
    }

    public function actionCode()
    {
        $request = Yii::$app->request;
        $model = new CodeForm();
        $session = new Sessions();
        $about_company = $session->getCompany();
        $siteName = Yii::$app->params['siteName'];

        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/backend/web/uploads/about-company/' . $about_company->logo)) {
            $path = $siteName . '/backend/web/img/no-logo.png';
        } else {
            $path = $siteName . '/backend/web/uploads/about-company/' . $about_company->logo;
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if($model->load($request->post()) && $model->validate()) {

            $user = Users::find()->where(['code_for_phone' => $model->code])->one();
            $user->code_for_phone = null;
            $user->access = 1;
            $user->save(false);

            $loginForm = new LoginFormUser();
            $loginForm->username = $user->login;

            if($loginForm->login2() ) {
                return $this->redirect(['/profile']);
            } else {
                return $this->render('code', [
                    'model' => $model,
                ]);
            }

        } else {
            return $this->render('code', [
                'model' => $model,
            ]);
        }
    }

    public function actionSearch()
    {
        $request = Yii::$app->request;
        $session = new Sessions();
        $get = null;
        $dataProvider = null;
        $getModels = null;
        $search_big = $session->getSearchBigAdv();
        $search_small = $session->getSearchSmallAdv();
        $districts = $session->getAreaList();
        $categories = Category::getAllCategoryList();
        $about_company = $session->getCompany();
        $favorites = Favorites::find()->where(['type' => 1])->all();
        $siteName = Yii::$app->params['siteName'];
        $adsPagination = Yii::$app->params['adsPagination'];

        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/backend/web/uploads/about-company/' . $about_company->logo)) {
            $path = $siteName . '/backend/web/img/no-logo.png';
        } else {
            $path = $siteName . '/backend/web/uploads/about-company/' . $about_company->logo;
        }


        $reklamaBig = AdvertisingItems::find()
            ->joinWith('advertising')
            ->where(['advertising_id' => $search_big->id])
            ->orderBy(['rand()' => SORT_DESC])
            ->all();

        foreach ($reklamaBig as $value) {
            $value->view_count = $value->view_count + 1;
            $value->save();
        }

        $reklamaSmall = AdvertisingItems::find()
            ->joinWith('advertising')
            ->where(['advertising_id' => $search_small->id])
            ->orderBy(['rand()' => SORT_DESC])
            ->all();

        foreach ($reklamaSmall as $value) {
            $value->view_count = $value->view_count + 1;
            $value->save();
        }

        $cat = null; $dist = null; $sub = null;
        if($request->get()){
            $get = $request->get();
            $searchModel = new AdsSearch();
            $dataProvider = $searchModel->filtr($get);
            $dataProvider->pagination = ['pageSize' => $adsPagination,];
            $getModels = $dataProvider->getModels();
            if(isset($get['category'])) $cat = $get['category'];
            if(isset($get['sub'])) $sub = $get['sub'];
            if(isset($get['district'])) $dist = $get['district'];
        }

        return $this->render('search', [
            // 'model' => $model,
            'get' => $get,
            'dist' => $dist,
            'cat' => $cat,
            'sub' => $sub,
            'session' => $session,
            'getModels' => $getModels,
            'path' => $path,
            'districts' => $districts,
            'favorites' => $favorites,
            'categories' => $categories,
            'reklamaBig' => $reklamaBig,
            'dataProvider' => $dataProvider,
            'reklamaSmall' => $reklamaSmall,
            'nowLanguage' => Yii::$app->language,
        ]);
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionRecoveryPassword()
    {
        $request = Yii::$app->request;
        $model = new RecoveryForm();
        $session = new Sessions();
        $about_company = $session->getCompany();
        $siteName = Yii::$app->params['siteName'];

        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/backend/web/uploads/about-company/' . $about_company->logo)) {
            $path = $siteName . '/backend/web/img/no-logo.png';
        } else {
            $path = $siteName . '/backend/web/uploads/about-company/' . $about_company->logo;
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if($model->load($request->post()) && $model->validate()){
            $user = Users::find()->where(['phone' => $model->phone])->one();
            $code = rand(100000,999999);
            $user->code_for_phone = '' . $code;
            if($user->save(false)) {
                $phone = str_replace('+','', $user->phone);
                $phone = str_replace('-','', $phone);
                $phone = str_replace(' ','', $phone);
                $result = $user->sendSms($phone, $user->code_for_phone, $user->getSmsAccessToken());
            }

            return $this->redirect(['/site/password']);
        } else {
            return $this->renderAjax('recovery-password', [
                'model' => $model,
                'path' => $path,
                'nowLanguage' => Yii::$app->language,
            ]);
        }
    }

    public function actionPassword()
    {
        $request = Yii::$app->request;
        $model = new PasswordForm();
        $session = new Sessions();
        $about_company = $session->getCompany();
        $siteName = Yii::$app->params['siteName'];

        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/backend/web/uploads/about-company/' . $about_company->logo)) {
            $path = $siteName . '/backend/web/img/no-logo.png';
        } else {
            $path = $siteName . '/backend/web/uploads/about-company/' . $about_company->logo;
        }

        if($model->load($request->post()) && $model->validate()){

            $user = Users::find()->where(['code_for_phone' => $model->code])->one();
            $user->new_password = $model->password;
            $user->code_for_phone = null;
            $user->save();
            
            $loginForm = new LoginFormUser();
            $loginForm->username = $user->login;
            $loginForm->password = $model->password;

            if($loginForm->validate() && $loginForm->login() ) {
                return $this->redirect(['/profile']);
            } else {
                return $this->render('password', [
                    'model' => $model,
                ]);
            }

        } else {
            return $this->render('password', [
                'model' => $model,
            ]);
        }
    }

    public function actionPrivacy($key)
    {
        $session = new Sessions();
        $privacy = Settings::find()->where(['key' => $key])->one();

        return $this->render('privacy', [
            'privacy' => $privacy,
            'nowLanguage' => Yii::$app->language,
        ]);
    }
}
