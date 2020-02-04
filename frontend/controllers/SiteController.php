<?php
namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use backend\models\Banners;
use common\models\Category;
use frontend\models\Sessions;
use backend\models\News;
use backend\models\AdvertisingItems;
use common\models\Ads;
use common\models\UsersPromotion;
use backend\models\UsersBall;
use yii\widgets\ActiveForm;
use common\models\Favorites;

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
        $usersID = UsersBall::getUsersList();
        $userID = UsersPromotion::getUsersID();
        $about_company = $session->getCompany();
        $banners = Banners::getAllBannersList();
        $categories = Category::getAllCategoryList();
        $favorites = Favorites::find()->where(['type' => 1])->all();
        $regions = $session->getRegionsList();

        $premiumAds = Ads::find()
            ->joinWith(['category', 'user', 'currency'])
            ->where(['in', 'users.id', $userID])
            ->limit(8)
            ->orderBy(['rand()' => SORT_DESC])
            ->all();

        $reklama = AdvertisingItems::find()
            ->where(['advertising_id' => $adv->id])
            ->orderBy(['rand()' => SORT_DESC])
            ->one();

        $newAds = Ads::find()
            ->joinWith(['category', 'currency'])
            ->limit(4)
            ->orderBy(['date_cr' => SORT_DESC, 'id' => SORT_DESC])
            ->all();

        $trustedAds = Ads::find()
            ->joinWith(['category', 'user', 'currency'])
            ->where(['in', 'users.id', $usersID])
            ->limit(4)
            ->orderBy(['rand()' => SORT_DESC])
            ->all();

        return $this->render('index', [
            'banners' => $banners,
            'regions' => $regions,
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
        Yii::$app->user->logout();
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $session = new Sessions();
        $request = Yii::$app->request;
        $model = new LoginForm();
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

        if($model->load($request->post()) && $model->validate() && $model->login()){
            return $this->goBack();
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
        /*return $this->goHome();*/
        $session = new Sessions();
        $about_company = $session->getCompany();
        $siteName = Yii::$app->params['siteName'];
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/backend/web/uploads/about-company/' . $about_company->logo)) {
            $path = $siteName . '/backend/web/img/no-logo.png';
        } else {
            $path = $siteName . '/backend/web/uploads/about-company/' . $about_company->logo;
        }
        $request = Yii::$app->request;
        $model = new SignupForm();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if($model->load($request->post()) && $model->validate() && $model->signup()){
            return $this->goHome();
        }
        else {
            return $this->renderAjax('signup', [
                'model' => $model,
                'path' => $path,
                'nowLanguage' => Yii::$app->language,
            ]);
        }
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
                return $this->goHome();
            }
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }
}
