<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "translates".
 *
 * @property int $id
 * @property string $table_name
 * @property int $field_id
 * @property string $field_name
 * @property string $field_description
 * @property string $field_value
 * @property string $language_code
 */
class Translates extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'translates';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['field_id'], 'integer'],
            [['field_value'], 'string'],
            [['table_name', 'field_name', 'field_description', 'language_code'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'table_name' => 'Наименование таблицы',
            'field_id' => 'ID строка',
            'field_name' => 'Наименование строка',
            'field_description' => 'Описание',
            'field_value' => 'Значение',
            'language_code' => 'Код языка',
        ];
    }
}
