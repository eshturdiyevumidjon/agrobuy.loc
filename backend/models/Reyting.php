<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "reyting".
 *
 * @property int $id
 * @property string|null $name Наименование
 * @property float|null $ball Балл
 * @property string|null $key Ключ
 * @property int|null $unit_id Единица
 * @property float|null $value Причина
 *
 * @property UsersReyting[] $usersReytings
 */
class Reyting extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reyting';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ball', 'value'], 'number'],
            [['unit_id'], 'integer'],
            [['name', 'key'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'ball' => 'Балл',
            'key' => 'Ключ',
            'unit_id' => 'Единица',
            'value' => 'Причина',
        ];
    }

    /**
     * Gets query for [[UsersReytings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsersReytings()
    {
        return $this->hasMany(UsersReyting::className(), ['reyting_id' => 'id']);
    }
}
