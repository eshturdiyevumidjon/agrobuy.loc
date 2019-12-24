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
            [['chat_id', 'user_id', 'is_read'], 'integer'],
            [['message'], 'string'],
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
            'chat_id' => Yii::t('app', 'Chat ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'message' => Yii::t('app', 'Message'),
            'file' => Yii::t('app', 'File'),
            'date_cr' => Yii::t('app', 'Date Cr'),
            'is_read' => Yii::t('app', 'Is Read'),
        ];
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
}
