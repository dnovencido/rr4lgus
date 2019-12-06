<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "process_submission".
 *
 * @property int $id
 * @property int $level_id
 * @property int $process_id
 * @property int $order_c
 * @property string $date_created
 *
 * @property Process $process
 * @property ProcessLevel $level
 */
class ProcessSubmission extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'process_submission';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['level_id', 'process_id', 'order_c'], 'required'],
            [['level_id', 'process_id', 'order_c'], 'integer'],
            [['date_created'], 'safe'],
            [['process_id'], 'exist', 'skipOnError' => true, 'targetClass' => Process::className(), 'targetAttribute' => ['process_id' => 'id']],
            [['level_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProcessLevel::className(), 'targetAttribute' => ['level_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'level_id' => 'Level ID',
            'process_id' => 'Process ID',
            'order_c' => 'Order',
            'date_created' => 'Date Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcess()
    {
        return $this->hasOne(Process::className(), ['id' => 'process_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLevel()
    {
        return $this->hasOne(ProcessLevel::className(), ['id' => 'level_id']);
    }
}
