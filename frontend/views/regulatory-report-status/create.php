<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\RegulatoryReportStatus */

$this->title = 'Create Regulatory Report Status';
$this->params['breadcrumbs'][] = ['label' => 'Regulatory Report Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="regulatory-report-status-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
