<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Ordinance */

$this->title = 'Add Ordinance';
$this->params['breadcrumbs'][] = ['label' => 'Ordinances', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ordinance-create">
    <div class="card card-default">
        <div class="card-header card-header-border-bottom"> 
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $model
            ]) ?>
        </div>
    </div>
</div>
