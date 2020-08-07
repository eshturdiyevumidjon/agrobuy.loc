<?php
namespace api\modules\v1\models;


use Yii;

/**
 * This is the model class for table "chat_users".
 *
 * @property int $id
 * @property int|null $chat_id Чат
 * @property int|null $user_id Пользователи
 * @property string|null $date_cr Дата создание
 *
 * @property Chats $chat
 * @property Users $user
 */
class ChatUsers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chat_users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['chat_id', 'user_id'], 'integer'],
            [['date_cr'], 'safe'],
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
            'user_id' => 'Пользователи',
            'date_cr' => 'Дата создание',
        ];
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord)
        {
            $this->date_cr = date("Y-m-d H:i:s");
        }
        return parent::beforeSave($insert);
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

    public function sendMessageAboutDeletingAds($text)
    {
        $chatMessage = new ChatMessage();
        $chatMessage->chat_id = $this->chat_id;
        $chatMessage->user_id = $this->user_id;
        $chatMessage->message = $text;
        $chatMessage->save(false);
    }
}
