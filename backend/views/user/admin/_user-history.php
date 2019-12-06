<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
// use kartik\select2\Select2;
// use dosamigos\datepicker\DatePicker;

/**
 * @var yii\web\View 					$this
 * @var niksko12\user\models\User 		$user
 * @var niksko12\user\models\Profile 	$profile
 */

?>
<style>
   .modal-lg {
    width: 1200px;
  }
</style>
<?php $this->beginContent('@niksko12/user/views/admin/update.php', ['user' => $user]) ?>

<?php 
$this->registerJs($this->render('../../js/modal.js'));

        Modal::begin([
        	'header' => '<b>' . Yii::t('app', 'Change Information') . '</b>',
            'id'=>'modalView', 
            'size'=>'modal-lg',
            'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
            ]);
        echo "<div id='modalContentView'>";
        echo "<div style='text-align:center'></div></div>";
        Modal::end();
?>
<div class='row'>
	<div class="col-md-12">
		<h4> Current Information</h4>
    <div class="label-info" style="padding: 1%"><strong>Note:</strong> 
      <li>If the information below is <code>(not set)</code>, update the information in history and click <i class="glyphicon glyphicon-pencil"></i> icon then select your particular service, division, section, designation and position (if any) then click update button. </li>
    </div><br>
     <?= Html::button('<i class="glyphicon glyphicon-pencil"></i> Change Information', ['value'=>Url::to(['/user/update-information/update-information','id' => empty($user->id) ? '' : $user->id, 'action' => Yii::$app->controller->action->id]), 'class' => 'btn btn-info btn-xs modalButton pull-right', 'title' => 'Update']) ?>
		<table class="table table-condensed table-striped table-bordered">
			<tbody>
				<tr>
					<th>Service</th>
					<td><?= empty($userService->service->SERVICE_ACRONYM) ? '(not set)' : $userService->service->SERVICE_ACRONYM ?></td>
				</tr>
				<tr>
					<th>Division</th>
					<td><?= empty($userDivision->division->DIVISION_ACRONYM) ? '(not set)' : $userDivision->division->DIVISION_ACRONYM ?></td>
				</tr>
				<tr>
					<th>Section</th>
					<td><?= empty($userSection->section->SECTION_M) ? '(not set)' : $userSection->section->SECTION_M ?></td>
				</tr>
				<tr>
					<th>Designation</th>
					<td><?= empty($userDesignation->designation->designation) ? '(not set)' : $userDesignation->designation->designation ?></td>
				</tr>
				<tr>
					<th>Position</th>
					<td><?= empty($userPosition->position->POSITION_M) ? '(not set)' : $userPosition->position->POSITION_M ?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>



<hr>


<div class="row">
<div class="col-md-12">
	<h4> User History Positions and Offices </h4>
<div class="panel-group" id="accordion">
  <div class="panel panel-default ">
    <div class="panel-heading"  data-toggle="collapse" data-parent="#accordion" href="#collapse1">
      <h4 class="panel-title">
        Service/Bureau History
      </h4>
    </div>
    <div id="collapse1" class="panel-collapse collapse">
      <div class="panel-body">
      	<?= GridView::widget([
            'dataProvider' => $service,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                  'label' => 'Office',
                  'value' => function($model){
                    return 'Central Office';
                  }
                ],
                [
                    'attribute' => 'SERVICE_C',
                    'value' => 'service.SERVICE_ACRONYM',
                ],
                'START_DATE',
                'END_DATE',
                ['class' => 'yii\grid\ActionColumn',
                  'template' => '{update}',
                  'buttons'=>[
                      'update' => function ($url, $model) {
                                  return Html::button('<i class="glyphicon glyphicon-pencil"></i>', ['value'=>Url::to(['/user/service-user-history/update','id' => $model->id, 'action' => Yii::$app->controller->action->id]), 'class' => 'btn btn-info btn-xs modalButton', 'title' => 'Update']);
                              }]],
            ],
        ]); ?>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#collapse2">
      <h4 class="panel-title">
        Division History
      </h4>
    </div>
    <div id="collapse2" class="panel-collapse collapse">
      <div class="panel-body">
      	<?= GridView::widget([
            'dataProvider' => $division,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'division.office.OFFICE_M',
                [
                    'attribute' => 'DIVISION_C',
                    'value' => 'division.DIVISION_ACRONYM',
                ],
                'START_DATE',
                'END_DATE',
                ['class' => 'yii\grid\ActionColumn',
                  'template' => '{update}',
                  'buttons'=>[
                      'update' => function ($url, $model) {
                                  return Html::button('<i class="glyphicon glyphicon-pencil"></i>', ['value'=>Url::to(['/user/division-user-history/update','id' => $model->id, 'action' => Yii::$app->controller->action->id]), 'class' => 'btn btn-info btn-xs modalButton', 'title' => 'Update']);
                              }]],
            ],
        ]); ?>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#collapse3">
      <h4 class="panel-title">
        Section
      </h4>
    </div>
    <div id="collapse3" class="panel-collapse collapse">
      <div class="panel-body">
      	<?= GridView::widget([
            'dataProvider' => $section,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'section.office.OFFICE_M',
                [
                    'attribute' => 'SECTION_C',
                    'value' => 'section.SECTION_ACRONYM',
                ],
                'START_DATE',
                'END_DATE',
                ['class' => 'yii\grid\ActionColumn',
                  'template' => '{update}',
                  'buttons'=>[
                      'update' => function ($url, $model) {
                                  return Html::button('<i class="glyphicon glyphicon-pencil"></i>', ['value'=>Url::to(['/user/section-user-history/update','id' => $model->id, 'action' => Yii::$app->controller->action->id]), 'class' => 'btn btn-info btn-xs modalButton', 'title' => 'Update']);
                              }]],
            ],
        ]); ?>
      </div>
    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#collapse4">
      <h4 class="panel-title">
        Designation
      </h4>
    </div>
    <div id="collapse4" class="panel-collapse collapse">
      <div class="panel-body">
      	<?= GridView::widget([
            'dataProvider' => $designation,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'designation.office.OFFICE_M',
                [
                    'attribute' => 'DESIGNATION_C',
                    'value' => 'designation.designation',
                ],
                'START_DATE',
                'END_DATE',
                ['class' => 'yii\grid\ActionColumn',
                  'template' => '{update}',
                  'buttons'=>[
                      'update' => function ($url, $model) {
                                  return Html::button('<i class="glyphicon glyphicon-pencil"></i>', ['value'=>Url::to(['/user/designation-user-history/update','id' => $model->id, 'action' => Yii::$app->controller->action->id]), 'class' => 'btn btn-info btn-xs modalButton', 'title' => 'Update']);
                              }]],
            ],
        ]); ?>
      </div>
    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#collapse5">
      <h4 class="panel-title">
        Position
      </h4>
    </div>
    <div id="collapse5" class="panel-collapse collapse">
      <div class="panel-body">
      	<?= GridView::widget([
            'dataProvider' => $position,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' => 'POSITION_C',
                    'value' => 'position.POSITION_M',
                ],
                'START_DATE',
                'END_DATE',
                ['class' => 'yii\grid\ActionColumn',
                  'template' => '{update}',
                  'buttons'=>[
                      'update' => function ($url, $model) {
                                  return Html::button('<i class="glyphicon glyphicon-pencil"></i>', ['value'=>Url::to(['/user/position-user-history/update','id' => $model->id, 'action' => Yii::$app->controller->action->id]), 'class' => 'btn btn-info btn-xs modalButton', 'title' => 'Update']);
                              }]],
            ],
        ]); ?>
      </div>
    </div>
  </div>
</div>
</div>
</div>

<?php $this->endContent() ?>
