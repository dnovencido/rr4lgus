<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%issuance}}".
 *
 * @property int $id
 * @property string $issuance_no
 * @property string $title
 * @property string $description
 */
class Issuance extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%issuance}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['issuance_no', 'title'], 'required'],
            [['description'], 'string'],
            [['issuance_no'], 'string', 'max' => 50]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'issuance_no' => 'Issuance No',
            'title' => 'Title',
            'description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegulatoryMap()
    {
        return $this->hasOne(RegulatoryMap::className(), ['ref_id' => 'id']);
    }        
}
