<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "process_level".
 *
 * @property int $id
 * @property string $name
 * @property string $date_created
 *
 * @property ProcessSubmission[] $processSubmissions
 * @property RegulatoryReportStatus[] $regulatoryReportStatuses
 */
class ProcessLevel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'process_level';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['date_created'], 'safe'],
            [['name'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'date_created' => 'Date Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcessSubmissions()
    {
        return $this->hasMany(ProcessSubmission::className(), ['level_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegulatoryReportStatuses()
    {
        return $this->hasMany(RegulatoryReportStatus::className(), ['level' => 'id']);
    }
}
