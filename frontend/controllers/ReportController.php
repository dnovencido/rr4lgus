<?php

namespace frontend\controllers;

use Yii;
use common\models\RegulatoryReportStatus;
use common\models\RegulatoryReportStatusSearch;
use common\models\Status;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class ReportController extends Controller
{
    public function actionSubmitted()
    {
        $searchModel = new RegulatoryReportStatusSearch();

        $searchModel->status = Status::findByCode(['SUB'])->id;

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('/regulatory-report-status/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}
