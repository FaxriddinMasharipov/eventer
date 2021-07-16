<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "s_tovar".
 *
 * @property int $id
 * @property string $nom
 * @property string $nom_ru
 * @property string $nom_sh
 * @property string $shtrix
 * @property string $shtrix_in
 * @property int $tz_id
 * @property int $kg
 * @property string $shtrix_full
 * @property string $shtrix1
 * @property string $shtrix2
 * @property int $kat
 * @property int $brend
 * @property string $qr
 * @property int $shtrixkod
 * @property int $qrkod
 * @property int $izm_id
 * @property int $kol_in
 * @property int $izm1
 * @property string $shakl
 * @property string $internom
 * @property int $turi
 * @property int $resept
 * @property double $aniq
 * @property double $minimal
 * @property double $maksimal
 * @property double $sotish
 * @property int $zavod_id
 * @property int $del_flag
 * @property int $upakavka
 * @property int $user_id
 * @property int $client_id
 * @property string $changedate
 * @property int $majbur_dori_id
 * @property int $miqdor
 * @property int $shart
 */
class STovar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 's_tovar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nom'], 'string', 'max' => 250],
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
            'nom_ru' => 'Nom Ru',
            'nom_sh' => 'Nom Sh',
            'shtrix' => 'Shtrix',
            'shtrix_in' => 'Shtrix In',
            'tz_id' => 'Tz ID',
            'kg' => 'Kg',
            'shtrix_full' => 'Shtrix Full',
            'shtrix1' => 'Shtrix1',
            'shtrix2' => 'Shtrix2',
            'kat' => 'Kat',
            'brend' => 'Brend',
            'sena' => 'Sena',
            'sena_d' => 'Sena_d',
            'sotish' => 'Sotish',
            'sotish_d' => 'Sotish_d',
            'ulg1' => 'ulg1',
            'ulg1_pl' => 'ulg1_pl',
            'ulg2' => 'ulg2',
            'ulg2_pl' => 'ulg2_pl',
            'papka' => 'Papka',
            'bank' => 'Bank',
            'qr' => 'Qr',
            'shtrixkod' => 'Shtrixkod',
            'qrkod' => 'Qrkod',
            'izm_id' => 'Izm ID',
            'kol_in' => 'Kol In',
            'zavod' => 'zavod',
            'izm' => 'izm',
            'izm1' => 'Izm1',
            'shakl' => 'Shakl',
            'internom' => 'Internom',
            'turi' => 'Turi',
            'ustun' => 'Ustun',
            't_otdel' => 'T_otdel',
            'resept' => 'Resept',
            'aniq' => 'Aniq',
            'minimal' => 'Minimal',
            'maksimal' => 'Maksimal',
            'sotish' => 'Sotish',
            'zavod_id' => 'Zavod ID',
            'del_flag' => 'Del Flag',
            'upakavka' => 'Upakavka',
            'user_id' => 'User ID',
            'client_id' => 'Client ID',
            'changedate' => 'Changedate',
            'majbur_dori_id' => 'Majbur Dori ID',
            'miqdor' => 'Miqdor',
            'shart' => 'Shart',
        ];
    }
}
