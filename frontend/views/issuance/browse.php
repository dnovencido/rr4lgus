<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Ordinance */

?>

<div class="ordinance-list">
    <h4>Browse Issuance</h4>
    <div class="btn-group btn-toolbar mt-3">
        <button id="choose-issuance" class="btn btn-light btn-sm btn-toolbar" data-original-title="Label - Ctrl+L" value="VF"><i class="mdi mdi-check toolbar-menu"></i> Choose </button>
    </div>   
    <div class="inner-ordinance-list mt-4">
        <?= $this->render('_list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]) ?>
    </div>
</div>