<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "regulatory_map_status".
 *
 * @property int $id
 * @property int $regulatory_id
 * @property int $status
 * @property string $date_created
 */
class RegulatoryMapStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'regulatory_map_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['regulatory_id', 'status'], 'required'],
            [['regulatory_id', 'status'], 'integer'],
            [['date_created'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'regulatory_id' => 'Regulatory ID',
            'status' => 'Status',
            'date_created' => 'Date Created',
        ];
    }
}
