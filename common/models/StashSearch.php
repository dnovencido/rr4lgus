<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Stash;

/**
 * StashSearch represents the model behind the search form of `common\models\Stash`.
 */
class StashSearch extends Stash
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'regulatory_id', 'status_id', 'stash_info_id'], 'integer'],
            [['date_created'], 'safe'],
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
        $query = Stash::find()->joinWith(['regulatoryMap rm']);

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
            'rm.current_status' => $this->status_id,
            'stash_info_id' => $this->stash_info_id
        ]);

        return $dataProvider;
    }
}
