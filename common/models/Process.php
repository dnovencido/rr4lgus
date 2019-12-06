<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "process".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $date_created
 *
 * @property ProcessSubmission[] $processSubmissions
 * @property ProcessType[] $processTypes
 */
class Process extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'process';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'code'], 'required'],
            [['date_created'], 'safe'],
            [['name'], 'string', 'max' => 150],
            [['code'], 'string', 'max' => 50],
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
            'code' => 'Code',
            'date_created' => 'Date Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcessSubmissions()
    {
        return $this->hasMany(ProcessSubmission::className(), ['process_id' => 'id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIntialProcess()
    {
        return $this->hasMany(ProcessSubmission::className(), ['process_id' => 'id'])->where(['order_c' => 1])->one();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcessTypes()
    {
        return $this->hasMany(ProcessType::className(), ['process_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInitialProcess()
    {
        return $this->intialProcess->level_id;
    }
}
