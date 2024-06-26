<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "chat_message".
 *
 * @property int $id
 * @property int|null $chat_id Чат
 * @property int|null $user_id Пользователь
 * @property string|null $message Сообщение
 * @property string|null $file Файл
 * @property string|null $date_cr Дата создание
 * @property int|null $is_read Прочитано
 *
 * @property Chats $chat
 * @property Users $user
 */
class ChatMessage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $imageFiles;
    public static function tableName()
    {
        return 'chat_message';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxFiles' => 50],
            [['chat_id', 'user_id', 'is_read'], 'integer'],
            [['message'], 'string'],
            //[['message'], 'required'],
            [['date_cr'], 'safe'],
            [['file'], 'string', 'max' => 255],
            [['chat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Chats::className(), 'targetAttribute' => ['chat_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'chat_id' => 'Чат',
            'user_id' => 'Пользователь',
            'message' => Yii::t('app', "Xabar matni"),
            'file' => 'Файл',
            'date_cr' =>'Дата создание',
            'is_read' =>'Прочитано',
        ];
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord)
        {
            $this->date_cr = date("Y-m-d H:i:s");
            $this->is_read = 0;
        }
        return parent::beforeSave($insert);
    }

    public function beforeDelete()
    {
        $messages = ChatMessage::find()->where(['chat_id' => $this->chat_id])->all();
        foreach ($messages as $msg) {
            $msg->delete();
        }
        return parent::beforeDelete();
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChat()
    {
        return $this->hasOne(Chats::className(), ['id' => 'chat_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    public static function getMessagesList($chat)
    {
        $identity = Yii::$app->user->identity;
        $date = null; $show = true; $result = [];
        $messages = ChatMessage::find()
            ->joinWith(['chat', 'user'])
            ->where(['chats.name' => $chat])
            ->orderBy(['date_cr' => SORT_ASC])
            ->all();

        foreach ($messages as $message) {
            if($date != date('d.m.Y', strtotime($message->date_cr))) {
                $date = date('d.m.Y', strtotime($message->date_cr));
                $show = true;
            }
            else $show = false;
            if($message->user_id == $identity->id) {
                $class = 'person-right';
                $link = '/profile';
            }
            else {
                $class = 'person-left';
                $link = '/profile/user?id=' . $message->user_id;
            }

            if($message->file != null) $msg = "<a href='/chat/download-file?path=".$message->file."' ><i class='fa fa-download'></i>".$message->file." </a>";
            else $msg = $message->message;
            $result [] = [
                'date' => $date,
                'showValue' => $show ? '<div class="date-letter">' . $date . '</div>' : '',
                'class' => $class,
                'date_cr' => date('Y-m-d', strtotime($message->date_cr)) == date('Y-m-d') ? date('H:i', strtotime($message->date_cr)) : date('H:i d.m.Y', strtotime($message->date_cr)),
                'userAvatar' => $message->user->getAvatarForSite(),
                'message' => $msg,
                'link' => $link,
            ];
            if($message->is_read === 0 && $message->user_id != $identity->id) {
                $message->is_read = 1;
                $message->save();
            }
        }

        return $result;
    }
}
