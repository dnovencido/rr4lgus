<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model searchModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-md-4">
			<?= $form->field($model, 'OFFICE_C')->widget(Select2::classname(), [
					'data' => ArrayHelper::map($offices, 'OFFICE_C', 'OFFICE_M') + ["99" => 'Not Set'],
					'options' => [	'placeholder' => '    Nothing Selected   ',
									'multiple' => true,
					],
					'pluginOptions' => [
						'allowClear' => true,
					],
				]);
			?>
			<?php 
				$provincesurl = \yii\helpers\Url::to(['/user/province/province-list']);
				echo $form->field($model, 'REGION_C')->widget(Select2::classname(), [
				'data' => ArrayHelper::map($regions, 'region_c', 'region_m'),
				'options' => ['placeholder' => 'Region','multiple' => false,'class'=>'region-select'],
				'pluginOptions' => [
					'allowClear' => count($regions) > 1 ? true : false,
					],
				'pluginEvents'=>[
					'select2:select'=>'
						function(){
							var vals = this.value;
							$.ajax({
								url: "'.$provincesurl.'",
								data: {region:vals}
								
							}).done(function(result) {
								var h;

								/*for(var i=0; i<result.length; i++){
									var id = result[i].id;
									var text = result[i].text;
									h+="<option value=\'"+id+"\' >"+text+"</option>";
								}*/
							   // 
							   // $("#province-select").select2("destroy");
								$(".province-select").html("").select2({ data:result, theme:"krajee", width:"100%",placeholder:"Province",
									allowClear: true,});
								$(".province-select").select2("val","");
							});
						}'
					]
				]);
			?>
			<?php 
				$citymunsurl = \yii\helpers\Url::to(['/user/citymun/citymun-list']);
				echo $form->field($model, 'PROVINCE_C')->widget(Select2::classname(), [
					'data' => ArrayHelper::map($provinces, 'province_c', 'province_m'),
					'options' => ['placeholder' => 'Province','multiple' => false,'class'=>'province-select'],
					'pluginOptions' => [
						'allowClear' => count($provinces) > 1 ? true : false
					],
					'pluginEvents'=>[
						'select2:select'=>'
							function(){
								var vals = this.value;
								$.ajax({
									url: "'.$citymunsurl.'",
									data: {province:vals}
									
								}).done(function(result) {
									var h;
									$(".citymun-select").html("").select2({ data:result, theme:"krajee", width:"100%",placeholder:"City/Municipality",
										allowClear: true,});
									$(".citymun-select").select2("val","");
								});
							}'

					]
				]);
			?>
			<?php 
				echo $form->field($model, 'CITYMUN_C')->widget(Select2::classname(), [
				'data' => ArrayHelper::map($citymuns, 'citymun_c', 'citymun_m'),
				'options' => ['placeholder' => 'City/Municipality','multiple' => false,'class'=>'citymun-select'],
				'pluginOptions' => [
					'allowClear' => count($citymuns) > 1 ? true : false
				],
				]);
			?>
			
			<?php 
				if(Yii::$app->user->can('Administrator') || Yii::$app->user->can('SuperAdministrator')){
					echo $form->field($model, 'SERVICE_C')->widget(Select2::classname(), [
						'data' => ArrayHelper::map($services, 'SERVICE_C', 'SERVICE_M') + ["99" => 'Not Set'],
						'options' => [	'placeholder' => '    Nothing Selected   ',
										'multiple' => true,
						],
						'pluginOptions' => [
							'allowClear' => true,
						],
					]);
				}
			?>
        </div>
		<div class="col-md-3">
            <?= $form->field($model, 'keyname')->textInput()->label('Name') ?>
            <?= $form->field($model, 'username')->textInput() ?>
            <?= $form->field($model, 'emp_n')->textInput() ?>
            <?= $form->field($model, 'email')->textInput() ?>		
		</div>
		<?php if($applications){ ?>
		<div class="col-md-3">
			<?php
				$authitemsurl = \yii\helpers\Url::to(['/user-management/application/authitem-list']);
				echo $form->field($model, 'app_id')->label('Application')->widget(Select2::classname(), [
					'data' => $applications,
					'options' => [	'placeholder' => '    Nothing Selected   ',
					],
					'pluginOptions' => [
						'allowClear' => true,
					],
					'pluginEvents'=>[
						'select2:select'=>'
							function(){
								var vals = this.value;
								$.ajax({
									url: "'.$authitemsurl.'",
									data: {app_id:vals}
									
								}).done(function(result) {
									var h;
									$(".authitem-select").html("").select2({ data:result, theme:"krajee", width:"100%",placeholder:"    Nothing Selected   ",
										allowClear: true,});
									$(".authitem-select").select2("val","");
								});
							}'

					]
				]);
			?>
			<?php
				$items = [];
				if(!empty($authItems)){
					$items = ArrayHelper::map($authItems, 'id', 'name', 'type');
					$items['Roles'] = isset($items[1]) ? $items[1] : [];
					$items['Permissions'] = isset($items[2]) ? $items[2] : [];
					unset($items[1]);
					unset($items[2]);
				}
				
				echo $form->field($model, 'auth_item_id')->widget(Select2::classname(), [
				'data' => $items,
				'options' => ['placeholder' => '    Nothing Selected   ','multiple' => true, 'class'=>'authitem-select'],
				'pluginOptions' => [
					'allowClear' => true,
				],
				]);
				
				if(Yii::$app->getModule('user')->intranetMode):
					echo $form->field($model, 'hris_link')->widget(Select2::classname(), [
						'data' => ['Yes'=>'Yes', 'No'=>'No'],
						'options' => [	'placeholder' => '    Nothing Selected   '],
						'pluginOptions' => [
							'allowClear' => true,
						],
					]);
				endif;
			?>
		</div>
		<?php } ?>
		<div class="col-md-2">
			<?= $form->field($model, 'has_role')->widget(Select2::classname(), [
					'data' => ['Yes'=>'Yes', 'No'=>'No'],
					'options' => [	'placeholder' => '    Nothing Selected   '],
					'pluginOptions' => [
						'allowClear' => true,
					],
				]);
			?>
			<?= $form->field($model, 'confirmed_at')->label('Confirmation Status')->widget(Select2::classname(), [
					'data' => ['Yes'=>'Confirmed', 'No'=>'Unconfirmed'],
					'options' => [	'placeholder' => '    Nothing Selected   '],
					'pluginOptions' => [
						'allowClear' => true,
					],
				]);
			?>
			<?= $form->field($model, 'blocked_at')->label('Block Status')->widget(Select2::classname(), [
					'data' => ['Yes'=>'Blocked', 'No'=>'Not Blocked'],
					'options' => [	'placeholder' => '    Nothing Selected   '],
					'pluginOptions' => [
						'allowClear' => true,
					],
				]);
			?>
			<?= $form->field($model, 'sorting')->label('Sorting')->widget(Select2::classname(), [
					'data' => ['name'=>'By Full Name', 'lgu'=>'By LGU'],
					'options' => [	'placeholder' => '    Nothing Selected   '],
					'pluginOptions' => [
						'allowClear' => true,
					],
				]);
			?>			
		</div>
        <div class="col-md-12">
            <?= Html::submitButton('Filter', ['class' => 'btn btn-primary']) ?>
			<?= Html::a('<i class="fa fa-refresh">&nbsp;</i>Reset', ['/user/admin/index'], ['class' => 'btn btn-default']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
