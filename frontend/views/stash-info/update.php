<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\StashInfo */

$this->title = 'Update Stash Info: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Stash Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="stash-info-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
