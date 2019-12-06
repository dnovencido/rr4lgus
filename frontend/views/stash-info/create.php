<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\StashInfo */

$this->title = 'Create Stash Info';
$this->params['breadcrumbs'][] = ['label' => 'Stash Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stash-info-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
