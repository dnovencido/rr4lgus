<?php

namespace common\models;

use Yii;

/**
 * This is the model class for shared transactions".
 *
 */
class Transaction extends \yii\db\ActiveRecord
{
    public function saveRegulatoryOrdinance($model) {

        $connection = \Yii::$app->db;

        $transaction = $connection->beginTransaction();
        
        try {

            $flag = true;

            //Ordinance model
            $ordinance = new Ordinance();

            $ordinance->description = $model->description;
            $ordinance->ordinance_res_no = $model->ordinance_res_no;
            $ordinance->title = $model->title;
            $ordinance->eff_date_pass = $model->eff_date_pass;

            //Information model
            $information = new Information();
            $information->department_office = $model->department_office;
            $information->date_sub = $model->date_sub;

            //PSGC
            $information->region_c = Yii::$app->user->identity->psgc['region'];
            $information->province_c = Yii::$app->user->identity->psgc['province'];
            $information->citymun_c = Yii::$app->user->identity->psgc['citymun'];

            if($ordinance->save() && $information->save())  {

                //bind model values
                $ordinance_id = $ordinance->id;
                $information_id = $information->id;
                $pr_option_id =  $model->policy_opt_id;
                $rationale = $model->rationale;
                
                //for regulatory ordinance
                $model->ordinance_id =  $ordinance_id;
                $model->information_id = $information_id;
                $model->policy_opt_id = $pr_option_id;
                $model->user_id =  Yii::$app->user->id;
                $model->level = Yii::$app->user->identity->processType['level'];
                
                // if error occurs on saving to model regulatory ordinance 
                if (!($flag = $model->save(false))) {
                    $transaction->rollBack();
                }                   

                //for affected agency level                     
                for($i=0; $i<count($model->aff_ordinance_id); $i++){
                    $affected_ordinances = new AffectedAgencyLevel();
                    
                    $affected_ordinances->regulatory_ordinance_id = $model->id;
                    $affected_ordinances->ordinance_id = $model->aff_ordinance_id[$i];

                    if (!($flag = $affected_ordinances->save(false))) {
                        $transaction->rollBack();
                    }
                
                }

                //regulatory report status;
                $regulatoryStatus = new RegulatoryReportStatus();

                $regulatoryStatus->ref_id = $model->id;
                $regulatoryStatus->status = Status::findByCode(['ENC'])->id;  

                //set initial submission process
                $process = Process::findOne(Yii::$app->user->identity->processType['id']);
                $regulatoryStatus->level = $process->initialProcess;
                $regulatoryStatus->process_id = $process->id;
                $regulatoryStatus->type_id = Type::findByCode('ORD')->id;

                // if error occurs on saving to model regulatory report status
                if (!($flag = $regulatoryStatus->save(false))) {
                    $transaction->rollBack();
                }    

            }

            if ($flag) {
                $transaction->commit(); 

            } else {

                $transaction->rollback();

            }


        }  catch(Exception $e) {
            
            $transaction->rollback();
        
        }
        
        return $model->id;

    }

    public function updateRegulatoryOrdinance($model) {

        $connection = \Yii::$app->db;

        $transaction = $connection->beginTransaction();           

        try {
            // update ordinances information
            $ordinance = Ordinance::findOne($model->ordinance_id);

            $ordinance->ordinance_res_no = $model->ordinance_res_no;
            $ordinance->title = $model->title;
            $ordinance->eff_date_pass = $model->eff_date_pass;
            $ordinance->description = $model->description;

            $ordinance->update();

            if ($ordinance->update() !== false) {
                $transaction->commit();
            }
            
            // update affected agency level
            $updateAgencyLevel = $model->updateAffectedAgencyLevel($model->aff_ordinance_id,$model->id);
           
        } catch(Exception $e) {
            
            $transaction->rollback();
        
        } 

    }

    public function saveRegulatoryIssuance($model) {

        $connection = \Yii::$app->db;

        $transaction = $connection->beginTransaction();
        
        try {

            $flag = true;

            //Ordinance model
            $issuance = new Issuance();

            $issuance->description = $model->description;
            $issuance->issuance_no = $model->issuance_no;
            $issuance->title = $model->title;

            //Information model
            $information = new Information();
            $information->department_office = $model->department_office;
            $information->date_sub = $model->date_sub;

            //PSGC
            $information->region_c = Yii::$app->user->identity->psgc['region'];
            $information->province_c = Yii::$app->user->identity->psgc['province'];
            $information->citymun_c = Yii::$app->user->identity->psgc['citymun'];

            if($issuance->save() && $information->save())  {

                //bind model values
                $issuance_no = $issuance->id;
                $information_id = $information->id;
                $pr_option_id =  $model->policy_opt_id;
                
                //for regulatory ordinance
                $model->issuance_id =  $issuance_no;
                $model->information_id = $information_id;
                $model->policy_opt_id = $pr_option_id;
                $model->user_id =  Yii::$app->user->id;
                
                $model->level =  (Yii::$app->user->identity->psgc['region']) ? ( Yii::$app->user->identity->psgc['province'] !== null &&  Yii::$app->user->identity->psgc['region'] !== null) ? (Yii::$app->user->identity->psgc['citymun'] !== null && Yii::$app->user->identity->psgc['province'] !== null && Yii::$app->user->identity->psgc['region'] !== null) ? 4 : 3 : 2 : 1;

                // if error occurs on saving to model regulatory ordinance 
                if (!($flag = $model->save(false))) {
                    $transaction->rollBack();
                }                   

                //for affected issuances  
                if(!empty($model->aff_issuance_id)) {                          
                    for($i=0; $i<count($model->aff_issuance_id); $i++){
                        $affected_issuances = new AffectedIssuance();
                        
                        $affected_issuances->regulatory_issuance_id = $model->id;
                        $affected_issuances->issuance_id = $model->aff_issuance_id[$i];

                        if (!($flag = $affected_issuances->save(false))) {
                            $transaction->rollBack();
                        }
                    
                    }
                 }

                //for impact of issuances   
                if(!empty($model->stakeholder)) {
                    for($i=0; $i<count($model->stakeholder); $i++){
                        
                        $impactIssuance = new ImpactIssuance();
                        
                        $impactIssuance->regulatory_issuance_id = $model->id;
                        $impactIssuance->stakeholder = $model->stakeholder[$i];
                        $impactIssuance->nature_id = $model->nature_id[$i];
                        $impactIssuance->magnitude_id = $model->magnitude_id[$i];
                        $impactIssuance->duration = $model->duration[$i];
                        $impactIssuance->issuance_ent_id = $model->issuance_ent_id[$i];
    
                        if (!($flag = $impactIssuance->save(false))) {
                            $transaction->rollBack();
                        }
                    }
                }

                //regulatory report status;
                $regulatoryStatus = new RegulatoryReportStatus();

                $regulatoryStatus->ref_id = $model->id;
                $regulatoryStatus->status = Status::findByCode(['ENC'])->id;  

                //set initial submission process
                $process = Process::findOne(Yii::$app->user->identity->processType['id']);
                $regulatoryStatus->level = $process->initialProcess;
                $regulatoryStatus->level = $process->id;

                // if error occurs on saving to model regulatory report status
                if (!($flag = $regulatoryStatus->save(false))) {
                    $transaction->rollBack();
                }                    
            }

            if ($flag) {

                $transaction->commit();  
                
            } else {

                $transaction->rollback();

            }

        }  catch(Exception $e) {
            
            $transaction->rollback();
        
        }

        return $model->id;
    }

    public function updateRegulatoryIssuance($model) {

        $connection = \Yii::$app->db;

        $transaction = $connection->beginTransaction();           

        try {
            // update ordinances information
            $issuance = Issuance::findOne($model->issuance_id);

            $issuance ->issuance_no = $model->issuance_no;
            $issuance->title = $model->title;
            $issuance->description = $model->description;

            $issuance->update();

            if ($issuance->update() !== false) {
                $transaction->commit();
            }
            
            // update affected agency level
            //$updateIssuance = $model->updateAffectedIssuances($model->aff_issuance_id,$model->id);

            $updateImpactIssuance = $model->updateImpactIssuances($model);
           
        } catch(Exception $e) {
            
            $transaction->rollback();
        
        } 

    }

    public function updateRegulatoryMap($model) {

        $connection = \Yii::$app->db;

        $transaction = $connection->beginTransaction();    

        try {

            $flag = true;

            //determine type
            switch ($model->typeCode) {
                case 'ORD':

                    //ordinance
                    $ordinance = Ordinance::findOne($model->ref_id);

                    $ordinance->ordinance_res_no = $model->policy_code_no;
                    $ordinance->title = $model->title;
                    $ordinance->eff_date_pass = $model->date_of_approval;
                    
                    if (!($flag = $ordinance->update(false)) && !$flag = $model->update(false)) {
                        $transaction->rollback();
                    }

                    break;

                default:

                    //issuance
                    $issuance = Issuance::findOne($model->ref_id);

                    $issuance->issuance_no = $model->policy_code_no;
                    $issuance->title = $model->title;

                    if (!($flag = $issuance->update(false)) && !$flag = $model->update(false)) {
                        $transaction->rollback();
                    }                        

            } 

            if ($flag) {

                //commit transaction
                $transaction->commit();
            
            }                   
           
            return $flag;

        } catch(Exception $e) {
            
            $transaction->rollback();
        
        } 
    }

    public function setLabel($data) {

        $connection = \Yii::$app->db;

        $transaction = $connection->beginTransaction();    
       
        try {

            $flag = true;

            foreach($data['regulatory_id'] as $row) {

                $model = new RegulatoryMapStatus();
    
                $model->regulatory_id = $row;
                $model->status = Status::findByCode($data['status'])->id;

                if(!($flag = $model->save(false))){
                    $transaction->rollback();
                }
               
            }

            $regulatoryMap =  new RegulatoryMap();
            $updateRegulatoryMap = $regulatoryMap->updateAll(['current_status' => $model->status], ['id' => $data['regulatory_id']]);

            if(!($flag = $updateRegulatoryMap)){
                $transaction->rollback();
            }
            
            if ($flag) {

                //commit transaction
                $transaction->commit();
            
            }   
            
            return $flag;

        } catch(Exception $e) {
            
            $transaction->rollback();
        
        }     
        
    } 

}
