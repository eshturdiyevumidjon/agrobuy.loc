<?php

namespace common\models;

use Yii;
use backend\base\AppActiveQuery;
use yii\behaviors\BlameableBehavior;
use yii\web\ForbiddenHttpException;
use backend\models\Companies;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use backend\models\UsersBall;
use backend\models\Reyting;
use backend\models\UsersReyting;

class Users extends \yii\db\ActiveRecord
{
    public $new_password;
    public $image;
    public $passport_image;
    public $imageFiles;
    public $company_image;
    const EXPIRE_TIME = 3600 * 24 * 7;
    const DIR_NAME_FOR_UPLOADING_PASSPORT_FILES = '/admin/uploads/users/passports/';
    const DIR_NAME_FOR_UPLOADING_COMPANIES_FILES = '/admin/uploads/users/companies/';
    const TEMP_DIR_NAME = '/admin/uploads/ads_trash/';

    public static function tableName()
    {
        return 'users';
    }

    public function rules()
    {
        return [
            [['type', 'expiret_at', 'legal_status', 'check_phone', 'check_mail', 'check_passport', 'check_car', 'access'], 'integer'],
            [['balance'], 'number'],
            [['birthday', 'last_seen'], 'safe'],
            [['email'], 'email'],
            [['login', 'phone'], 'unique'],
            [['login', 'type', 'phone'], 'required'],
            [['inn'], 'string', 'min' => 9],
            ['password', 'required', 'when' => function($model) {return $this->isNewRecord;}, 'enableClientValidation' => false],
            [['image'], 'safe'],
            [['company_files', 'passport_issue', 'access_comment'], 'string'],
            [['login', 'password', 'fio', 'avatar', 'phone', 'email', 'access_token', 'user_number', 'instagram', 'facebook', 'telegram', 'company_name', 'passport_serial_number', 'passport_number', 'passport_date', 'passport_file', 'code_for_phone', 'web_site', 'new_password'], 'string', 'max' => 255],
            [['access_comment'], 'required', 'when' => function($model) {return $this->access == 2;}, 'enableClientValidation' => false],
            // [['passport_image', 'company_image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxFiles' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'login' => 'Логин',
            'fio' => 'Ф.И.О',
            'last_seen' => 'last_seen',
            'password' => 'Пароль',
            'avatar' => 'Аватар',
            'phone' => 'Телефон',
            'type' => 'Должность',
            'email' => Yii::t('app', 'E-mail'),
            'balance' =>'Баланс',
            'access' => 'Доступ',
            'access_token' => Yii::t('app', 'Access Token'),
            'expiret_at' =>'Время окончание токена',
            'user_number' => 'ID номер',
            'instagram' => Yii::t('app', 'Instagram'),
            'facebook' => Yii::t('app', 'Facebook'),
            'telegram' => Yii::t('app', 'Telegram'),
            'birthday' =>'Дата рождение',
            'company_name' => 'Название компании',
            'company_files' => 'Файлы компании',
            'legal_status' =>'Юридический статус',
            'inn' => 'ИНН',
            'web_site' => Yii::t('app', 'Web Site'),
            'passport_serial_number' =>'Серия паспорта',
            'passport_number' =>'Номер паспорта',
            'passport_date' => 'Дата паспорта',
            'passport_issue' => 'Кем выдан',
            'passport_file' =>'Файл паспорта',
            'check_phone' =>'Проверка телефона',
            'check_mail' =>'Проверка почту',
            'check_passport' =>'Проверка паспорта',
            'check_car' =>'Проверка машины',
            'code_for_phone' => 'Смс код',
            'passport_image' => 'Картинка паспорта',
            'company_image' => 'Файлы компании',
            'new_password' => 'Новый пароль',
            'access_comment' => "Текст заблокировки",
            'is_checked' => 'Проверено или нет',
        ];
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->balance = 0;
            $this->access = 1;
            $this->password = Yii::$app->security->generatePasswordHash($this->password);
            $this->access_token = Yii::$app->getSecurity()->generateRandomString();
            $this->expiret_at = time() + $this::EXPIRE_TIME;
        }

        if($this->new_password != null) $this->password = Yii::$app->security->generatePasswordHash($this->new_password);
        if($this->birthday != null) $this->birthday = date("Y-m-d", strtotime($this->birthday ));
        if($this->passport_date != null) $this->passport_date = date("Y-m-d", strtotime($this->passport_date ));
        
        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        if($this->birthday != null) $this->birthday = date("d.m.Y", strtotime($this->birthday ));
        if($this->passport_date != null) $this->passport_date = date("d.m.Y", strtotime($this->passport_date ));
        
        return parent::afterFind();
    }

    public function afterSave($insert, $changedAttributes)
    {
        if($insert){
            if($this->type == 3){
                $chat = new Chats();
                $chat->name = 'chat_'.$this->id;
                $chat->date_cr = Yii::$app->formatter->asDate(time(),'php: Y-m-d H:i');
                $chat->type = 1;
                $chat->save();

                $chat1 = new ChatUsers();
                $chat2 = new ChatUsers();
                
                $chat1->chat_id = $chat->id;
                $chat2->chat_id = $chat->id;
                $chat1->date_cr = Yii::$app->formatter->asDate(time(),'php: Y-m-d H:i');
                $chat2->date_cr = Yii::$app->formatter->asDate(time(),'php: Y-m-d H:i');
                $chat1->user_id = 1;
                $chat2->user_id = $this->id;

                $chat1->save();
                $chat2->save();

                $chatMessage = new ChatMessage();
                $chatMessage->chat_id = $chat->id;
                $chatMessage->user_id = 1;
                $chatMessage->message = '"Поздравляем! Вы успешно зарегистрировались на лучшей онлайн платформе куплепродажи в аграрной сфере. Это чат техподдержки. В случае технических неполадок Вы можете направлять сюда Ваши письма. Команда наших модераторов ответит на Ваше письмо в течении 2 рабочих дней. Так же в данный чат будут приходить рассылки и различные объявления от нашей администрации. Благодарим Вас то что выбрали нас. Удачи. С уважением команда Agrobuy.uz."';
                $chatMessage->save();
            }
        } // else qismi reytingni hisoblash uchun kerak
        else {
            $reyting = Reyting::find()->where(['key' => 'profile_fullness'])->one();
            $userReyting = UsersReyting::find()
                ->joinWith(['reyting'])
                ->where(['user_id' => $this->id, 'reyting_id' => $reyting->id])
                ->one();
            $isFull = $this->getIsFull();
            //echo "f=".$isFull;die;
            if($userReyting != null) {
                if($isFull < $reyting->value) $userReyting->delete();
            }
            else {
                if($isFull >= $reyting->value) {
                    $userReyting = new UsersReyting();
                    $userReyting->user_id = $this->id;
                    $userReyting->reyting_id = $reyting->id;
                    $userReyting->ball = $reyting->ball;
                    $userReyting->save();
                }
            }
        }
        parent::afterSave($insert, $changedAttributes);
    }
    
    /**
     * @return bool
     */

    public function beforeDelete()
    {
        return parent::beforeDelete();
    }

    public function getAvatar()
    {
        if (!file_exists('uploads/avatars/'.$this->avatar) || $this->avatar == '') {
            $path = 'https://' . $_SERVER['SERVER_NAME'].'/admin/img/nouser.png';
        } else {
            $path = 'https://' . $_SERVER['SERVER_NAME'].'/admin/uploads/avatars/'.$this->avatar;
        }
        return $path;
    }

    public function getIsFull()
    {
        $allCount = 21; $count = 21;
        if($this->fio == null || $this->fio == '') $count--;
        if($this->avatar == null || $this->avatar == '') $count--;
        if($this->phone == null || $this->phone == '') $count--;
        if($this->email == null || $this->email == '') $count--;
        if($this->instagram == null || $this->instagram == '') $count--;
        if($this->facebook == null || $this->facebook == '') $count--;
        if($this->telegram == null || $this->telegram == '') $count--;
        if($this->birthday == null || $this->birthday == '') $count--;
        if($this->company_name == null || $this->company_name == '') $count--;
        if($this->legal_status == null || $this->legal_status == '') $count--;
        if($this->inn == null || $this->inn == '') $count--;
        if($this->web_site == null || $this->web_site == '') $count--;
        if($this->passport_serial_number == null || $this->passport_serial_number == '') $count--;
        if($this->passport_number == null || $this->passport_number == '') $count--;
        if($this->passport_date == null || $this->passport_date == '') $count--;
        if($this->passport_issue == null || $this->passport_issue == '') $count--;
        if($this->passport_file == null || $this->passport_file == '') $count--;
        if($this->check_phone != 1) $count--;
        if($this->check_mail != 1) $count--;
        if($this->check_passport != 1) $count--;
        if($this->check_car != 1) $count--;

        return round( $count / $allCount * 100, 0);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAds()
    {
        return $this->hasMany(Ads::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssessments()
    {
        return $this->hasMany(Assessment::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssessments0()
    {
        return $this->hasMany(Assessment::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChatMessages()
    {
        return $this->hasMany(ChatMessage::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChatUsers()
    {
        return $this->hasMany(ChatUsers::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComplaints()
    {
        return $this->hasMany(Complaints::className(), ['user_from' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComplaints0()
    {
        return $this->hasMany(Complaints::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFavorites()
    {
        return $this->hasMany(Favorites::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHistoryOperations()
    {
        return $this->hasMany(HistoryOperations::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsersCatalogs()
    {
        return $this->hasMany(UsersCatalog::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsersPromotions()
    {
        return $this->hasMany(UsersPromotion::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UsersBalls]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsersBalls()
    {
        return $this->hasMany(UsersBall::className(), ['user_from' => 'id']);
    }

    /**
     * Gets query for [[UsersBalls0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsersBalls0()
    {
        return $this->hasMany(UsersBall::className(), ['user_to' => 'id']);
    }

    /**
     * Gets query for [[UsersReytings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsersReytings()
    {
        return $this->hasMany(UsersReyting::className(), ['user_id' => 'id']);
    }

    /*shartli ravishda saqlanish joyi fiksrlangan, keyinchalik o;zgarishi mumkin*/
    public function upload()
    {
        if(!empty($this->image))
        {   
            if(file_exists('uploads/avatars/'.$this->avatar) && $this->avatar != null)
            {
                unlink('uploads/avatars/'.$this->avatar);
            }

            $fileName = time() . '_' . $this->image->baseName . '.' . $this->image->extension;
            $this->image->saveAs('uploads/avatars/' . $fileName);
            Yii::$app->db->createCommand()->update('users', ['avatar' => $fileName], [ 'id' => $this->id ])->execute();
        }
    }

    public function uploadFromSite()
    {
        if(!empty($this->image))
        {   
            if(file_exists($_SERVER['DOCUMENT_ROOT'] . '/backend/web/uploads/avatars/' . $this->avatar) && $this->avatar != null)
            {
                unlink($_SERVER['DOCUMENT_ROOT'] . '/backend/web/uploads/avatars/' . $this->avatar);
            }

            $fileName = time() . '_' . $this->image->baseName . '.' . $this->image->extension;
            $this->image->saveAs('@backend/web/uploads/avatars/' . $fileName);
            Yii::$app->db->createCommand()->update('users', ['avatar' => $fileName], [ 'id' => $this->id ])->execute();
        }
    }

    /*shartli ravishda saqlanish joyi fiksrlangan, keyinchalik o;zgarishi mumkin*/
    public function uploadPassport()
    {
        if(!empty($this->passport_image))
        {   
            if(file_exists('uploads/avatars/'.$this->passport_file) && $this->passport_file != null)
            {
                unlink('uploads/avatars/'.$this->passport_file);
            }

            $fileName = time() . '_' . $this->passport_image->baseName . '.' . $this->passport_image->extension;
            $this->passport_image->saveAs('uploads/avatars/' . $fileName);
            Yii::$app->db->createCommand()->update('users', ['passport_file' => $fileName], [ 'id' => $this->id ])->execute();
        }
    }

    /*shartli ravishda saqlanish joyi fiksrlangan, keyinchalik o;zgarishi mumkin*/
    public function uploadCompanyFiles()
    {
        if(!empty($this->company_image))
        {   
            if(file_exists('uploads/avatars/'.$this->company_files) && $this->company_files != null)
            {
                unlink('uploads/avatars/'.$this->company_files);
            }

            $fileName = time() . '_' . $this->company_image->baseName . '.' . $this->company_image->extension;
            $this->company_image->saveAs('uploads/avatars/' . $fileName);
            Yii::$app->db->createCommand()->update('users', ['company_files' => $fileName], [ 'id' => $this->id ])->execute();
        }
    }

    public function getPassportImages()
    {
        $siteName = Yii::$app->params['siteName'];
        $explode = explode(',', $this->passport_file);
        $result = '';
        foreach ($explode as $file) {
            $img = $_SERVER['DOCUMENT_ROOT'] . '/backend/web/uploads/users/' . $file;
            if(file_exists($img) && $file != null)
            {
                $img = $siteName . '/backend/web/uploads/users/' . $file;
                $result .= '<div class="image_preview_class" id="'.$file . '_' . $this->id.'"><a class="img-ads" data-id="' . $this->id . '" data-path="' . $file . '" >x</a><span class="preview"><img src="' . $img . '"></span></div>';
            }
        }
        return $result;
    }

    public function getCompanyImages()
    {
        $siteName = Yii::$app->params['siteName'];
        $explode = explode(',', $this->company_files);
        $result = '';
        foreach ($explode as $file) {
            $img = $_SERVER['DOCUMENT_ROOT'] . '/backend/web/uploads/users/' . $file;
            if(file_exists($img) && $file != null)
            {
                $img = $siteName . '/backend/web/uploads/users/' . $file;
                $result .= '<div class="image_preview_class" id="'.$file . '_' . $this->id.'"><a class="img-ads" data-id="' . $this->id . '" data-path="' . $file . '" >x</a><span class="preview"><img src="' . $img . '"></span></div>';
            }
        }
        return $result;
    }

    public function uploadsPassport()
    {
        if(!empty($this->passport_image)) {
            $string = '';
            $explode = explode(',', $this->passport_file);
            foreach ($explode as $file) {
                if(file_exists($_SERVER['DOCUMENT_ROOT'] . '/backend/web/uploads/users/' . $file) && $file != null) {
                    if($string == '') $string = $file;
                    else $string .= ',' . $file;
                }
            }
            
            foreach ($this->passport_image as $file) {
                $fileName = $this->id . '-' . Yii::$app->security->generateRandomString() . '.' . $file->extension;
                $file->saveAs('@backend/web/uploads/users/' . $fileName);
                if($string == '') $string = $fileName;
                else $string .= ',' . $fileName;
            }

            $this->passport_file = $string;
            $this->save(false);
            return true;
        } else {
            return false;
        }
    }

    public function uploadsCompanyImages()
    {
        if(!empty($this->company_image)) {
            $string = '';
            $explode = explode(',', $this->company_files);
            foreach ($explode as $file) {
                if(file_exists($_SERVER['DOCUMENT_ROOT'] . '/backend/web/uploads/users/' . $file) && $file != null) {
                    if($string == '') $string = $file;
                    else $string .= ',' . $file;
                }
            }
            
            foreach ($this->company_image as $file) {
                $fileName = $this->id . '-comp-' . Yii::$app->security->generateRandomString() . '.' . $file->extension;
                $file->saveAs('@backend/web/uploads/users/' . $fileName);
                if($string == '') $string = $fileName;
                else $string .= ',' . $fileName;
            }

            $this->company_files = $string;
            $this->save(false);
            return true;
        } else {
            return false;
        }
    }

    public function downloadPassport()
    {
        if($this->passport_file == '' || $this->passport_file == null) {
            return null; 
        } else {
            return Html::a($this->passport_file . ' <i class="fa fa-download"></i>', ['/users/send-file', 'file' => $this->passport_file],[ 'title'=> 'Скачать', 'data-pjax' => 0]); 
        }
    }

    public function downloadCompanyFiles()
    {
        if($this->company_files == '' || $this->company_files == null) {
            return null; 
        } else {
            return Html::a($this->company_files . ' <i class="fa fa-download"></i>', ['/users/send-file', 'file' => $this->company_files],[ 'title'=> 'Скачать', 'data-pjax' => 0]); 
        }
    }

    public function getDate($date)
    {
        if($date != null) return date('d.m.Y', strtotime($date) );
        else $date;
    }


    public static function getType()
    {
        return [
            1 => "Администратор",
            2 => "Модератор",
            3 => "Пользователь",
        ];
    }


    public static function getTypeEdu()
    {
        return [
            1 => "Администратор",
            2 => "Модератор",
            3 => "Пользователь",
        ];
    }

    public function getTypeDescription()
    {
        switch ($this->type) {
            case 1: return "Администратор";
            case 2: return "Модератор";
            case 3: return "Пользователь";
            default: return "Неизвестно";
        }
    }

    public static function getPerDescription($type = null)
    {
        switch ($type) {
            case 1: return "Администратор";
            case 2: return "Модератор";
            case 3: return "Пользователь";
            default: return "Неизвестно";
        }
    }

    public function getAccessType()
    {
        return [
            1 => "Активирован",
            2 => "Заблокирован",
        ];
    }

    public static function getLegal()
    {
        return [
            1 => "Физ. лицо",
            2 => "ИП или Юр. лицо",
        ];
    }

    public function getPromotions()
    {
        return UsersPromotion::find()->where(['user_id' => $this->id])->all();
    }

    public function getHistories()
    {
        return HistoryOperations::find()->where(['user_id' => $this->id])->all();
    }

    public function getAssessmentsList()
    {
        return Assessment::find()->where(['user_id' => $this->id])->all();
    }

    public function getStarCount()
    {
        $userBall = UsersBall::find()->where(['user_to' => $this->id])->all();
        $count = 0; $ball = 0;
        foreach ($userBall as $value) {
            $count++;
            $ball += $value->ball;
        }
        if($count > 0) return round($ball/$count, 2);
        else return 0;
    }

    public function getReyting()
    {
        $usersReyting = UsersReyting::find()->where(['user_id' => $this->id])->all();
        $reyting = 0;
        foreach ($usersReyting as $value) {
            $reyting += $value->ball;
        }
        return $reyting;
    }

    public function getAvatarForSite()
    {
        $siteName = Yii::$app->params['siteName'];

        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/backend/web/uploads/avatars/' . $this->avatar) || $this->avatar == '') {
            $path = $siteName . '/backend/web/img/nouser.png';
        } else {
            $path = $siteName . '/backend/web/uploads/avatars/' . $this->avatar;
        }
        return $path;
    }

    public function getActiveMenu($url)
    {
        if($url == 'currency') return 1;
        if($url == 'promotions') return 1;
        if($url == 'categories') return 1;
        if($url == 'regions') return 1;
        if($url == 'settings') return 1;
        if($url == 'price-list') return 1;
        if($url == 'language') return 1;
        return 0;
    }

    public function getChatMessageCount()
    {
        $chatId = ChatUsers::find()->select('chat_id')->where(['user_id' => $this->id])->asArray()->all();
        $res = [];
        foreach ($chatId as $value) {
            $res [] = $value['chat_id'];
        }
        $msgCount = ChatMessage::find()
            ->where(['!=', 'user_id', $this->id])
            ->andWhere(['chat_id' => $res])
            ->andWhere(['is_read' => 0])
            ->count();
        return $msgCount;
    }

    //passport fayllarini saqlash uchun
    public function UploadPassportImage($post)
    {
        $uploaded_files = $post['uploaded_passport_files'];
        $old_uploaded_files = $post['old_uploaded_passport_files'];
        $source_path = Yii::getAlias('@backend/web/uploads/ads_trash/');
        $destination_path = Yii::getAlias('@backend/web/uploads/users/passports/');
        if($uploaded_files != "")
        {
            $images = explode(",",$uploaded_files);
            $names= [];
            foreach ($images as $value) {
                if(file_exists($source_path.$value)){
                    $ext = substr(strrchr($value, "."), 1); 
                    $fileName = $this->id . '-' . Yii::$app->security->generateRandomString() . '.' . $ext;
                    $names[] = $fileName;
                    copy($source_path.$value, $destination_path . $fileName);
                    unlink($source_path.$value);
                }
            }  
            $new_images = implode(",", $names);
            if($old_uploaded_files != ""){
                $this->passport_file = $old_uploaded_files . "," . $new_images;
            }else{
                $this->passport_file = $new_images;
            }
        }elseif($old_uploaded_files != ""){
            $this->passport_file = $old_uploaded_files;
        }
        
        $this->save(false);
    }

    public function isImage($image)
    {
        $allowedExts = array("gif", "jpeg", "jpg", "png"); 
        $ext = array_pop(explode('.', $image));
        if(in_array($ext, $allowedExts)){
            return "";
        }
        return $ext;
    }

    //pssport file ni ochirish uchun
    public static function unlinkPassportFile($file,$images)
    {
        $dir1 = Yii::getAlias('@backend/web/uploads/ads_trash/');
        $dir2 = Yii::getAlias('@backend/web/uploads/users/passports/');

        if(file_exists($dir1 . $file) && $file != null)
        {
            unlink($dir1 . $file);
        }
        elseif(file_exists($dir2 . $file) && $file != null)
        {
            $all_files = explode(",", $images);
            $index = array_search($file, $all_files);
            if($index !== false){
                unset($all_files[$index]);
            }
            unlink($dir2 . $file);
            return implode(",",$all_files);;
        }
    }

    //company fayllarini saqlash uchun
    public function UploadCompanyImage($post)
    {
        $uploaded_files = $post['uploaded_company_files'];
        $old_uploaded_files = $post['old_uploaded_company_files'];
        $source_path = Yii::getAlias('@backend/web/uploads/ads_trash/');
        $destination_path = Yii::getAlias('@backend/web/uploads/users/companies/');

        if($uploaded_files != "")
        {
            $images = explode(",",$uploaded_files);
            $names= [];
            foreach ($images as $value) {
                if(file_exists($source_path.$value)){
                    $ext = substr(strrchr($value, "."), 1); 
                    $fileName = $this->id . '-' . Yii::$app->security->generateRandomString() . '.' . $ext;
                    $names[] = $fileName;
                    copy($source_path.$value, $destination_path . $fileName);
                    unlink($source_path.$value);
                }
            }  
            
            $new_images = implode(",", $names);
            if($old_uploaded_files != ""){
                $this->company_files = $old_uploaded_files . "," . $new_images;
            }else{
                $this->company_files = $new_images;
            }
        }elseif($old_uploaded_files != ""){
            $this->company_files = $old_uploaded_files;
        }
        $this->save(false);
    }

    //company file ni ochirish uchun
    public static function unlinkCompanyFile($file,$images)
    {
        $dir1 = self::DIR_NAME_FOR_UPLOADING_PASSPORT_FILES;
        $dir2 = self::TEMP_DIR_NAME;

        if(file_exists($dir1 . $file) && $file != null)
        {
            unlink($dir1 . $file);
        }
        elseif(file_exists($dir2 . $file) && $file != null)
        {
            $all_files = explode(",", $images);
            $index = array_search($file, $all_files);
            if($index !== false){
                unset($all_files[$index]);
            }
            unlink($dir2 . $file);
            return implode(",",$all_files);;
        }
    }

    public function getSmsAccessToken()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "notify.eskiz.uz/api/auth/login",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array('email' => 'i.sharifov@bpm-group.uz', 'password' => '5u38pgdN5IFaxHiybdtEdrm0HLkhSCXglZnhpZ0S'),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response)->data->token;
    }

    public function sendSms($phone, $text, $token)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "notify.eskiz.uz/api/message/sms/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array('mobile_phone' => $phone, 'message' => $text),
            CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer " . $token
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        /*echo "phone = ". $phone;
        echo "text = ". $text;

        echo "<pre>";
        print_r($response);
        echo "</pre>";*/
        return $response;
    }
}
