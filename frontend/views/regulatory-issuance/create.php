<?php

use yii\helpers\Html;
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $model common\models\RegulatoryIssuance */

$this->title = 'Create Regulatory Issuance';
$this->params['breadcrumbs'][] = ['label' => 'Regulatory Issuances', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['template' => "<li class='breadcrumb-item'>{link}</li>", 'label' => $this->title ];
?>
<div class="regulatory-issuance-create">
    <div class="card card-default">
        <div class="card-header card-header-border-bottom"> 
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $model,
                'listMenu' => $listMenu
            ]) ?>
        </div>
    </div> <!--/.card -->
</div> <!--/.regulatory-issuance-create -->
<?php
$issuances = JSON::encode((isset($initData['aff_issuances'])) ? $initData['aff_issuances'] : null);
$listMenu = JSON::encode($listMenu);

//List menu
$script = <<< JS
    var listMenu = $listMenu;
JS;

$this->registerJs($script,\yii\web\View::POS_HEAD);

$script = <<< JS
    $(function(){
        var listMenu = $listMenu;
        var issuances = $issuances;

        var optionIssuances = {
            data : issuances,
            container: $('#list-issuance-values')
        };

        var events = new Events();

        //Populate issuance list
        events.populateIssuanceList(optionIssuances);
    });    
JS;
$this->registerJs($script,\yii\web\View::POS_READY);

?>