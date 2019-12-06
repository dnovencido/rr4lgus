<?php

use yii\helpers\Html;
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $model common\models\RegulatoryIssuance */

$this->title = 'Update Regulatory Issuance: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Regulatory Issuances', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="regulatory-issuance-update">
    <div class="card card-default">
        <div class="card-header card-header-border-bottom"> 
            <h2><?= Html::encode($this->title) ?></h2>
        </div><!--/.card-header -->
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $model,
                'listMenu' => $listMenu
            ]) ?>
        </div><!--/.card-body -->
    </div><!--/.card -->
</div><!--/.regulatory-issuance-update -->
<?php

$issuances = JSON::encode($model->listAffectedIssuances);
$impacts = JSON::encode($model->listImpactIssuances);
$listMenu = JSON::encode($listMenu);

//List menu
$script = <<< JS
    var listMenu = $listMenu;
JS;

$this->registerJs($script,\yii\web\View::POS_HEAD);

$script = <<< JS
    $(function(){
    
        var issuances = $issuances;
        var impacts = $impacts;
        var listMenu = $listMenu;

        var events = new Events();

        var optionIssuances = {
            data : issuances,
            container: $('#list-issuance-values')
        };
        
        var optionImpacts = {
            data : impacts,
            menu : listMenu,
            container: $('#list-impact-values')
        };

        //Populate issuance list
        events.populateIssuanceList(optionIssuances);
        
        //Populate impact issuance
        events.populateImpactIssuance(optionImpacts);        

    });

JS;
$this->registerJs($script,\yii\web\View::POS_READY);

?>