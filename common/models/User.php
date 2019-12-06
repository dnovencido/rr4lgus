<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

use niksko12\user\models\User as BaseUser;
use niksko12\user\models\Office;
use niksko12\user\models\Region;
use niksko12\user\models\Province;
use niksko12\user\models\Citymun;
use niksko12\user\models\UserInfo;

class User extends BaseUser
{     

    /* User's First Name */
    public function getFirstName()
    {
        return ($this->userinfo->FIRST_M !== null) ? $this->userinfo->FIRST_M : 'Not found'; 
    }

    /* Office */
    public function getTblOffice()
    {
        return $this->hasOne(Office::className(), ['OFFICE_C' => 'OFFICE_C'])->via('userinfo');
    }   

     /* User information */
    public function getUserInformation()
    {
        return $this->hasOne(UserInfo::className(), ['user_id' => 'id']);
    }   

     /* Region */
    public function getTblregion()
    {
        return $this->hasOne(Region::className(), ['REGION_C' => 'REGION_C']);
    }   

     /* Province */
    public function getTblprovince() {
        return $this->hasOne(Province::className(), ['REGION_C' => 'REGION_C', 'PROVINCE_C' => 'PROVINCE_C']);
    }   

    
    /* Citymun */
    public function getTblCitymun() {
        return $this->hasOne(Citymun::className(), ['REGION_C' => 'REGION_C', 'PROVINCE_C' => 'PROVINCE_C', 'CITYMUN_C' => 'CITYMUN_C']);
    }


    /* Citymun */
    public function getTblCitymunType() {
        return $this->hasOne(Citymun::className(), ['REGION_C' => 'REGION_C', 'PROVINCE_C' => 'PROVINCE_C', 'CITYMUN_C' => 'CITYMUN_C'])->via('userInformation');
    }

    /* User's Office*/
    public function getOffice() {
        return ($this->tblOffice->OFFICE_M != null) ? $this->tblOffice->OFFICE_M : 'Not found';
    }

    public function getUserRole() {
        
        $user = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);

        return  (!empty($user)) ? array_keys($user)[0] : null;
    
    }

    /* User's PSGC*/
    public function getPsgc()
    {

        $psgc = [
            'region' => $this->userInformation->REGION_C ,
            'province' => $this->userInformation->PROVINCE_C,
            'citymun'=> $this->userInformation->CITYMUN_C
        ];

        return $psgc;
    }

    /* User's PSGC*/
    public function getProcessType()
    {

        // User role
        $userRole = $this->userRole;

        //Set process and current level
        if(!empty($userRole)) {
            switch ($userRole) {
                case 'CityMunOffice':
                    $type = $this->tblCitymunType->lgu_type;

                    break;
                
                case 'ProvincialOffice':
                    $type = 'PROV';

                    break;  

                case 'RegionalOffice':
                    $type = 'REG';

                    break; 

                default:
                    $type = 'CENTRAL';
                    break;
            }
        }

        $processType = ProcessType::find()->where(['auth_item' => $userRole, 'type' => $type])->one();

        return [
            'id' => (!empty($processType->process->id)) ? $processType->process->id : null,
            'level' => (!empty($processType->level)) ? $processType->level: null,
        ];

    }
}