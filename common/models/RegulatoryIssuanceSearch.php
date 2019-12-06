<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\RegulatoryIssuance;

/**
 * RegulatoryIssuanceSearch represents the model behind the search form of `common\models\RegulatoryIssuance`.
 */
class RegulatoryIssuanceSearch extends RegulatoryIssuance
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'issuance_id', 'information_id', 'policy_opt_id', 'level', 'user_id'], 'integer'],
            [['date_created', 'last_updated', 'title', 'issuance_no'], 'safe'],
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
        $query = RegulatoryIssuance::find()->joinWith(['issuance']);

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

        $query->andFilterWhere(['like', 'issuance_no', $this->issuance_no]);
        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
