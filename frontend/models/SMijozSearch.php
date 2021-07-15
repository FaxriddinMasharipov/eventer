<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\SMijoz;

/**
 * SMijozSearch represents the model behind the search form of `frontend\models\SMijoz`.
 */
class SMijozSearch extends SMijoz
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'lavozim_id', 'user_id', 'slave_id', 'tadbir_id', 'printer', 'pr_tur', 'mobile', 'vvod_tur', 'forum'], 'integer'],
            [['fio', 'email', 'tashkilot', 'lavozim', 'tel', 'qrkod', 'new_date', 'site_date', 'reg_date', 'davlat', 'message'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = SMijoz::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'lavozim_id' => $this->lavozim_id,
            'user_id' => $this->user_id,
            'new_date' => $this->new_date,
            'site_date' => $this->site_date,
            'slave_id' => $this->slave_id,
            'reg_date' => $this->reg_date,
            'tadbir_id' => $this->tadbir_id,
            'printer' => $this->printer,
            'pr_tur' => $this->pr_tur,
            'mobile' => $this->mobile,
            'vvod_tur' => $this->vvod_tur,
            'forum' => $this->forum,
        ]);

        $query->andFilterWhere(['like', 'fio', $this->fio])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'tashkilot', $this->tashkilot])
            ->andFilterWhere(['like', 'lavozim', $this->lavozim])
            ->andFilterWhere(['like', 'tel', $this->tel])
            ->andFilterWhere(['like', 'qrkod', $this->qrkod])
            ->andFilterWhere(['like', 'davlat', $this->davlat])
            ->andFilterWhere(['like', 'message', $this->message]);

        return $dataProvider;
    }
}
