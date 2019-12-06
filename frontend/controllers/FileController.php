<?php

namespace frontend\controllers;

use common\models\RegulatoryMap;
use common\models\Ordinance;
use common\models\Information;
use common\models\Issuance;
use common\models\Type;
use common\models\Sector;
use common\models\Coverage;
use common\models\Measure;
use common\models\Policy;
use common\models\Stash;
use common\models\StashInfo;
use common\models\Status;
use common\models\RegulatoryMapStatus;
use common\models\AffectedAgencyLevel;

use Yii;
use yii\web\Controller;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\web\UploadedFile;

class FileController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
		$behaviors['bootstrap'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];

        return $behaviors;
    }


    /**
     * Read excel values to insert
     * 
     * @return mixed
     */
    public function actionStashFile()
    {   

        $data = Yii::$app->request->getBodyParams();
        $files = UploadedFile::getInstancesByName('file');

        //build object file
        $objectFile = array_map(function($file){
            return ['name' => $file->name, 'temp_name' => $file->tempName];
        },$files);


        //stash info
        $stashInfo = new StashInfo();
        $stashInfo->filename = $objectFile[0]['name'];

        $objPHPExcel = \PHPExcel_IOFactory::load($objectFile[0]['temp_name']);
        
        $workSheet = $objPHPExcel->getActiveSheet();

        if($workSheet->getTitle() == 'Stocktaking-Sheet') {
            $highestRow = $workSheet->getHighestRow();
            $highestCol = $workSheet->getHighestColumn();

            $sheetData = $workSheet->rangeToArray("A6:".$highestCol."".$highestRow, null, true, true, false);

            $sheetArray = array_map(function($sheet) {
                return [
                    'policy_code_no' => $sheet[0],
                    'type_id' => Type::findByCode($sheet[2])->id,
                    'type_code' => Type::findByCode($sheet[2])->type_code,
                    'title' => $sheet[3],
                    'date_of_approval'=> $sheet[4],
                    'legal_bases' => $sheet[5],
                    'sector_id' => Sector::findByCode($sheet[7])->id,
                    'coverage_id' => Coverage::findByCode($sheet[9])->id,
                    'measure_id' => Measure::findByCode($sheet[11])->id,
                    'policy_id' => Policy::findByCode($sheet[13])->id,
                    'reasfpol' => $sheet[14],
                    'new_polissce' => $sheet[15],
                    'remarks' => $sheet[16]
                ];
            },$sheetData);
            
            try {
                $connection = \Yii::$app->db;

                $transaction = $connection->beginTransaction();
                
                $flag = true;
                $dataArray = [];
                
                foreach($sheetArray as $row) {
                    
                    $model = new RegulatoryMap();

                    switch ($row['type_code']) {
                        case 'ORD':

                            $ordinance = new Ordinance();
    
                            $ordinance->ordinance_res_no = $row['policy_code_no'];
                            $ordinance->title = $row['title'];
                            $ordinance->eff_date_pass = $row['date_of_approval'];

                            if($ordinance->save(false)) {
                                //set as reference id to ordinance/issuance
                                $model->ref_id = $ordinance->id;
                            }
                            
                            break;
    
                        default:

                            $issuance = new Issuance();

                            $issuance->issuance_no = $row['policy_code_no'];
                            $issuance->title = $row['title'];
    
                            if($issuance->save(false)) {
                                //set as reference id to ordinance/issuance
                                $model->ref_id = $issuance->id;
                            }                        
    
                    }  

                    //regulatory map
                    $model->hash_id = $model->generateID();
                    $model->region_c =  Yii::$app->user->identity->psgc['region'];
                    $model->province_c = Yii::$app->user->identity->psgc['province'];
                    $model->citymun_c = Yii::$app->user->identity->psgc['citymun'];  
                    
                    //Set status as uploaded
                    $model->current_status = Status::findByCode('UP')->id;
                    $model->attributes = $row;

                    //check errors upon saving on regulatory map info
                    if(!($flag = $model->save(false))) {
                        $transaction->rollback();
                    }             

                    //check errors upon saving on stash info
                    if(!($flag = $stashInfo->save(false))) {
                        $transaction->rollback();
                    }   

                    //stash
                    $stash = new Stash();
                    $stash->regulatory_id = $model->id;
                    $stash->stash_info_id = $stashInfo->id;
                    
                    //check errors upon saving on stash
                    if(!($flag = $stash->save(false))) {
                        $transaction->rollback();
                    }

                    //regulatory map status
                    $regulartory_map_status = new RegulatoryMapStatus();
                    $regulartory_map_status->regulatory_id = $model->id;
                    $regulartory_map_status->status = Status::findByCode(['UP'])->id;  
                                     
                    //check errors upon saving on regulatory map status
                    if(!($flag = $regulartory_map_status->save(false))) {
                        $transaction->rollback();
                    }    

                    $dataArray[] = [
                        'policy_code_no' => $model->policyCodeNo,
                        'title' => $model->title,
                        'date_of_approval' => $model->date_of_approval,
                        'legal_bases' => $model->legal_bases,
                        'type_desc' => $model->typeName,
                        'sector_desc' => $model->sectorName,
                        'coverage_desc' => $model->coverageName,
                        'measure_desc' => $model->measureName,
                        'policy_desc' => $model->policyName
                    ];
                }

                if($flag) {
                    $transaction->commit();  
                    
                    $response = [
                        'code' => 200,
                        'data' => $dataArray
                    ];
                }      
                
            }  catch(Exception $e) {
                
                $transaction->rollback();
            
            } 

        } else {
            $response = [
                'code' => 500,
                'data' => []
            ];
        }
    
        return $response;
    }    
}