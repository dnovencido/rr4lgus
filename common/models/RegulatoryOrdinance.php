<?php

namespace common\models;

use niksko12\user\models\Region;
use niksko12\user\models\Province;
use niksko12\user\models\Citymun;

use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;


use Yii;

/**
 * This is the model class for table "{{%regulatory_ordinance}}".
 *
 * @property int $id
 * @property int $ordinance_id
 * @property int $information_id
 * @property int $policy_opt_id
 * @property string $rationale
 * @property string $date_created
 *
 * @property AffectedAgencyLevel[] $affectedAgencyLevels
 * @property Information $information
 * @property Ordinance $ordinance
 * @property Policy $policyOpt
 */
class RegulatoryOrdinance extends \yii\db\ActiveRecord
{
    
    /**
     * Global variables
     */
    
    //public psgc
    public $region_c, $province_c, $citymun_c;
    
    // Reference from information;
    public $department_office, $date_sub;

    //Reference from ordinance;
    public $ordinance_res_no, $eff_date_pass, $title, $description;

    //Reference from affected_agency_level;
    public $aff_ordinance_id = [];


    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return '{{%regulatory_ordinance}}';
    }   

    /**
     * {behaviors}
     */

    public function behaviors() {
        return [
            'timestamp' => [
                'class' => '\yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['date_created', 'last_updated'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['last_updated'],
                ],
                'value' => new \yii\db\Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['ordinance_id', 'information_id', 'policy_opt_id', 'rationale', 'title', 'description', 'department_office', 'date_sub', 'ordinance_res_no', 'eff_date_pass'], 'required'],
            [['ordinance_id','information_id', 'policy_opt_id'], 'integer'],
            [['date_created', 'eff_date_pass', 'aff_ordinance_id'], 'safe'],
            [['rationale'], 'string', 'max' => 255],
            [['information_id'], 'exist', 'skipOnError' => true, 'targetClass' => Information::className(), 'targetAttribute' => ['information_id' => 'id']],
            [['ordinance_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ordinance::className(), 'targetAttribute' => ['ordinance_id' => 'id']],
            [['policy_opt_id'], 'exist', 'skipOnError' => true, 'targetClass' => Policy::className(), 'targetAttribute' => ['policy_opt_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'ordinance_id', 'ordinanceResNo', 'ordinance_res_no' => 'Ordinance/Resolution No',
            'eff_date_pass' => 'Date of Effectivity',
            'information_id' => 'Information ID',
            'policy_opt_id' => 'Policy Opt ID',
            'rationale' => 'Rationale',
            'date_created' => 'Date Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAffectedAgencyLevels() {
        return $this->hasMany(AffectedAgencyLevel::className(), ['regulatory_ordinance_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAffectedOrdinances() {
        return $this->hasMany(Ordinance::className(), ['id' => 'ordinance_id'])->via('affectedAgencyLevels');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListAffectedOrdinance() {
        $ordinances = array_map(function($ordinance){
            return [
                'id'=> $ordinance->id,
                'ordinance_res_no' => $ordinance->ordinance_res_no,
                'title' => $ordinance->title
            ];
        },$this->affectedOrdinances);
        
        return $ordinances;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInformation() {
        return $this->hasOne(Information::className(), ['id' => 'information_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPolicyOpt() {
        return $this->hasOne(Policy::className(), ['id' => 'policy_opt_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdinance() {
        return $this->hasOne(Ordinance::className(), ['id' => 'ordinance_id']);
    }    

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdinanceResNo() {
        return $this->ordinance->ordinance_res_no;
    }  

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdinanceTitle() {
        return $this->ordinance->title;
    }  

    /* User information */
    public function getUserInformation() {
        return $this->hasOne(UserInfo::className(), ['user_id' => 'id']);
    }   

    /* Region */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['region_c' => 'region_c'])->via('information');
    }   

    /* Province */
    public function getProvince() {
        return $this->hasOne(Province::className(), ['region_c' => 'region_c', 'province_c' => 'province_c'])->via('information');
    }   

     
    /* Citymun */
    public function getCitymun() {
        return $this->hasOne(Citymun::className(), ['region_c' => 'region_c', 'province_c' => 'province_c', 'citymun_c' => 'citymun_c'])->via('information');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcessLevelOrd() {
        return $this->hasOne(ProcessLevel::className(), ['id' => 'level']);
    } 
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLevelMap() {
        return $this->processLevelOrd->name;
    } 

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPolicyOptionName() {
        return $this->policyOpt->name;
    }  

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLguName() {
        return (!empty($this->region->region_m)) ? (!empty($this->province->province_m)) ?  (!empty($this->citymun->citymun_m)) ? $this->region->region_m . ', ' . $this->province->province_m . ', ' . $this->citymun->citymun_m : $this->region->region_m . ', ' . $this->province->province_m   : $this->region->region_m  : '';
    }     

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOfficeName() {
       return $this->information->department_office;
    }  
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDateSub() {
       return $this->information->date_sub;
    }  
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefOrdinanceId() {
       return $this->ordinance->id;
    } 

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdinanceDesc() {
       return $this->ordinance->description;
    }    

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEffDatePass() {
       return $this->ordinance->eff_date_pass;
    } 


    /* Update Affected Agency Level 
     * @param array c
     * @param array $originalArray
     */
    public function updateAffectedAgencyLevel($aff_ordinance_id,$regulatory_ordinance_id) {
        $recordArray = AffectedAgencyLevel::find()->select(['id'])->where(['regulatory_ordinance_id' => $regulatory_ordinance_id])->all(); 

        $originalArray = array_map(function($agencyLevel){
            return $agencyLevel->id;
        }, $recordArray);

        $addItem =  array_diff($aff_ordinance_id, $originalArray);
        $removeItem =  array_diff($originalArray,$aff_ordinance_id);

        $connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction();

        $agencyLevelIds = $this->getAffectedAgencyLevelId($regulatory_ordinance_id, $aff_ordinance_id);

        try {
            
            //Flag 
            $flag = true;

            //Update data
            foreach($agencyLevelIds as $key => $row) {
                
                $agencyLevel = AffectedAgencyLevel::findOne($row['id']);
                $agencyLevel->ordinance_id = $row['id'];

                $agencyLevel->update();
            }

            if($removeItem) {
               
                $agencyLevelIds = $this->getAffectedAgencyLevelId($regulatory_ordinance_id, $removeItem);

                foreach($agencyLevelIds as $key => $row) {
                
                    $agencyLevel = AffectedAgencyLevel::findOne($row['id']);
                    $agencyLevel->delete();
                }                
            }

            if($addItem) {
               
                foreach($addItem as $key => $row) {
                
                    $agencyLevel = new AffectedAgencyLevel();

                    $agencyLevel->ordinance_id = $aff_ordinance_id[$key];
                    $agencyLevel->regulatory_ordinance_id = $regulatory_ordinance_id;
                   
                    if (!($flag = $agencyLevel->save(false))) {
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

        return $flag;
           
    }  

    public function getRegulatoryReportStatus() {
     
        return $this->hasOne(RegulatoryReportStatus::className(), ['ref_id' => 'id']);
    
    }
    
    public function getAffectedAgencyLevelId($regulatory_ordinance_id, $removeItem) {
        
        //Fetch ids of each code
        $agencyLevelIds = AffectedAgencyLevel::find()->select(['id'])->where(['regulatory_ordinance_id' => $regulatory_ordinance_id])->andWhere(['in', 'id', $removeItem])->asArray()->all();

        return $agencyLevelIds;
    }

    public function getCurrentRegulatoryReportStatus() {
        
        return $this->hasOne(RegulatoryReportStatus::className(), ['ref_id' => 'id'])->orderBy(['id' => SORT_DESC]);
    
    }

    public function getCurrentRegReportLevel() {
        
        return $this->currentRegulatoryReportStatus->level;
    
    }    

    public function getCurrentProcess() {
        
        return $this->currentRegulatoryReportStatus->process_id;
    
    }
    
    public function getProcessSubmission() {
        
        return $this->hasOne(ProcessSubmission::className(), ['process_id' => 'process_id'])->via('currentRegulatoryReportStatus')->where(['level_id' => $this->currentRegReportLevel]);
    
    }
    
    public function getNextProcessSubmission() {
        
        return $this->hasOne(ProcessSubmission::className(), ['process_id' => 'process_id'])->via('currentRegulatoryReportStatus')->where(['level_id' => $this->currentRegReportLevel + 1]);
    
    }

    public function getMaxOrder() {
        
        return $this->hasOne(ProcessSubmission::className(), ['process_id' => 'process_id'])->via('currentRegulatoryReportStatus')->max('order_c');
    
    }

    public function getProcessLevel() {
        
        return $this->hasOne(ProcessLevel::className(), ['id' => 'level'])->via('currentRegulatoryReportStatus');
    
    } 

    public function getNextProcessLevel() {
        
        return $this->hasOne(ProcessLevel::className(), ['id' => 'level'])->via('nextProcessSubmission');
    
    } 

    public function getCurrentOrder() {
        
        return $this->processSubmission->order_c;
    
    }   

    public function getCurrentLevel() {

        return $this->processLevel->name;
    
    } 

    public function getCurrentLevelId() {
        
        return $this->processLevel->id;
    
    } 

    public function getCurrentOrderVal() {
        
        return $this->processSubmission->order_c;
    }       

    public function getCurrentMaxOrder() {
        
        return $this->maxOrder->order_c;
    }

    public function getNextProcessLabel() {
       
        return (!empty($this->nextProcessLevel->name)) ? $this->nextProcessLevel->name : null ;
    
    } 
 
    public function getNextOrderVal() {
       
        return (!empty($this->nextProcessSubmission->order_c)) ?$this->nextProcessSubmission->order_c : null ;
    
    }  

    public function getStatus() {
       
        return $this->hasOne(Status::className(), ['id' => 'status'])->via('currentRegulatoryReportStatus');
    
    }
    
    public function getStatusLabel() {

        return  (!empty($this->status->name)) ? $this->status->name : '--None--' ;

    }

    public function getStatusLabelColor() {

        return  (!empty($this->status->color)) ? $this->status->color : '#BFBFBF' ;

    }    
    
}
