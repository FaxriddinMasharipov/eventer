<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "s_brend".
 *
 * @property int $id
 * @property string $main_id
 * @property int $slave_id
 */
class SlaveMain extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $serial;
    public static function tableName()
    {
        return 'slave_main';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['slave_id'], 'integer'],
            [['main_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slave_id' => 'Tovar',
            'main_id' => 'Seriya',
        ];
    }
}
