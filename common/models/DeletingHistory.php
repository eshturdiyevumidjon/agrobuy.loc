<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "deleting_history".
 *
 * @property int $id
 * @property string|null $text Текст
 * @property string|null $date_cr Дата создание
 * @property int|null $type Тип
 */
class DeletingHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'deleting_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text', 'about'], 'string'],
            [['date_cr'], 'safe'],
            [['type'], 'integer'],
            [['text'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Описание',
            'date_cr' => 'Дата создание',
            'type' => 'Тип',
            'about' => 'Информация о пользователя',
        ];
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->date_cr = date('Y-m-d H:i:s');
            $this->type = 1;
        }

        return parent::beforeSave($insert);
    }
}
