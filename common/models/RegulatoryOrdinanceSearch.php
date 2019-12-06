<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\RegulatoryOrdinance;

/**
 * RegulatoryOrdinanceSearch represents the model behind the search form of `common\models\RegulatoryOrdinance`.
 */
class RegulatoryOrdinanceSearch extends RegulatoryOrdinance
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'ordinance_id', 'information_id', 'policy_opt_id'], 'integer'],
            [['rationale', 'date_created',  'ordinance_res_no', 'title', 'eff_date_pass'], 'safe'],
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
        $query = RegulatoryOrdinance::find()->joinWith(['ordinance', 'information inf', 'regulatoryReportStatus rrs'])->orderBy(['date_created' => SORT_DESC]);

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
            'rrs.level' => $this->level,
            'inf.region_c' => $this->region_c,
            'inf.province_c' => $this->province_c,
            'inf.citymun_c' => $this->citymun_c
        ]);

        $query->andFilterWhere(['like', 'ordinance_res_no', $this->ordinance_res_no]);
        $query->andFilterWhere(['like', 'title', $this->title]);
        $query->andFilterWhere(['like', 'eff_date_pass', $this->eff_date_pass]);

        return $dataProvider;
    }
}
