<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "regulatory_report_status".
 *
 * @property int $id
 * @property int $ref_id
 * @property int $status
 * @property int $level
 * @property string $date_created
 */
class RegulatoryReportStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'regulatory_report_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ref_id', 'status', 'level'], 'integer'],
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
            'ref_id' => 'Ref ID',
            'status' => 'Status',
            'level' => 'Level',
            'date_created' => 'Date Created',
        ];
    }
     

    /**
    * {@inheritdoc}
    */
    public function getRegulatoryOrdinance() {

        return $this->hasMany(RegulatoryOrdinance::className(), ['id' => 'ref_id']);
    
    }

    /**
    * {@inheritdoc}
    */
    public function getRegulatoryIssuance() {

        return $this->hasMany(RegulatoryIssuance::className(), ['id' => 'ref_id']);
    
    }    

    /**
    * {@inheritdoc}
    */
    public function getOrdinance() {

        return $this->hasOne(Ordinance::className(), ['id' => 'ordinance_id'])->via('regulatoryOrdinance');
    
    }    

    /**
    * {@inheritdoc}
    */
    public function getLevelReport() {

        return $this->hasOne(ProcessLevel::className(), ['id' => 'level']);
    
    } 

    /**
    * {@inheritdoc}
    */
    public function getIssuance() {

        return $this->hasOne(Issuance::className(), ['id' => 'issuance_id'])->via('regulatoryIssuance');
    
    }    
   
    /**
    * {@inheritdoc}
    */
    public function getStatusReport() {

        return $this->hasOne(Status::className(), ['id' => 'status']);

    }    

    /**
    * {@inheritdoc}
    */
    public function getIssuanceTitle(){

        return $this->hasOne(Issuance::className(), ['id' => 'ref_id']);

    }    

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getType() {
        return $this->hasOne(Type::className(), ['id' => 'type_id']);
    }

    /**
    * {@inheritdoc}
    */
    public function getReportTitle() {
        
        return ($this->type->type_code == 'ORD') ? $this->ordinance->title: $this->issuance->title;

    }   
    
    /**
    * {@inheritdoc}
    */
    public function getStatusLabel() {
        
        return $this->statusReport->name;

    } 
    
    /**
    * {@inheritdoc}
    */
    public function getLevelLabel() {
        
        return $this->levelReport->name;

    }       

}
