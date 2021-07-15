<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "apps_countries".
 *
 * @property int $id
 * @property string $country_code
 * @property string $country_name
 */
class Obl extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 's_obl';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 2],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Viloyat',
        ];
    }
}
