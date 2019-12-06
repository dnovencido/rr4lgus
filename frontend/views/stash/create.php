<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Stash */

$this->title = 'Create Stash';
$this->params['breadcrumbs'][] = ['label' => 'Stashes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stash-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
