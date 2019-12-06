<?php

namespace frontend\controllers;

use Yii;
use common\models\RegulatoryOrdinance;
use common\models\RegulatoryOrdinanceSearch;
use common\models\RegulatoryReportStatus;
use common\models\Policy;
use common\models\Information;
use common\models\Ordinance;
use common\models\Type;
use common\models\AffectedAgencyLevel;
use common\models\Transaction;
use common\models\Restrict;
use common\models\Status;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

/**
 * RegulatoryOrdinanceController implements the CRUD actions for RegulatoryOrdinance model.
 */
class RegulatoryOrdinanceController extends Controller
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
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create', 'index', 'view', 'update', 'delete', 'submit'],
                        'roles' => ['CityMunOffice', 'ProvincialOffice'],
                    ],                    
                ],
            ],            
        ];
    }

    /**
     * Lists all RegulatoryOrdinance models.
     * @return mixed
     */
    public function actionIndex()
    {   
        $restriction = new Restrict();
        $searchModel = new RegulatoryOrdinanceSearch();

        //Filter record by id and psgc  
        $dataProvider = $restriction->owner($searchModel);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }

    /**
     * Displays a single RegulatoryOrdinance model.
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
     * Creates a new RegulatoryOrdinance model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RegulatoryOrdinance();
        $transaction = new Transaction();
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

                return $this->redirect(['view', 'id' => $model->id]);               
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
                              
            }
        }

        return $this->render('create', [
            'model' => $model,
            'policyOptions' => $policyOptions
        ]);
    }


    /**
     * Creates a new Regulatory Map Report Status model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionSubmit($id)
    {   
        $model = $this->findModel($id);

        if(!empty($model->nextOrderVal)) {
            $regulatoryReportStatus = new RegulatoryReportStatus();

            $regulatoryReportStatus->ref_id = $id;
            $regulatoryReportStatus->status = Status::findByCode(['SUB'])->id;  
            $regulatoryReportStatus->level = $model->nextOrderVal;
            $regulatoryReportStatus->process_id = $model->currentProcess;

            $regulatoryReportStatus->save();
        }

        return $this->redirect(['view', 'id' => $model->id]);     
        
    }
        
    /**
     * Updates an existing RegulatoryOrdinance model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $transaction = new Transaction();

        $policyOptions = ArrayHelper::map(Policy::find()->all(), 'id', 'name');

        //Bind values
        $model->department_office = $model->officeName;
        $model->date_sub = $model->dateSub;
        $model->ordinance_res_no = $model->ordinanceResNo;
        $model->eff_date_pass = $model->effDatePass;
        $model->title = $model->ordinanceTitle;
        $model->description = $model->ordinanceDesc;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            //update regulatory ordinance
            $transaction->updateRegulatoryOrdinance($model);

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'policyOptions' => $policyOptions
        ]);
    }

    /**
     * Deletes an existing RegulatoryOrdinance model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the RegulatoryOrdinance model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RegulatoryOrdinance the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RegulatoryOrdinance::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
