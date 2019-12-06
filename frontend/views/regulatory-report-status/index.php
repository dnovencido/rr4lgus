<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\RegulatoryReportStatusSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Regulatory Report Statuses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="regulatory-report-status-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Regulatory Report Status', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'reportTitle',
            'statusLabel',
            'levelLabel',

            'date_created',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
