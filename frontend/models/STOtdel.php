<?php

namespace frontend\models;

use Yii;

class STOtdel extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 's_t_otdel';
    }
    public function rules()
    {
        return [
            [['nom'], 'required'],
            [['id'], 'integer'],
            [['nom'], 'string', 'max' => 250],
        ];
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nom' => 'Nom',
        ];
    }
}
