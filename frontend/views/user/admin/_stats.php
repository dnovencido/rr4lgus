<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\helpers\Json;
?>

<?php
	$colspan = 3;
	if(Yii::$app->getModule('user')->intranetMode == true){
		$colspan = 1;
	}
?>

<div class="admin-stats">
	<div class="row">
		<div class="col-md-4">
			<div class="panel panel-primary">
				<div class="panel-heading">
					User Accounts Statistics
				</div>
				<table class="table table-condensed table-bordered">
					<thead>
						<tr>
							<th></th>
							<th colspan="<?= $colspan; ?>">Total</th>
							<?php if(Yii::$app->getModule('user')->intranetMode == true): ?>
							<th>Primary</th>
							<th>Secondary</th>
							<?php endif; ?>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>All Accounts</td>
							<td colspan="<?= $colspan; ?>"><span class="badge pull-right"><?= $stats['totalPrimaryUsers'] + (isset($stats['totalSecondaryUsers']) ? $stats['totalSecondaryUsers'] : 0); ?></span></td>
							<?php if(Yii::$app->getModule('user')->intranetMode == true): ?>
							<td><span class="badge pull-right"><?= $stats['totalPrimaryUsers']; ?></span></td>
							<td><span class="badge pull-right"><?= $stats['totalSecondaryUsers']; ?></span></td>
							<?php endif; ?>
						</tr>
						<?php if(Yii::$app->user->identity->userinfo->OFFICE_C == 5){ ?>
						<tr>
							<td>Central Office</td>
							<td colspan="<?= $colspan; ?>"><span class="badge pull-right"><?= $stats['totalPrimaryCentral'] + (isset($stats['totalSecondaryCentral']) ? $stats['totalSecondaryCentral'] : 0); ?></span></td>
							<?php if(Yii::$app->getModule('user')->intranetMode == true): ?>
							<td><span class="badge pull-right"><?= $stats['totalPrimaryCentral']; ?></span></td>
							<td><span class="badge pull-right"><?= $stats['totalSecondaryCentral']; ?></span></td>
							<?php endif; ?>
						</tr>
						<?php } ?>
						<tr>
							<td>Region</td>
							<td colspan="<?= $colspan; ?>"><span class="badge pull-right"><?= $stats['totalPrimaryRegion'] + (isset($stats['totalSecondaryRegion']) ? $stats['totalSecondaryRegion'] : 0); ?></span></td>
							<?php if(Yii::$app->getModule('user')->intranetMode == true): ?>
							<td><span class="badge pull-right"><?= $stats['totalPrimaryRegion']; ?></span></td>
							<td><span class="badge pull-right"><?= $stats['totalSecondaryRegion']; ?></span></td>
							<?php endif; ?>
						</tr>
						<tr>
							<td>Province</td>
							<td colspan="<?= $colspan; ?>"><span class="badge pull-right"><?= $stats['totalPrimaryProvince'] + (isset($stats['totalSecondaryProvince']) ? $stats['totalSecondaryProvince'] : 0); ?></span></td>
							<?php if(Yii::$app->getModule('user')->intranetMode == true): ?>
							<td><span class="badge pull-right"><?= $stats['totalPrimaryProvince']; ?></span></td>
							<td><span class="badge pull-right"><?= $stats['totalSecondaryProvince']; ?></span></td>
							<?php endif; ?>
						</tr>
						<tr>
							<td>City / Municipality</td>
							<td colspan="<?= $colspan; ?>"><span class="badge pull-right"><?= $stats['totalPrimaryCitymun'] + (isset($stats['totalSecondaryCitymun']) ? $stats['totalSecondaryCitymun'] : 0); ?></span></td>
							<?php if(Yii::$app->getModule('user')->intranetMode == true): ?>
							<td><span class="badge pull-right"><?= $stats['totalPrimaryCitymun']; ?></span></td>
							<td><span class="badge pull-right"><?= $stats['totalSecondaryCitymun']; ?></span></td>
							<?php endif; ?>
						</tr>
						<tr>
							<td>No Office set</td>
							<td colspan="<?= $colspan; ?>"><span class="badge pull-right"><?= $stats['totalPrimaryMissingOffice'] + (isset($stats['totalSecondaryMissingOffice']) ? $stats['totalSecondaryMissingOffice'] : 0); ?></span></td>
							<?php if(Yii::$app->getModule('user')->intranetMode == true): ?>
							<td><span class="badge pull-right"><?= $stats['totalPrimaryMissingOffice']; ?></span></td>
							<td><span class="badge pull-right"><?= $stats['totalSecondaryMissingOffice']; ?></span></td>
							<?php endif; ?>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="col-md-4">
			<div class="panel panel-warning">
				<div class="panel-heading">
					For Action
				</div>
				<table class="table table-condensed table-bordered">
					<tbody>
						<tr>
							<td>Primary Accounts with same Employee IDs
								<span class="pull-right">
									<?= Html::a($stats['sameIds'], '/user/admin/all-users-with-same-ids', [
										'class' => 'btn btn-xs btn-warning pull-right',
										'title' => Yii::t('yii', 'Click to view'),
										'onclick'=>"
											$.ajax({
												type     :'POST',
												data	 : ".Json::encode(['office_c'=>$searchModel->OFFICE_C, 'region_c'=>$searchModel->REGION_C, 'province_c'=>$searchModel->PROVINCE_C, 'citymun_c'=>$searchModel->CITYMUN_C], JSON_FORCE_OBJECT).",
												cache    : false,
												url		 : '".Url::to(['/user/admin/all-users-with-same-ids'])."',
												success  : function(response) {
													$('#userStatsModalContent').html(response);
													$('#userStatsModal').modal('show');
												}
											});
											return false;
										",
									]);
									?>
								</span>
							</td>
						</tr>
						<tr>
							<td>Accounts with missing Office
								<span class="pull-right">
									<?= Html::a($stats['totalPrimaryMissingOffice'] + (isset($stats['totalSecondaryMissingOffice']) ? $stats['totalSecondaryMissingOffice'] : 0), '/user/admin/all-missing-office-users', [
										'class' => 'btn btn-xs btn-warning pull-right',
										'title' => Yii::t('yii', 'Click to view'),
										'onclick'=>"
											$.ajax({
												type     :'POST',
												data	 : ".Json::encode(['office_c'=>$searchModel->OFFICE_C, 'region_c'=>$searchModel->REGION_C, 'province_c'=>$searchModel->PROVINCE_C, 'citymun_c'=>$searchModel->CITYMUN_C], JSON_FORCE_OBJECT).",
												cache    : false,
												url		 : '".Url::to(['/user/admin/all-missing-office-users'])."',
												success  : function(response) {
													$('#userStatsModalContent').html(response);
													$('#userStatsModal').modal('show');
												}
											});
											return false;
										",
									]);
									?>
								</span>
							</td>
						</tr>
						<?php if(Yii::$app->getModule('user')->intranetMode == true): ?>
						<tr>
							<td>HRIS Profiles without User Accounts
								<span class="pull-right">
									<?= Html::a((isset($stats['withoutIntranetAccounts']) ? $stats['withoutIntranetAccounts'] : 0), ['/user/hris-profile/no-accounts', 
										'HrisProfileSearch[fullname]'=>$searchModel->keyname,
										'HrisProfileSearch[region_c]' => $searchModel->REGION_C,
										'HrisProfileSearch[office_c]' => $searchModel->OFFICE_C,
										'HrisProfileSearch[email]' => $searchModel->email,
										'HrisProfileSearch[emp_id]' => $searchModel->emp_n,
									], [
										'class' => 'btn btn-xs btn-'.((isset($stats['withoutIntranetAccounts']) ? $stats['withoutIntranetAccounts'] : 0) == 0 ? 'success' : 'warning').' pull-right',
										'title' => Yii::t('yii', 'Click to view'),
									]);
									?>
								</span>
							</td>
						</tr>
						<tr>
							<td>INTRANET Accounts without HRIS Profile
								<span class="pull-right">
									<?= Html::a((isset($stats['withoutHRIS']) ? $stats['withoutHRIS'] : 0), ['/user/admin/index', 'UserSearch[hris_link]'=>'No', 'UserSearch[OFFICE_C]'=>$searchModel->OFFICE_C, 'UserSearch[REGION_C]'=>$searchModel->REGION_C, 'UserSearch[PROVINCE_C]'=>$searchModel->PROVINCE_C, 'UserSearch[CITYMUN_C]'=>$searchModel->CITYMUN_C], [
										'class' => 'btn btn-xs btn-'.((isset($stats['withoutHRIS']) ? $stats['withoutHRIS'] : 0) == 0 ? 'success' : 'warning').' pull-right',
										'title' => Yii::t('yii', 'Click to view'),
									]);
									?>
								</span>
							</td>
						</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="col-md-4">
			<div class="panel panel-info">
				<div class="panel-heading">
					For Information
				</div>
				<table class="table table-condensed table-bordered">
					<tbody>
						<tr>
							<td>Unconfirmed Accounts
								<span class="pull-right">
									<?= Html::a($stats['totalUnconfirmed'], 'user/admin/all-unconfirmed-users', [
										'class' => 'btn btn-xs btn-info pull-right',
										'title' => Yii::t('yii', 'Click to view'),
										'onclick'=>"
											$.ajax({
												type     :'POST',
												data	 : ".Json::encode(['office_c'=>$searchModel->OFFICE_C, 'region_c'=>$searchModel->REGION_C, 'province_c'=>$searchModel->PROVINCE_C, 'citymun_c'=>$searchModel->CITYMUN_C], JSON_FORCE_OBJECT).",
												cache    : false,
												url		 : '".Url::to(['/user/admin/all-unconfirmed-users'])."',
												success  : function(response) {
													$('#userStatsModalContent').html(response);
													$('#userStatsModal').modal('show');
												}
											});
											return false;
										",
									]);
									?>
								</span>
							</td>
						</tr>
						<tr>
							<td>Blocked Accounts
								<span class="pull-right">
									<?= Html::a($stats['totalBlocked'], 'user/admin/all-blocked-users', [
										'class' => 'btn btn-xs btn-info pull-right',
										'title' => Yii::t('yii', 'Click to view'),
										'onclick'=>"
											$.ajax({
												type     :'POST',
												data	 : ".Json::encode(['office_c'=>$searchModel->OFFICE_C, 'region_c'=>$searchModel->REGION_C, 'province_c'=>$searchModel->PROVINCE_C, 'citymun_c'=>$searchModel->CITYMUN_C], JSON_FORCE_OBJECT).",
												cache    : false,
												url		 : '".Url::to(['/user/admin/all-blocked-users'])."',
												success  : function(response) {
													$('#userStatsModalContent').html(response);
													$('#userStatsModal').modal('show');
												}
											});
											return false;
										",
									]);
									?>
								</span>
							</td>
						</tr>
						<tr>
							<td>Newly Registered Accounts For the Day
								<span class="pull-right">
									<?= Html::a($stats['totalNewUsers'], 'user/admin/all-new-users-today', [
										'class' => 'btn btn-xs btn-info pull-right',
										'title' => Yii::t('yii', 'Click to view'),
										'onclick'=>"
											$.ajax({
												type     :'POST',
												data	 : ".Json::encode(['office_c'=>$searchModel->OFFICE_C, 'region_c'=>$searchModel->REGION_C, 'province_c'=>$searchModel->PROVINCE_C, 'citymun_c'=>$searchModel->CITYMUN_C], JSON_FORCE_OBJECT).",
												cache    : false,
												url		 : '".Url::to(['/user/admin/all-new-users-today'])."',
												success  : function(response) {
													$('#userStatsModalContent').html(response);
													$('#userStatsModal').modal('show');
												}
											});
											return false;
										",
									]);
									?>
								</span>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<?php
			Modal::begin([
				'id' => 'userStatsModal',
				'size' => 'modal-xl',
				'header' => '<div id="userStatsModalHeader"></div>',
			]);
			echo '<div id="userStatsModalContent"></div>';
			Modal::end();
		?>
	</div>
</div>

