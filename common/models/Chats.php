<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "chats".
 *
 * @property int $id
 * @property string|null $name Наименование
 * @property string|null $date_cr Дата создание
 * @property int|null $type Тип чата
 *
 * @property ChatMessage[] $chatMessages
 * @property ChatUsers[] $chatUsers
 */
class Chats extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chats';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_cr'], 'safe'],
            [['type'], 'integer'], //(1=> admin, 2 => oddiy_chat) (Тип чата)
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' =>'Наименование',
            'date_cr' =>'Дата создание',
            'type' => 'Тип чата',
        ];
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->date_cr = date('Y-m-d H:i:s');
        }
        
        return parent::beforeSave($insert);
    }

    public function beforeDelete()
    {
        $users = ChatUsers::find()->where(['chat_id' => $this->id])->all();
        foreach ($users as $user) {
            $user->delete();
        }
        return parent::beforeDelete();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChatMessages()
    {
        return $this->hasMany(ChatMessage::className(), ['chat_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChatUsers()
    {
        return $this->hasMany(ChatUsers::className(), ['chat_id' => 'id']);
    }

    public static  function getUsersListChat()
    {
        $user_id = Yii::$app->user->identity->id;
        $result = [];
        
        $chatUsers = ChatUsers::find()->where(['user_id' => $user_id])->all();
        foreach ($chatUsers as $value) {
            $chat_user = ChatUsers::find()->where(['!=', 'user_id', $user_id])->andWhere(['chat_id' => $value->chat_id])->one();
            $last_message = ChatMessage::find()->where(['chat_id' => $chat_user->chat_id])->orderBy(['id' => SORT_DESC])->one();
            $count = ChatMessage::find()
                ->where(['chat_id' => $value->chat_id, 'is_read' => 0])
                ->andWhere(['!=', 'user_id', $user_id])
                ->count();
            $result [] = [
                'identity_id' => $user_id,
                'id' => $chat_user->user->id,
                'user_id' => $chat_user->user_id,
                'login' => $chat_user->user->login,
                'image' => $chat_user->user->getAvatarForSite(),
                'last_message' => (strlen($last_message->message) > 20) ? substr($last_message->message, 0, 20) . "..." : $last_message->message,
                'date_cr' => date('Y-m-d', strtotime($last_message->date_cr)) == date('Y-m-d') ? date('H:i', strtotime($last_message->date_cr)) : date('H:i d.m.Y', strtotime($last_message->date_cr)),
                'chat_id' => $value->chat->name,
                'chat_type' => $value->chat->type,
                'count' => $count,
            ];
        }

        array_multisort(array_column($result, 'date_cr'), SORT_DESC, $result);
        $sendingResult = [];
        foreach ($result as $value) {
            if($value['chat_type'] == 1) {
                $sendingResult [] = $value;
                break;
            }
        }
        foreach ($result as $value) {
            if($value['chat_type'] != 1) {
                $sendingResult [] = $value;
            }
        }

        return $sendingResult;
    }

    public static  function getUsersList()
    {
        $result = [];
        $allUsers = Users::find()->where(['type'=>3])->all();
        foreach ($allUsers as $user) {
            $chat = Chats::find()->where(['name' => 'chat_' . $user->id])->one();
            if($chat == null) {
                $chat = new Chats();
                $chat->name = 'chat_' . $user->id;
                $chat->type = 1;
                $chat->save();
            }
            $result [] = [
                'id' => $user->id,
                'login' => $user->login,
                'role' => $user->getTypeDescription(),
                'image' => $user->getAvatar(),
            ];
        }
        return $result;
    }

    public static  function getActiveChatList()
    {
        $user_id = Yii::$app->user->identity->id;
        $result = [];
        
        $chatUsers = ChatUsers::find()->joinWith('chat')->where(['user_id' => $user_id, 'chats.type' => 1])->all();
        $chatId = [];
        foreach ($chatUsers as $value) {
            $chatId [] = $value->chat_id;
        }
        $chatId = array_unique($chatId);
        foreach ($chatId as $chat_id) {
            $chat_user = ChatUsers::find()->where(['!=', 'user_id', $user_id])->andWhere(['chat_id' => $chat_id])->one();
            $last_message = ChatMessage::find()->where(['chat_id' => $chat_id])->orderBy(['id' => SORT_DESC])->one();
            $count = ChatMessage::find()->where(['!=', 'user_id', $user_id])->andWhere(['chat_id' => $chat_id, 'is_read' => 0,])->count();
            $result [] = [
                'chat_id' => $chat_id,
                'user_id' => $chat_user->user_id,
                'login' => $chat_user->user->login,
                'role' => $chat_user->user->getTypeDescription(),
                'image' => $chat_user->user->getAvatarForSite(),
                'last_message' => $last_message->message,
                'date_cr' => $last_message->date_cr,
                'count' => $count,
            ];
        }
        array_multisort(array_column($result, 'date_cr'), SORT_DESC, $result);
        return $result;
    }
}
