<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "s_brend".
 *
 * @property int $id
 * @property string $nom
 */
class Sinv extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 's_inv';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nom'], 'required'],
            [['id'], 'integer'],
            [['nom'], 'string', 'max' => 250],
            [['tel'],'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nom' => 'Nom',
            'tel'=>'Tel'
        ];
    }
}
