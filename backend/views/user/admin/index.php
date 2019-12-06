<?php



use niksko12\user\models\UserSearch;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\web\View;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\export\ExportMenu;

/**
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 * @var UserSearch $searchModel
 */

$this->title = Yii::t('user', 'Manage users');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('/_alert', [
    'module' => Yii::$app->getModule('user'),
]) ?>


<?php Pjax::begin() ?>

<div class="card card-default">
	<div class="card-header card-header-border-bottom">
		<h2><?= $this->title ?> </h2>
	</div><!-- /.card-header -->
	<div class="card-body">
	<div class="table-responsive">
	<?= GridView::widget([
		'dataProvider' 	=> $dataProvider,
		//'filterModel'  	=> $searchModel,
		'layout'  		=> "{items}\n{pager}",
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],
			[
				'label'=>'Office',
				'attribute'=>'OFFICE_C',
				'value'=> function ($model){
						return ($model->userinfo && $model->userinfo->OFFICE_C) ? $model->userinfo->office->OFFICE_M : '';
				},
				'visible' => (!$searchModel->OFFICE_C || (is_array($searchModel->OFFICE_C) && count($searchModel->OFFICE_C) > 1)),
			],
			[
				'label'=>'Region',
				'attribute'=>'REGION_C',
				'value'=> function ($model){
						return ($model->userinfo && $model->userinfo->REGION_C) ? $model->userinfo->region->region_m : '';
				},
				'visible' => (Yii::$app->user->can('RegionalAdministrator') || in_array($searchModel->OFFICE_C, [5])) ? false : true,
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
				'visible' => (in_array($searchModel->OFFICE_C, [5])) ? false : true,
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
				'visible' => (in_array($searchModel->OFFICE_C, [5])) ? false : true,
			],
			[
				'label'=>'Bureau/Service',
				'value'=>function($model){
					return ($model->userinfo && $model->userinfo->userservice && $model->userinfo->userservice->service) ? $model->userinfo->userservice->service->SERVICE_M : '';
				},
				'visible' => (Yii::$app->user->can('Administrator') || Yii::$app->user->can('SuperAdministrator')) ? true : false,
			],
			[
				'attribute'=>'keyname',
				'label'=>'Full Name',
				'value'=> function ($model){
						return ($model->userinfo) ? $model->userinfo->fullName : '';
				},
			],
			'username',
			'email:email',
			'userinfo.MOBILEPHONE',
			[
				'attribute' => 'registration_ip',
				'value' => function ($model) {
					return $model->registration_ip == null
						? '<span class="not-set">' . Yii::t('user', '(not set)') . '</span>'
						: $model->registration_ip;
				},
				'format' => 'html',
				'visible' => false
			],
			[
				'attribute' => 'created_at',
				'value' => function ($model) {
					if (extension_loaded('intl')) {
						return Yii::t('user', '{0, date, YYYY/MM/dd HH:mm}', [$model->created_at]);
					} else {
						return date('Y/m/d G:i:s', $model->created_at);
					}
				},
				'filter' => DatePicker::widget([
					'model'      => $searchModel,
					'attribute'  => 'created_at',
					'dateFormat' => 'php:Y-m-d',
					'options' => [
						'class' => 'form-control',
					],
				]),
			],
			[
				'header' => Yii::t('user', 'HRIS'),
				'value' =>  function ($model) {
					return Html::a((!empty($model->intranetUser->hrisUser)) ? 'Linked' : 'Link',['/user-management/user/link-plugin','id' => $model->id],['title' => 'Click to link this user\'s Intranet account to his/her HRIS Profile', 'class' => 'btn btn-xs btn-'.((!empty($model->intranetUser->hrisUser)) ? 'info' : 'warning').' btn-block']);
				},
				'format' => 'raw',
				'visible' => Yii::$app->getModule('user')->intranetMode ? true : false
			],
			[
				'header' => Yii::t('user', 'Has Role?'),
				'value' =>  function ($model) {
					return Html::a($model->hasRole,['/user/admin/assignments','id' => $model->id],['title' => 'Click to view assigned roles and permissions', 'class' => 'btn btn-xs btn-'.(($model->hasRole == 'Yes') ? 'info' : 'default').' btn-block']);
				},
				'format' => 'raw',
				'visible' => !isset(Yii::$app->modules['user-management']) ? true : false,
			],
			[
				'attribute' => 'has_role',
				'header' => Yii::t('user', 'Has Role?'),
				'value' =>  function ($model) {
					$value = 'No';
					$btnType = 'default';
					if(!empty($model->intranetUser->authAssignments)){
						$value = 'Yes';
						$btnType = 'info';
					}
					return Html::a($value,['/user-management/user/update-plugin','id' => $model->id],['title' => 'Click to view assigned roles and permissions', 'class' => 'btn btn-xs btn-'.$btnType.' btn-block']);
				},
				'format' => 'raw',
				'visible' => isset(Yii::$app->modules['user-management']) ? true : false,
				'filter' => ['Yes'=>'Yes', 'No'=>'No'],
			],
			[
				'attribute' => 'confirmed_at',
				'header' => Yii::t('user', 'Confirmation'),
				'value' => function ($model) {
					if ($model->isConfirmed) {
						return '<div class="text-center"><span class="text-success">' . Yii::t('user', 'Confirmed') . '</span></div>';
					} else {
						return Html::a(Yii::t('user', 'Confirm'), ['confirm', 'id' => $model->id], [
							'class' => 'btn btn-xs btn-success btn-block',
							'data-method' => 'post',
							'data-confirm' => Yii::t('user', 'Are you sure you want to confirm this user?'),
						]);
					}
				},
				'format' => 'raw',
				'visible' => Yii::$app->getModule('user')->enableConfirmation,
				'filter' => ['Yes'=>'Yes', 'No'=>'No'],
			],
			[
				'attribute' => 'blocked_at',
				'header' => Yii::t('user', 'Block status'),
				'value' => function ($model) {
					if ($model->isBlocked) {
						return Html::a(Yii::t('user', 'Unblock'), ['block', 'id' => $model->id], [
							'class' => 'btn btn-xs btn-success btn-block',
							'data-method' => 'post',
							'data-confirm' => Yii::t('user', 'Are you sure you want to unblock this user?'),
						]);
					} else {
						return Html::a(Yii::t('user', 'Block'), ['block', 'id' => $model->id], [
							'class' => 'btn btn-xs btn-danger btn-block',
							'data-method' => 'post',
							'data-confirm' => Yii::t('user', 'Are you sure you want to block this user?'),
						]);
					}
				},
				'format' => 'raw',
				'filter' => ['Yes'=>'Blocked', 'No'=>'Not Blocked'],
			],
			[
				'class' => 'yii\grid\ActionColumn',
				'template' => '{resend} {update} {create-secondary-account} {login-as-user}',
				'buttons' => [
					'resend' => function ($url, $model, $key) {
						if(!$model->isConfirmed){
							return Html::a('<span class="glyphicon glyphicon-repeat"></span>', ['resend-confirmation', 'id'=>$model->id], ['data-method' => 'post', 'data-confirm' => Yii::t('user', 'Resending confirmation email. Continue?'), 'title'=>'Resend confirmation email']);
						}
					},
					'create-secondary-account' => function ($url, $model, $key) {
						if(Yii::$app->getModule('user')->intranetMode == true && in_array('PARENT_ID', array_keys($model->userinfo->attributes)) && $model->userinfo->PARENT_ID == null){
							return Html::a('<span class="glyphicon glyphicon-share"></span>', ['create-secondary', 'id'=>$model->id], ['data-method' => 'post', 'data-confirm' => Yii::t('user', 'This will allow you to create a new user profile based on the selected profile. Continue?'), 'title'=>'Create Secondary Account based on this account']);
						}
					},
					'login-as-user' => function ($url, $model, $key) {
						
						$roles = ArrayHelper::getColumn(\Yii::$app->authManager->getRolesByUser($model->id), 'name');					
						
						if(Yii::$app->getModule('user')->intranetMode == true && (count(array_diff(['SuperAdministrator', 'Administrator', 'RegionalAdministrator'], $roles)) == 3)){
							return Html::a('<span class="glyphicon glyphicon-log-in"></span>', ['login-as-user', 'id'=>$model->id], ['data-method' => 'post', 'data-confirm' => Yii::t('user', 'Impersonate this user. Continue?'), 'title'=>'Impersonate this user']);
						}
					},
				],
				'contentOptions'=>['style'=>'width:90px']
			],
		],
	]); ?>
	</div>
	</div> <!-- ! -->
</div>
<?php Pjax::end() ?>
