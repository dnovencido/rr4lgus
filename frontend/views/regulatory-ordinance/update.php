<?php

use yii\helpers\Html;
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $model common\models\RegulatoryOrdinance */

$this->title = 'Update Regulatory Ordinance: ' . $model->ordinance_res_no;
$this->params['breadcrumbs'][] = ['label' => 'Regulatory Ordinances', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ordinance_res_no, 'url' => ['view', 'id' => $model->id]];

?>
<div class="regulatory-ordinance-update">
    <div class="card card-default">
        <div class="card-header card-header-border-bottom"> 
            <h2><?= Html::encode($this->title) ?></h2>
        </div><!--/.card-header -->
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $model,
                'policyOptions' => $policyOptions
            ]) ?>
        </div><!--/.card-body -->
    </div><!--/.card -->
</div><!--/.regulatory-ordinance-update -->
<?php

$agencies = JSON::encode($model->listAffectedOrdinance);
$script = <<< JS
    $(function(){
    
        var agencies = $agencies;

        var events = new Events();

        var option = {
            data : agencies,
            container: $('#list-agency-values')
        };

        //Populate agencylist
        events.populateAgencyList(option);

    });

JS;
$this->registerJs($script,\yii\web\View::POS_READY);

?>