<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "translates".
 *
 * @property int $id
 * @property string $table_name Жадвал номи
 * @property int $field_id ID сатр
 * @property string $field_name сатр номи
 * @property string $field_value Қиймфти
 * @property string $language_code Тил коди
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
            [['table_name', 'field_name', 'language_code'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'table_name' => 'Жадвал номи',
            'field_id' => 'ID сатр',
            'field_name' => 'сатр номи',
            'field_value' => 'Қиймфти',
            'language_code' => 'Тил коди',
        ];
    }
}
