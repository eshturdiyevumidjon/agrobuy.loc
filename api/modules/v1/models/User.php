<?php

namespace api\modules\v1\models;

class User extends Users/*\yii\base\Object*/ implements \yii\web\IdentityInterface
{
    const EXPIRE_TIME = 3600*24;
 
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /*public static function findIdentityByAccessToken($token, $type = null)
    {
        //throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
        $user = static::find()->where(['access_token' => $token])->one();
        if (!$user) {
            return false;
        }
        if ($user->expiret_at < time()) {
           throw new UnauthorizedHttpException('the access - token expired ', -1);
        } else {
            return $user;
        }
    }*/

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['login' => $username]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return false;
    }


    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
       return \Yii::$app->security->validatePassword($password, $this->password);
    }
    public function getFIO()
    {
        if($this->type == 2) {
            $userFIO = $this->org_name;
        }
        else{
            $userFIO = $this->fio;
        }
        return $userFIO;
    }
}
