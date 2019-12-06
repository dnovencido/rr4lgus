<?php

namespace frontend\controllers;

use Yii;
use common\models\RegulatoryIssuance;
use common\models\RegulatoryIssuanceSearch;
use common\models\Policy;
use common\models\Information;
use common\models\Ordinance;
use common\models\Type;
use common\models\AffectedAgencyLevel;
use common\models\Transaction;
use common\models\Nature;
use common\models\Magnitude;
use common\models\Restrict;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * RegulatoryIssuanceController implements the CRUD actions for RegulatoryIssuance model.
 */
class RegulatoryIssuanceController extends Controller
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
     * Lists all RegulatoryIssuance models.
     * @return mixed
     */
    public function actionIndex()
    {   
        $restriction = new Restrict();
        $searchModel = new RegulatoryIssuanceSearch();

        //Filter record by id and psgc
        $dataProvider = $restriction->owner($searchModel);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RegulatoryIssuance model.
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
     * Creates a new RegulatoryIssuance model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RegulatoryIssuance();
        $transaction = new Transaction();

        $listMenu = [
            'policyOptions' =>  ArrayHelper::map(Policy::find()->all(), 'id', 'name'),
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
            'listMenu' => $listMenu
        ]);
    }

    /**
     * Updates an existing RegulatoryIssuance model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $transaction = new Transaction();

        $listMenu = [
            'policyOptions' =>  ArrayHelper::map(Policy::find()->all(), 'id', 'name'),
            'natureOptions' => ArrayHelper::map(Nature::find()->all(), 'id', 'name'),
            'magnitudeOptions' => ArrayHelper::map(Magnitude::find()->all(), 'id', 'name')
        ];
        //Bind values
        $model->department_office = $model->officeName;
        $model->date_sub = $model->dateSub;
        $model->issuance_no = $model->issuanceNo;
        $model->title = $model->issuanceTitle;
        $model->description = $model->issuanceDesc;

        if ($model->load(Yii::$app->request->post())) {

            //update regulatory ordinance
            $transaction->updateRegulatoryIssuance($model);

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'listMenu' => $listMenu
        ]);
    }

    /**
     * Deletes an existing RegulatoryIssuance model.
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
     * Finds the RegulatoryIssuance model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RegulatoryIssuance the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RegulatoryIssuance::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
