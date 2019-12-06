<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\RegulatoryMap */

$this->title = 'Add ';
$this->params['breadcrumbs'][] = ['label' => 'Regulatory Maps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="regulatory-map-create">

    <div class="card card-default">
        <div class="card-header card-header-border-bottom"> 
            <h2><?= Html::encode($this->title) ?></h2>
        </div>
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $model,
                'selection_list' => $selection_list
            ]) ?>
        </div>
    </div> <!--/.card -->

</div>
