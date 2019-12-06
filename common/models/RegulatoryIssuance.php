<?php

namespace common\models;

use niksko12\user\models\Region;
use niksko12\user\models\Province;
use niksko12\user\models\Citymun;

use Yii;

/**
 * This is the model class for table "regulatory_issuance".
 *
 * @property int $id
 * @property int $issuance_id
 * @property int $information_id
 * @property int $policy_opt_id
 * @property int $level
 * @property int $user_id
 * @property string $date_created
 * @property string $last_updated
 */
class RegulatoryIssuance extends \yii\db\ActiveRecord
{

    /**
     * Global variables
     */
    
    //public psgc
    public $region_c, $province_c, $citymun_c;
        
    // Reference from information;
    public $department_office, $date_sub;

    //Reference from issuance;
    public $issuance_no, $title, $description;

    //Reference from affected_issuance;
    public $aff_issuance_id = [];
    public $issuance_ent_id = [];
    public $stakeholder = [];
    public $nature_id = [];
    public $magnitude_id = [];
    public $duration = [];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'regulatory_issuance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['issuance_id', 'information_id', 'policy_opt_id', 'level', 'user_id', 'department_office', 'date_sub', 'issuance_no', 'title', 'date_sub'], 'required'],
            [['issuance_id', 'information_id', 'policy_opt_id', 'level', 'user_id'], 'integer'],
            [['description'], 'string'],
            [['date_created', 'last_updated', 'stakeholder', 'nature_id', 'magnitude_id', 'duration', 'aff_issuance_id', 'issuance_ent_id'], 'safe'],
            [['information_id'], 'exist', 'skipOnError' => true, 'targetClass' => Information::className(), 'targetAttribute' => ['information_id' => 'id']],
            [['ordinance_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ordinance::className(), 'targetAttribute' => ['ordinance_id' => 'id']],
            [['policy_opt_id'], 'exist', 'skipOnError' => true, 'targetClass' => Policy::className(), 'targetAttribute' => ['policy_opt_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'issuance_id' => 'Issuance ID',
            'information_id' => 'Information ID',
            'level' => 'Level',
            'user_id' => 'User ID',
            'date_created' => 'Date Created',
            'last_updated' => 'Last Updated',
            'issuanceNo' => 'Issuance No',
            'issuanceTitle' => 'Title',
            'levelMap' => 'Level',
            'policyOptName' => 'Policy Option'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAffectedIssuances()
    {
        return $this->hasMany(AffectedIssuance::className(), ['regulatory_issuance_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImpactIssuances()
    {
        return $this->hasMany(ImpactIssuance::className(), ['regulatory_issuance_id' => 'id']);
    }    

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNature()
    {
        return $this->hasOne(Nature::className(), ['id' => 'nature_id'])->via('impactIssuances');
    }    

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMagnitude()
    {
        return $this->hasOne(Magnitude::className(), ['id' => 'magnitude_id'])->via('impactIssuances');
    }    

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInformation()
    {
        return $this->hasOne(Information::className(), ['id' => 'information_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getLevelMap()
    {
        return ($this->information->region_c !== null) ? ($this->information->province_c !== null && $this->information->region_c !== null) ? ($this->information->citymun_c !== null && $this->information->province_c !== null && $this->information->region_c !== null) ? 'City/Municipality' : 'Province' : 'Region' : 'Central';
    }    
 
    /**
    * @return \yii\db\ActiveQuery
    */
    public function getIssuance()
    {
        return $this->hasOne(Issuance::className(), ['id' => 'issuance_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getIssuanceNo()
    {
        return (!empty ($this->issuance->issuance_no) ? $this->issuance->issuance_no : null);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIssuanceDesc()
    {
       return $this->issuance->description;
    }       

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getIssuanceTitle()
    {
        return (!empty ($this->issuance->title) ? $this->issuance->title : null);
    }  

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPolicyOpt()
    {
        return $this->hasOne(Policy::className(), ['id' => 'policy_opt_id']);
    }    

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPolicyOptName()
    {
        return $this->policyOpt->name;
    }     
    
    /* User information */
    public function getUserInformation()
    {
        return $this->hasOne(UserInfo::className(), ['user_id' => 'id']);
    }   

    /* Region */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['region_c' => 'region_c'])->via('information');
    }   

    /* Province */
    public function getProvince()
    {
        return $this->hasOne(Province::className(), ['region_c' => 'region_c', 'province_c' => 'province_c'])->via('information');;
    }   

     
    /* Citymun */
    public function getCitymun()
    {
        return $this->hasOne(Citymun::className(), ['region_c' => 'region_c', 'province_c' => 'province_c', 'citymun_c' => 'citymun_c'])->via('information');;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLguName()
    {
       return $this->region->region_m.', '.  $this->province->province_m .' , '. $this->citymun->citymun_m;
    }  
    
    /**
    * @return \yii\db\ActiveQuery
    */
    public function getOfficeName()
    {
       return $this->information->department_office;
    } 
    
    /**
    * @return \yii\db\ActiveQuery
    */
    public function getDateSub()
    {
       return $this->information->date_sub;
    } 

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndAffectedIssuances()
    {
        return $this->hasMany(Issuance::className(), ['id' => 'issuance_id'])->via('affectedIssuances');
    }  
      
    /**
    * @return \yii\db\ActiveQuery
    */
    public function getListAffectedIssuances()
    {
        return array_map(function($issuance){
            return [
                'id'=> $issuance->id,
                'issuance_no' => $issuance->issuance_no,
                'title' => $issuance->title
            ];
        },$this->indAffectedIssuances);
        
    } 

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getListImpactIssuances()
    {
       return array_map(function($impact) {
            return [
                'id' => $impact->id,
                'issuance_ent_id' => $impact->issuance_ent_id,
                'stakeholder' => (!empty($impact->stakeholder)) ? $impact->stakeholder : null ,
                'nature_id' => $impact->nature_id,
                'nature_m' => (!empty($this->nature->name)) ? $this->nature->name : null ,
                'magnitude_id' => $impact->magnitude_id,
                'magnitude_m' => (!empty($this->magnitude->name)) ? $this->magnitude->name : null,
                'duration' => $impact->duration,
            ];
       }, $this->impactIssuances);
    }     
    
    /* Update Affected Issuances
     * @param array $aff_issuance_id
     * @param int $regulatory_issuance_id
     */
    public function updateAffectedIssuances($aff_issuance_id,$regulatory_issuance_id)
    {
        $recordArray = AffectedIssuance::find()->select(['id'])->where(['regulatory_issuance_id' => $regulatory_issuance_id])->all(); 

        $originalArray = array_map(function($issuance){
            return $issuance->id;
        }, $recordArray);

        $addItem =  array_diff($aff_issuance_id, $originalArray);
        $removeItem = array_diff($originalArray,$aff_issuance_id);

        $connection = \Yii::$app->db;
        
        $transaction = $connection->beginTransaction();

        $issuanceIds = $this->getAffectedIssuanceId($regulatory_issuance_id, $aff_issuance_id);

        try {
            
            //Flag 
            $flag = true;

            //Update data
            foreach($issuanceIds as $key => $row) {
                
                $affectedIssuance = AffectedIssuance::findOne($row['id']);
                $affectedIssuance->issuance_id = $row['id'];

                $affectedIssuance->update();
            }

            if($removeItem) {
               
                $issuanceIds  = $this->getAffectedIssuanceId($regulatory_issuance_id, $removeItem);

                foreach($issuanceIds as $key => $row) {
                    $affectedIssuance = AffectedIssuance::findOne($row['id']);
                    $affectedIssuance->delete();
                }                
            }

            if($addItem) {
               
                foreach($addItem as $key => $row) {
                
                    $affectedIssuance = new AffectedIssuance();

                    $affectedIssuance->issuance_id = $aff_issuance_id[$key];
                    $affectedIssuance->regulatory_issuance_id = $regulatory_issuance_id;
                   
                    if (!($flag = $affectedIssuance->save(false))) {
                        $transaction->rollBack();
                    }
                
                }                
            }            

        }  catch(Exception $e) {
                    
            $transaction->rollback();
        
        } 

        //if transaction succeed
        if ($flag) {
            $transaction->commit();
        } 

        return $aff_issuance_id;
           
    }      

    public function getAffectedIssuanceId($regulatory_issuance_id, $removeItem) {

        //Fetch ids of each code
        $issuanceIds = AffectedIssuance::find()->select(['id'])->where(['regulatory_issuance_id' => $regulatory_issuance_id])->andWhere(['in', 'id', $removeItem])->asArray()->all();

        return $issuanceIds;
    }  
    
    
    public function updateImpactIssuances($model) {
        $recordArray = ImpactIssuance::find()->select(['issuance_ent_id'])->where(['regulatory_issuance_id' => $model->id])->all(); 

        $originalArray = array_map(function($impact){
            return $impact->issuance_ent_id;
        }, $recordArray);

        $addItem =  array_diff($model->issuance_ent_id, $originalArray);
        $removeItem = array_diff($originalArray,$model->issuance_ent_id);        

        $connection = \Yii::$app->db;
        
        $transaction = $connection->beginTransaction();
        
        try {
            
            //Flag 
            $flag = true;

            $impactIssuanceIds = $this->getImpactIssuanceId($model->id, $model->issuance_ent_id);

            //Update data
            foreach($impactIssuanceIds as $key => $row) {
                
                $impactIssuance = impactIssuance::findOne($row['id']);
                $impactIssuance->regulatory_issuance_id = $model->id;
                $impactIssuance->stakeholder = $model->stakeholder[$key];
                $impactIssuance->nature_id =  $model->nature_id[$key];
                $impactIssuance->magnitude_id = $model->magnitude_id[$key];
                $impactIssuance->duration = $model->duration[$key];

                $impactIssuance->update();
            }

            if($removeItem) {
                
                //impacts to be remove
                $issuanceIds  = $this->getImpactIssuanceId($model->id, $removeItem);

                foreach($issuanceIds as $key => $row) {
                    $impactIssuance = ImpactIssuance::findOne($row['id']);
                    $impactIssuance->delete();
                }                
            }

            if($addItem) {
               
                foreach($addItem as $key => $row) {
                
                    $impactIssuance = new ImpactIssuance();

                    $impactIssuance->regulatory_issuance_id = $model->id;
                    $impactIssuance->issuance_ent_id = $model->issuance_ent_id[$key];
                    $impactIssuance->stakeholder = $model->stakeholder[$key];
                    $impactIssuance->nature_id = $model->nature_id[$key];
                    $impactIssuance->magnitude_id = $model->magnitude_id[$key];
                    $impactIssuance->duration = $model->duration[$key];
                   
                    if (!($flag = $impactIssuance->save(false))) {
                        $transaction->rollBack();
                    }
                
                }                
            }            

            //if transaction succeed
            if ($flag) {
                $transaction->commit();

                return $model->id;
            } 


        }  catch(Exception $e) {
                    
            $transaction->rollback();
        
        }

        
    }

    public function getImpactIssuanceId($regulatory_issuance_id, $issuance_ent_id) {

        //Fetch ids of each code
        return ImpactIssuance::find()->select(['id'])->where(['regulatory_issuance_id' => $regulatory_issuance_id])->andWhere(['in', 'issuance_ent_id', $issuance_ent_id])->asArray()->all();
   
    }      
}
