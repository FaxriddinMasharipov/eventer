<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "s_mijoz".
 *
 * @property int $id
 * @property string $fio
 * @property string $email
 * @property string $tashkilot
 * @property string $lavozim
 * @property int $lavozim_id
 * @property string $tel
 * @property string $qrkod
 * @property int $user_id
 * @property string $new_date
 * @property string $site_date
 * @property int $slave_id
 * @property string $reg_date
 * @property int $tadbir_id
 * @property int $printer
 * @property int $pr_tur
 * @property int $mobile
 * @property string $davlat
 * @property int $vvod_tur
 * @property int $forum
 * @property string $message
 */
class SMijoz extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 's_mijoz';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lavozim_id', 'user_id', 'slave_id', 'tadbir_id', 'printer', 'pr_tur', 'mobile', 'vvod_tur', 'forum'], 'integer'],
            [['new_date', 'site_date', 'reg_date'], 'safe'],
//            [['message,fio'], 'required'],
            [['fio'], 'string', 'max' => 250],
            [['email'], 'string', 'max' => 100],
            [['tashkilot', 'lavozim', 'davlat'], 'string', 'max' => 150],
            [['tel'], 'string', 'max' => 13],
            [['qrkod'], 'string', 'max' => 12],
            [['message'], 'string', 'max' => 255],


        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fio' => '',
            'email' => '',
            'tashkilot' => '',
            'lavozim' => '',
            'lavozim_id' => 'Lavozim ID',
            'tel' => '',
            'qrkod' => '',
            'user_id' => 'User ID',
            'new_date' => 'New Date',
            'site_date' => 'Site Date',
            'slave_id' => 'Slave ID',
            'reg_date' => 'Reg Date',
            'tadbir_id' => 'Tadbir ID',
            'printer' => 'Printer',
            'pr_tur' => 'Pr Tur',
            'mobile' => 'Mobile',
            'davlat' => '',
            'vvod_tur' => 'Vvod Tur',
            'forum' => 'Forum',
            'message' => '',
        ];
    }
}
