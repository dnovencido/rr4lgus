<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\RegulatoryMap;

/**
 * RegulatoryMapSearch represents the model behind the search form of `common\models\RegulatoryMap`.
 */
class RegulatoryMapSearch extends RegulatoryMap
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'ref_id', 'type_id', 'sector_id', 'coverage_id', 'measure_id', 'policy_id', 'new_polissce', 'user_id', 'status_id'], 'integer'],
            [['hash_id', 'date_of_approval', 'legal_bases', 'reasfpol', 'remarks'], 'safe'],
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
        $query = RegulatoryMap::find()->orderBy(['id' => SORT_DESC]);

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
            'current_status' => $this->status_id,
        ]);

        return $dataProvider;
    }
}
