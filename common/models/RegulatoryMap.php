<?php

namespace common\models;
use niksko12\user\models\Region;
use niksko12\user\models\Province;
use niksko12\user\models\Citymun;

use Yii;

/**
 * This is the model class for table "regulatory_map".
 *
 * @property int $id
 * @property string $hash_id
 * @property int $ref_id
 * @property int $type_id
 * @property string $date_of_approval
 * @property string $legal_bases
 * @property int $sector_id
 * @property int $coverage_id
 * @property int $measure_id
 * @property int $policy_id
 * @property string $reasfpol
 * @property int $new_polissce
 * @property string $remarks
 * @property int $user_id
 */
class RegulatoryMap extends \yii\db\ActiveRecord
{   

    //Global variables
    public $policy_code_no, $title, $status_id, $stash_info_id;

    /**
    * {@inheritdoc}
    */
    public static function tableName()
    {
        return 'regulatory_map';
    }

    /**
    * {@inheritdoc}
    */
    public function rules()
    {
        return [
            [['hash_id', 'ref_id', 'type_id', 'date_of_approval', 'legal_bases', 'sector_id', 'coverage_id', 'measure_id', 'policy_id', 'reasfpol', 'new_polissce', 'remarks'], 'required'],
            [['ref_id', 'type_id', 'sector_id', 'coverage_id', 'measure_id', 'policy_id', 'user_id'], 'integer'],
            [['date_of_approval'], 'safe'],
            [['policy_code_no'], 'string'],
            [['title'], 'string'],
            [['hash_id'], 'string', 'max' => 50],
            [['legal_bases', 'new_polissce'], 'string', 'max' => 255],
            [['reasfpol'], 'string', 'max' => 355],
            [['remarks'], 'string', 'max' => 155],
        ];
    }

    /**
    * {@inheritdoc}
    */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hash_id' => 'Hash ID',
            'ref_id' => 'Ref ID',
            'type_id' => 'Type',
            'date_of_approval' => 'Date Of Approval',
            'legal_bases' => 'Legal Bases',
            'sector_id' => 'Sector',
            'coverage_id' => 'Coverage',
            'measure_id' => 'Measure',
            'policy_id' => 'Recommended policy option',
            'reasfpol' => 'Reason for the policy option',
            'new_polissce' => 'New Policy Issuance',
            'remarks' => 'Remarks',
            'user_id' => 'User ID',
            'policy_code_no', 'policyCodeNo' => 'Policy No / Code',
            'title', 'titleIssOrd' => 'Title of Ordinance/Resolution/Issuance/Executive Order',
            'regionM' => 'Region',
            'provinceM' => 'Province',
            'cityMunM' => 'City/Municipality',
            'typeName' => 'Type'
        ];
    }

    /**
    * {@inheritdoc}
    */
    public function generateID()
    {
        return \Ramsey\Uuid\Uuid::uuid4()->toString();
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getType()
    {
        return $this->hasOne(Type::className(), ['id' => 'type_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getSector()
    {
        return $this->hasOne(Sector::className(), ['id' => 'sector_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getPolicy()
    {
        return $this->hasOne(Policy::className(), ['id' => 'policy_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getPolicyName()
    {
        return $this->policy->name;
    }    
    
    /**
    * @return \yii\db\ActiveQuery
    */
    public function getPolicyCode()
    {
        return $this->policy->code;
    }    
    
    
    /**
    * @return \yii\db\ActiveQuery
    */
    public function getCoverage()
    {
        return $this->hasOne(Coverage::className(), ['id' => 'coverage_id']);
    }    
    
    /**
    * @return \yii\db\ActiveQuery
    */
    public function getMeasure()
    {
        return $this->hasOne(Measure::className(), ['id' => 'measure_id']);
    }    

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getSectorName()
    {
        return $this->sector->name;
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getMeasureName()
    {
        return $this->measure->name;
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getCoverageName()
    {
        return $this->coverage->name;
    }    

    /**
    * {@inheritdoc}
    */
     public function getTypeCode() {
        
        return $this->type->type_code;

     }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getStash()
    {
        return $this->hasOne(Stash::className(), ['regulatory_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getStashId()
    {
        return $this->stash->id;
    }

    /**
    * {@inheritdoc}
    */
    public function getOrdinance() {

        return $this->hasOne(Ordinance::className(), ['id' => 'ref_id']);

    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getRegulatoryMapStatus()
    {
        return $this->hasMany(RegulatoryMapStatus::className(), ['regulatory_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getStatus()
    {
        return $this->hasOne(Status::className(), ['id' => 'current_status']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getStatusLabel()
    {
        return $this->status->name;
    }

    /**
    * {@inheritdoc}
    */
    public function getIssuance() {

        return $this->hasOne(Issuance::className(), ['id' => 'ref_id']);

    }    

    /**
    * {@inheritdoc}
    */
    public function getTypeName() {

        return $this->type->name;

    }        

    /* Region */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['region_c' => 'region_c']);
    }

    /* Province */
    public function getProvince()
    {
        return $this->hasOne(Province::className(), ['region_c' => 'region_c', 'province_c' => 'province_c']);
    }   

     
    /* Citymun */
    public function getCitymun()
    {
        return $this->hasOne(Citymun::className(), ['region_c' => 'region_c', 'province_c' => 'province_c', 'citymun_c' => 'citymun_c']);
    }    
    
    
    // Police code no
    public function getPolicyCodeNo()
    {
        return ($this->type->type_code == 'ORD') ? $this->ordinance->ordinance_res_no : $this->issuance->issuance_no;
    } 

    // Title
    public function getTitleIssOrd()
    {
    return ($this->type->type_code == 'ORD') ? $this->ordinance->title : $this->issuance->title;
    }    

    /* Region name */
    public function getRegionM()
    {
            return $this->region->region_m;
    }   

    /* Province name */
    public function getProvinceM()
    {
        return $this->province->province_m;
    }   

    /* Citymun name */
    public function getCityMunM()
    {
        return $this->citymun->citymun_m;
    } 
    
    /**
    * {@inheritdoc}
    */

    public function getNewPolissceName() {

        return $this->new_polissce;

    } 

    /**
    * {@inheritdoc}
    */

    public function getDateSubMission() {

        return $this->date_of_approval;

    } 

    /**
    * {@inheritdoc}
    */
    public function getReasonForPolicy() {

        return $this->reasfpol;

    }
    
    /**
    * {@inheritdoc}
    */
    public function getPolicyOption() {

        return $this->policy_id;

    }     
    
}
