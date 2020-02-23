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
            /*if($value->chat->name == 'chat_12_1') {
                echo "vv=" . $value->chat_id;
                echo "<pre>";
                print_r($chat_user->user->getAvatarForSite());
                echo "</pre>";
                die;
            }*/
            $result [] = [
                'identity_id' => $user_id,
                'id' => $chat_user->user->id,
                'user_id' => $chat_user->user_id,
                'login' => $chat_user->user->login,
                'image' => $chat_user->user->getAvatarForSite(),
                'last_message' => (strlen($last_message->message) > 80) ? substr($last_message->message, 0, 80) . "..." : $last_message->message,
                'date_cr' => date('Y-m-d', strtotime($last_message->date_cr)) == date('Y-m-d') ? date('H:i', strtotime($last_message->date_cr)) : date('H:i d.m.Y', strtotime($last_message->date_cr)),
                'chat_id' => $value->chat->name,
                'count' => $count,
            ];
        }
        return $result;
    }

    public static  function getUsersList()
    {
        $user_id = Yii::$app->user->identity->id;
        $result = [];

        $allUsers = Users::find()->where(['type'=>3])->all();
        foreach ($allUsers as  $value) {
            $name = ""; $name2 = "";
            $name = "chat_".$user_id."_".$value->id;  $name2 = "chat_".$value->id."_".$user_id;
            $chat = Chats::find()->where(['or',['name'=>$name],['name'=>$name2]])->all();
                if($value->id != $user_id && $chat == null)
                {
                        $result [] = [
                            'id' => $value->id,
                            'fio' => $value->fio,
                            'role' => $value->getTypeDescription(),
                            'image' => $value->getAvatar(),
                        ];
                }
    }
        return $result;
    }
}
