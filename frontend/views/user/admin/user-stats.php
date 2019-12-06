<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\web\View;
use yii\helpers\Url;

?>
<style type="text/css">
.modal-xl{
	width : 90%;
}
</style>

<div class="user-index">
	<div class="table-responsive">
	<?= GridView::widget([
			'dataProvider' => $dataProvider,
			'columns' => [
				['class' => 'yii\grid\SerialColumn'],
				[
					'label'=>'Office',
					'attribute'=>'OFFICE_C',
					'value'=> function ($model){
							return ($model->userinfo && $model->userinfo->OFFICE_C) ? $model->userinfo->office->OFFICE_M : '';
					},
				],
				[
					'label'=>'Region',
					'attribute'=>'REGION_C',
					'value'=> function ($model){
							return ($model->userinfo && $model->userinfo->REGION_C) ? $model->userinfo->region->region_m : '';
					},
				],
				[
					'label'=>'Province',
					'value'=> function ($model){
							$value = '';
							if($model->userinfo && $model->userinfo->PROVINCE_C && $model->userinfo->province && $model->userinfo->province->province_m){
								$value = $model->userinfo->province->province_m;
							}
							return $value;
					},
				],
				[
					'label'=>'City / Municipality',
					'value'=> function ($model){
							$value = '';
							if($model->userinfo && $model->userinfo->CITYMUN_C && $model->userinfo->citymun && $model->userinfo->citymun->citymun_m){
								$value = $model->userinfo->citymun->citymun_m;
							}
							return $value;
					},
				],
				[
					'attribute'=>'keyname',
					'label'=>'Full Name',
					'value'=> function ($model){
							return ($model->userinfo) ? $model->userinfo->fullName : '';
					},
					'options'=>['style' => 'white-space:wrap;'],
				],
				[
					'label'=>'Employee ID No.',
					'value'=> function ($model){
							return ($model->userinfo) ? $model->userinfo->EMP_N : '';
					},
				],
				'username',
				'email:email',
				[
					'class' => 'yii\grid\ActionColumn',
					'template' => '{view} {update}',
					'buttons' => [
						'update' => function ($url, $model, $key) {
							if(Yii::$app->user->can('Administrator') || Yii::$app->user->can('SuperAdministrator')){
								return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update', 'id'=>$model->id], ['title'=>'Update']);
							}else if(Yii::$app->user->can('RegionalAdministrator') && $model->userinfo->OFFICE_C != 5 && $model->userinfo->REGION_C == Yii::$app->user->identity->userinfo->REGION_C){
								return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update', 'id'=>$model->id], ['title'=>'Update']);
							}
						},
					]
				],
			]
		]);
	?>
	</div>
</div>
<?php

	$script = '
		$("#userStatsModalHeader").html("'.$title.'");
	';
	$this->registerJs($script, View::POS_END);
?>
