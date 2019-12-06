<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\StashSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Stashes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stash-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Stash', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'regulatory_id',
            'date_created',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
