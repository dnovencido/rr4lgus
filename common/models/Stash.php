<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "stash".
 *
 * @property int $id
 * @property int $regulatory_id
 * @property string $date_created
 */
class Stash extends \yii\db\ActiveRecord
{

    //Global variables
    public $status_id;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stash';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['regulatory_id'], 'integer'],
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
            'date_created' => 'Date Created',
            'regulatoryOrdPolicyCodeNo' => 'Policy No/ Code',
            'regulatoryTitle' => 'Title',
            'regulatoryType' => 'Type'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getRegulatoryMap()
    {
        return $this->hasOne(RegulatoryMap::className(), ['id' => 'regulatory_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function getStashInfo()
    {
        return $this->hasOne(StashInfo::className(), ['id' => 'stash_info_id']);
    }

    /**
    * {@inheritdoc}
    */
    public function getType()
    {
        return $this->hasOne(Type::className(), ['id' => 'type_id']);
    }  

    /**
    * {@inheritdoc}
    */
    public function getRegulatoryReformInfo()
    {
        return (Type::findOne($this->regulatoryMap->type_id)->type_code == 'ORD') ? $this->hasOne(Ordinance::className(), ['id' => 'ref_id'])->via('regulatoryMap') : $this->hasOne(Issuance::className(), ['id' => 'ref_id'])->via('regulatoryMap'); 
    }  
    
    /**
    * {@inheritdoc}
    */
    public function getRegulatoryTitle()
    {
        return $this->regulatoryReformInfo->title;
    } 
    
    /**
    * {@inheritdoc}
    */
    public function getRegulatoryOrdPolicyCodeNo()
    {
        return (Type::findOne($this->regulatoryMap->type_id)->type_code == 'ORD') ? $this->regulatoryReformInfo->ordinance_res_no : $this->regulatoryReformInfo->issuance_no;
    }
    
    /**
    * {@inheritdoc}
    */
    public function getRegulatoryType()
    {
        return (Type::findOne($this->regulatoryMap->type_id)->type_code == 'ORD') ? Type::findByCode('ORD')->type_code  : Type::findByCode('ISS')->type_code;
    }         
}
