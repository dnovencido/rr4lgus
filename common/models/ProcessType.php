<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "process_type".
 *
 * @property int $id
 * @property int $process_id
 * @property string $type
 * @property string $region
 * @property string $prov
 * @property string $citymun
 *
 * @property Process $process
 */
class ProcessType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'process_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['process_id'], 'integer'],
            [['type', 'region', 'prov', 'citymun'], 'string', 'max' => 50],
            [['process_id'], 'exist', 'skipOnError' => true, 'targetClass' => Process::className(), 'targetAttribute' => ['process_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'process_id' => 'Process ID',
            'type' => 'Type',
            'region' => 'Region',
            'prov' => 'Prov',
            'citymun' => 'Citymun',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcess()
    {
        return $this->hasOne(Process::className(), ['id' => 'process_id']);
    }

}
