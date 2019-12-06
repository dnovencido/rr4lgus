<?php

namespace frontend\controllers;

use Yii;
use common\models\RegulatoryOrdinance;
use common\models\RegulatoryIssuance;
use common\models\RegulatoryMap;
use common\models\RegulatoryMapSearch;
use common\models\Type;
use common\models\Sector;
use common\models\Stash;
use common\models\StashSearch;
use common\models\StashInfo;
use common\models\StashInfoSearch;
use common\models\Coverage;
use common\models\Measure;
use common\models\Policy;
use common\models\Ordinance;
use common\models\Information;
use common\models\Issuance;
use common\models\Transaction;
use common\models\Status;
use common\models\RegulatoryMapStatus;
use common\models\Nature;
use common\models\Magnitude;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Response;


/**
 * RegulatoryMapController implements the CRUD actions for RegulatoryMap model.
 */
class RegulatoryMapController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all RegulatoryMap models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RegulatoryMapSearch();

        //Filter by verified record
        $searchModel->status_id = Status::findByCode(['VF'])->id;

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RegulatoryMap model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    /**
     * Read excel values to insert
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionUpload()
    {   
        $searchModel = new StashInfoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('upload', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }

    /**
     * View uploaded entries
     * @return mixed
     */
    public function actionFile($id)
    {   
        $stashInfo = StashInfo::findOne($id);
        $searchModel = new StashSearch();

        //Filter by verified record
        $searchModel->status_id = Status::findByCode(['UP'])->id;
        $searchModel->stash_info_id = $id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
       
        return $this->render('file-content', [
            'stashInfo' => $stashInfo,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);       

    }

    /**
     * Creates a new RegulatoryOrdinance model.
     * If creation is successful, the browser will be redirected to the 'ordinance view' page.
     * @param integer $id
     */
    public function actionReportForOrdinance($id)
    {
        $model = new RegulatoryOrdinance();
        $ordinance = new Ordinance();
        $regulatoryMap = RegulatoryMap::find()->where(['ref_id' => $id])->one();
        $transaction = new Transaction();

        //Bind value for policy option
        $model->policy_opt_id =$regulatoryMap->policy_id;

        //Initial values for affected ordinances
        $aff_ordinances = [];

        //Check if ordinance is not retained | RT
        if($regulatoryMap->policyCode !== 'RT') {

            //Find affected ordinances
            $aff_ordinances [] = $ordinance->findOne($id);

        } else {

            //Retain ordinances
            $model->title = $regulatoryMap->newPolissceName;
            $model->eff_date_pass = $regulatoryMap->dateSubMission;
            $model->rationale = $regulatoryMap->reasonForPolicy;

        }

        $policyOptions = ArrayHelper::map(Policy::find()->all(), 'id', 'name');

        if ($model->load(Yii::$app->request->post())) {


            $model->id = $transaction->saveRegulatoryOrdinance($model);
            if($model->id) {
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'success',
                    'duration' => 5000,
                    'icon' => 'fa fa-users',
                    'message' => 'Successfully saved ordinance',
                    'title' => 'Success',
                    'positonY' => 'top',
                    'positonX' => 'right'
                ]);

                return $this->redirect(['/regulatory-ordinance/view', 'id' => $model->id]);               
            } else {

                Yii::$app->getSession()->setFlash('danger', [
                    'type' => 'danger',
                    'duration' => 5000,
                    'icon' => 'fa fa-users',
                    'message' => 'There was an error in saving data.',
                    'title' => 'Failed',
                    'positonY' => 'top',
                    'positonX' => 'right'
                ]);  
                              
            };
        }

        return $this->render('/regulatory-ordinance/create', [
            'model' => $model,
            'policyOptions' => $policyOptions,
            'initData' => [
                'aff_ordinances' => $aff_ordinances
            ]            
        ]);        
        
    }
    
    /**
     * Creates a new RegulatoryOrdinance model.
     * If creation is successful, the browser will be redirected to the 'issuance view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionReportForIssuance($id)
    {
        $model = new RegulatoryIssuance();
        $issuance = new Issuance();
        $transaction = new Transaction();
        $regulatoryMap = RegulatoryMap::find()->where(['ref_id' => $id])->joinWith(['issuance'])->one();
        
        //Bind values
        $model->policy_opt_id = $regulatoryMap->policy_id;

        //Initial values for affected issuances
        $aff_issuances = [];

         //Check if issuance is not retained | RT
        if($regulatoryMap->policyCode !== 'RT') {

            //Find affected issuance
            $aff_issuances[] = $issuance->findOne($id);

        } else {

            //Retain issuances
            $model->issuance_no = $regulatoryMap->issuance->issuance_no;
            $model->title = $regulatoryMap->issuance->title;
            $model->description = $regulatoryMap->issuance->description;

        }

        //Menu list
        $listMenu = [
            'policyOptions' => ArrayHelper::map(Policy::find()->all(), 'id', 'name'),
            'natureOptions' => ArrayHelper::map(Nature::find()->all(), 'id', 'name'),
            'magnitudeOptions' => ArrayHelper::map(Magnitude::find()->all(), 'id', 'name')
        ];        

        if ($model->load(Yii::$app->request->post())) {

            $model->id = $transaction->saveRegulatoryIssuance($model);
            if($model->id) {
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'success',
                    'duration' => 5000,
                    'icon' => 'fa fa-users',
                    'message' => 'Successfully saved ordinance',
                    'title' => 'Success',
                    'positonY' => 'top',
                    'positonX' => 'right'
                ]);

                return $this->redirect(['/regulatory-issuance/view', 'id' => $model->id]);               
            } else {

                Yii::$app->getSession()->setFlash('danger', [
                    'type' => 'danger',
                    'duration' => 5000,
                    'icon' => 'fa fa-users',
                    'message' => 'There was an error in saving data.',
                    'title' => 'Failed',
                    'positonY' => 'top',
                    'positonX' => 'right'
                ]);  
                              
            };
        }

        return $this->render('/regulatory-issuance/create', [
            'model' => $model,
            'listMenu' => $listMenu,
            'initData' => [
                'aff_issuances' => $aff_issuances
            ]
        ]);       
       
    }
    
    /**
     * Creates a new RegulatoryMap model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RegulatoryMap();
        $ordinance = new Ordinance();
        $issuance = new Issuance();

        $types = ArrayHelper::map(Type::find()->all(), 'id', 'name');
        $sectors = ArrayHelper::map(Sector::find()->all(), 'id', 'name');
        $coverages = ArrayHelper::map(Coverage::find()->all(), 'id', 'name');
        $measures = ArrayHelper::map(Measure::find()->all(), 'id', 'name');
        $policies = ArrayHelper::map(Policy::find()->all(), 'id', 'name');
        
        //get all seletions
        $selection_list = [
            'types' => $types,
            'sectors' => $sectors,
            'coverages'=> $coverages,
            'measures' => $measures,
            'policies' => $policies
        ];

        if ($model->load(Yii::$app->request->post()) ) {

            $connection = \Yii::$app->db;

            $transaction = $connection->beginTransaction();

            $flag = true;
            
            try {

                switch ($model->typeCode) {
                    case 'ORD':

                        $ordinance->ordinance_res_no = $model->policy_code_no;
                        $ordinance->title = $model->title;
                        $ordinance->eff_date_pass = $model->date_of_approval;
                        
                        if($ordinance->save(false)) {
                            //set as reference id to ordinance/issuance
                            $model->ref_id = $ordinance->id;
                        }

                        break;

                    default:
                        
                        $issuance->issuance_no = $model->policy_code_no;
                        $issuance->title = $model->title;

                        if($ordinance->save(false)) {
                            //set as reference id to ordinance/issuance
                            $model->ref_id = $issuance->id;
                        }

                }   

                //regulatory map
                $model->hash_id = $model->generateID();
                $model->region_c =  Yii::$app->user->identity->psgc['region'];
                $model->province_c = Yii::$app->user->identity->psgc['province'];
                $model->citymun_c = Yii::$app->user->identity->psgc['citymun']; 

                
                if(!($flag = $model->save(false))) {
                    $transaction->rollback();
                }

                if($flag) {
                    $transaction->commit();    
                }
                
                return $this->redirect(['view', 'id' => $model->id]);

            }  catch(Exception $e) {
                    
                $transaction->rollback();
            
            }  

        }

        return $this->render('create', [
            'model' => $model,
            'selection_list' => $selection_list
        ]);
    }

    /**
     * Updates an existing RegulatoryMap model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {   
        $transaction = new Transaction();
        
        $model = $this->findModel($id);
        $model->policy_code_no = $model->policyCodeNo;
        $model->title = $model->titleIssOrd;

        $types = ArrayHelper::map(Type::find()->all(), 'id', 'name');
        $sectors = ArrayHelper::map(Sector::find()->all(), 'id', 'name');
        $coverages = ArrayHelper::map(Coverage::find()->all(), 'id', 'name');
        $measures = ArrayHelper::map(Measure::find()->all(), 'id', 'name');
        $policies = ArrayHelper::map(Policy::find()->all(), 'id', 'name');
        
        //get all seletions
        $selection_list = [
            'types' => $types,
            'sectors' => $sectors,
            'coverages'=> $coverages,
            'measures' => $measures,
            'policies' => $policies
        ];
                
        if ($model->load(Yii::$app->request->post())) {
            $status = $transaction->updateRegulatoryMap($model);

            if($status) {

                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'success',
                    'title' => 'Success',
                    'icon' => 'glyphicon glyphicon-remove-sign',
                    'message' => 'Successfully update',
                    'showSeparator' => true,
                    'pluginOptions' => [
                        'showProgressbar' => true,
                        'placement' => [
                            'from' => 'top',
                            'align' => 'right',
                        ]
                    ]
                ]);

                return $this->redirect(['/regulatory-map/view', 'id' => $model->id]);               

            } else {

                Yii::$app->getSession()->setFlash('info', [
                    'type' => 'info',
                    'title' => 'Info',
                    'icon' => 'glyphicon glyphicon-remove-sign',
                    'message' => 'No changes were made',
                    'showSeparator' => true,
                    'pluginOptions' => [
                        'showProgressbar' => true,
                        'placement' => [
                            'from' => 'top',
                            'align' => 'right',
                        ]
                    ]
                ]); 
                              
            };            
        }

        return $this->render('update', [
            'model' => $model,
            'selection_list' => $selection_list
        ]);
    }

    /**
     * Updates an existing RegulatoryMap model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return json
     */
    public function actionUpdateFileContent($id)
    {   
        
        $transaction = new Transaction();
        
        $model = $this->findModel($id);
        $model->policy_code_no = $model->policyCodeNo;
        $model->title = $model->titleIssOrd;

        $types = ArrayHelper::map(Type::find()->all(), 'id', 'name');
        $sectors = ArrayHelper::map(Sector::find()->all(), 'id', 'name');
        $coverages = ArrayHelper::map(Coverage::find()->all(), 'id', 'name');
        $measures = ArrayHelper::map(Measure::find()->all(), 'id', 'name');
        $policies = ArrayHelper::map(Policy::find()->all(), 'id', 'name');

        //get all seletions
        $selection_list = [
            'types' => $types,
            'sectors' => $sectors,
            'coverages'=> $coverages,
            'measures' => $measures,
            'policies' => $policies
        ];

        if (Yii::$app->request->isAjax) {

            if ($model->load(Yii::$app->request->post())) {

                Yii::$app->response->format = Response::FORMAT_JSON;

                $status = $transaction->updateRegulatoryMap($model);

                return $data = [
                    'status' => $status,
                    'id' => $model->stashId,
                    'policy_code_no' => $model->policy_code_no,
                    'title' => $model->title,
                    'type' => Type::findOne($model->type_id)->name,
                    'date_created' => $model->date_created
                ];
                
            } else {

                return $this->renderAjax('update', [
                    'model' => $model,
                    'selection_list' => $selection_list
                ]);
            }
        }

    }

    /**
     * Updates an existing label
     * If update is successful, this function will return JSON response
     * @param integer $id
     * @return json
     */
    public function actionSetLabel()
    {       
        $data = Yii::$app->request->getBodyParams();
        $transaction = new Transaction();
    
        if (Yii::$app->request->isAjax) {

            if(!empty($data['regulatory_id'])) {
                
                Yii::$app->response->format = Response::FORMAT_JSON;

                $model = $transaction->setLabel($data);

                return $model;
            } else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
           
        }

    }

    /**
     * Deletes an existing RegulatoryMap model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the RegulatoryMap model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RegulatoryMap the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RegulatoryMap::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
