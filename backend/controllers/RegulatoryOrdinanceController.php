<?php

namespace backend\controllers;

use Yii;
use common\models\RegulatoryOrdinance;
use common\models\RegulatoryOrdinanceSearch;
use common\models\Policy;
use common\models\Information;
use common\models\Ordinance;
use common\models\Type;
use common\models\AffectedAgencyLevel;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

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
        ];
    }

    /**
     * Lists all RegulatoryOrdinance models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RegulatoryOrdinanceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

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
        $policyOptions = ArrayHelper::map(Policy::find()->all(), 'id', 'name');

        if ($model->load(Yii::$app->request->post())) {

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
                    
                    $model->level =  (Yii::$app->user->identity->psgc['region']) ? ( Yii::$app->user->identity->psgc['province'] !== null &&  Yii::$app->user->identity->psgc['region'] !== null) ? (Yii::$app->user->identity->psgc['citymun'] !== null && Yii::$app->user->identity->psgc['province'] !== null && Yii::$app->user->identity->psgc['region'] !== null) ? 4 : 3 : 2 : 1;

                    // if error occurs on saving to model regulatory ordinance 
                    if (!($flag = $model->save(false))) {
                        $transaction->rollBack();
                        break;
                    }                   

                    //for affected agency level                     
                    for($i=0; $i<count($model->code); $i++){
                        $affected_agency_level = new AffectedAgencyLevel();
                        
                        $affected_agency_level->regulatory_ordinance_id = $model->id;
                        $affected_agency_level->code = $model->code[$i];
                        $affected_agency_level->title = $model->title_agency[$i];

                        if (!($flag = $affected_agency_level->save(false))) {
                            $transaction->rollBack();
                            break;
                        }
                    
                    }

                }

                if ($flag) {

                    $transaction->commit();

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

                        echo "<pre>";
                        print_r($model->errors);
                        exit;

                        $transaction->rollback();

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


            }  catch(Exception $e) {
                
                $transaction->rollback();
            
            }   
        }

        return $this->render('create', [
            'model' => $model,
            'policyOptions' => $policyOptions
        ]);
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

        //Bind values
        $model->department_office = $model->officeName;
        $model->date_sub = $model->dateSub;
        $model->ordinance_res_no = $model->ordinanceResNo;
        $model->eff_date_pass = $model->effDatePass;
        $model->title = $model->ordinanceTitle;
        $model->description = $model->ordinanceDesc;

        $policyOptions = ArrayHelper::map(Policy::find()->all(), 'id', 'name');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
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
