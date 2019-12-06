<?php

namespace backend\controllers;

use Yii;
use common\models\Record;
use common\models\Information;
use common\models\Ordinance;
use common\models\RecordSearch;
use common\models\Policy;
use common\models\Type;

use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RecordController implements the CRUD actions for Record model.
 */
class RecordController extends Controller
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
     * Lists all Record models.
     * @return mixed
     */
    public function actionIndex($type)
    {
        $searchModel = new RecordSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Record model.
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
     * Creates a new Record model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Record();
        $policyOptions = ArrayHelper::map(Policy::find()->all(), 'id', 'name');
        $types = ArrayHelper::map(Type::find()->all(), 'id', 'name');

        if ($model->load(Yii::$app->request->post())) {

            $connection = \Yii::$app->db;

            $transaction = $connection->beginTransaction();
    
            try {

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
                $information->region_c =(!empty(Yii::$app->user->identity->psgc['region'])) ? Yii::$app->user->identity->psgc['region'] : null ;
                $information->province_c = (!empty(Yii::$app->user->identity->psgc['province'])) ? Yii::$app->user->identity->psgc['province'] : null ;;
                $information->citymun_c = (!empty(Yii::$app->user->identity->psgc['citymun'])) ? Yii::$app->user->identity->psgc['citymun'] : null ;

                if($ordinance->save() && $information->save())  {
                    
                    $model->save();

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
                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'danger',
                        'duration' => 5000,
                        'icon' => 'fa fa-users',
                        'message' => 'There was an error in saving data.',
                        'title' => 'Failed',
                        'positonY' => 'top',
                        'positonX' => 'right'
                    ]);
                }

            } catch(Exception $e) {
                
                $transaction->rollback();
            
            }   
        }

        return $this->render('create', [
            'model' => $model,
            'policyOptions' => $policyOptions,
            'types' => $types
        ]);


    }

    /**
     * Updates an existing Record model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Record model.
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
     * Finds the Record model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Record the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Record::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
