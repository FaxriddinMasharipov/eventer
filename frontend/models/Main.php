<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "s_brend".
 *
 * @property int $id
 * @property string $serial
 * 
 */
class Main extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $tnom;
    public $clnom;
    public static function tableName()
    {
        return 'main';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'serial' => 'Seriya',
        ];
    }
}
