<?php

use yii\helpers\Html;
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $model common\models\RegulatoryOrdinance */

$this->title = 'Update Regulatory Ordinance: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Regulatory Ordinances', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="regulatory-ordinance-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'policyOptions' => $policyOptions
    ]) ?>

</div>
<?php
$agencies = JSON::encode($model->affectedAgencyLevels);
$script = <<< JS
    var agencies = $agencies;

    var uId = randomize();

    console.log(agencies);


JS;
$this->registerJs($script,\yii\web\View::POS_HEAD);
?>
?>