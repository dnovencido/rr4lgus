<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\RegulatoryMap */

$this->title = $model->policyCodeNo;
$this->params['breadcrumbs'][] = ['label' => 'Stocktaking', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['template' => "<li class='breadcrumb-item'>{link}</li>", 'label' => $model->policyCodeNo ];
\yii\web\YiiAsset::register($this);
?>
<div class="regulatory-map-view">

    <div class="card card-default">
        <div class="card-header card-header-border-bottom justify-content-between">
            <div>
                <h2><?= Html::encode($this->title) ?></h2>     
                <p class="mt-3"> 
                    <span class="mb-2 mr-2 badge badge-primary"><?= $model->typeName ?></span>
                </p>
            </div>            
        </div>
        <div class="card-body">
            <div class="view-regulatory-map">
                <div class="regulatory-issuance-view-tool-bar">
                    <h4><i class="mdi mdi-toolbox-outline"></i> Information </h4>
                    <div class="entry-info">
                        <p> 
                            <span class="entry-info-label"> Current Status: </span> <span class="circle status-verified"></span> <?= $model->statuslabel ?>
                        </p>                        
                        <p> 
                            <span class="entry-info-label">  Date Created: </span> <?= $model->date_created ?>
                        </p>
                        <p> 
                            <span class="entry-info-label">Last updated: </span> <?= $model->last_updated ?>
                        </p> 
                    </div>
                </div>
                <hr>
                <div class="regulatory-issuance-view-tool-bar mt-4">
                    <h4><i class="mdi mdi-toolbox-outline"></i> Toolbar </h4>
                    <div class="btn-group mt-3" role="group">
                        <?=
                            ($model->typeCode == 'ORD') ?  Html::a('<i class="mdi mdi-plus"></i> Accomplish Report', ['report-for-ordinance', 'id' => $model->ref_id], ['class' => 'btn btn-light btn-md btn-toolbar']) :  Html::a('<i class="mdi mdi-plus"></i> Accomplish Report ', ['report-for-issuance', 'id' => $model->ref_id], ['class' => 'btn btn-light btn-md btn-toolbar'])
                        ?>
                        <?= Html::a('<i class="mdi mdi-plus"></i> Update', ['update', 'id' => $model->id], ['class' => 'btn btn-light btn-md btn-toolbar']) ?>
                        <?= Html::a('<i class="mdi mdi-cloud-upload"></i> Delete', ['delete', 'id' => $model->id], 
                            [
                                'class' => 'btn btn-light btn-md btn-toolbar',
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this item?',
                                    'method' => 'post',
                                ]
                            ]
                        ) ?>
                        <?= Html::a('<i class="mdi mdi-refresh"></i> Refresh', ['#'], ['class' => 'btn btn-light btn-md btn-toolbar btn-refresh-reg-map']) ?>
                    </div>
                </div>                 
                <div class="regulatory-map-list mt-4">
                    <table class="table table-bordered regulatory-map">
                        <tr>
                            <td scope="col" colspan="3" class="table-label">1. Policy No. / Code</td>
                        </tr>
                        <tr>
                            <td scope="row" colspan="3"><?= $model->policyCodeNo ?></td>
                        </tr>
                        <tr>
                            <td scope="row" colspan="3" class="table-label">2. Status of Existing Ordinances/Issuances </td>
                        </tr>  
                        <tr>
                            <td scope="row" class="table-label" colspan="2"> Title of Ordinance/Resolution/Issuance/Executive Order</td>
                            <td scope="row" class="table-label" colspan="1"> Date of Approval </td>
                        </tr>  
                        <tr>
                            <td scope="row" colspan="2"><?= $model->titleIssOrd ?></td>
                            <td scope="row" colspan="1"><?= $model->date_of_approval ?></td>
                        </tr>
                        <tr>
                            <td scope="row" class="table-label" colspan="2"> Legal Bases</td>
                            <td scope="row" class="table-label" colspan="1"> Sector </td>
                        </tr>
                        <tr>
                            <td scope="row" colspan="2"><?= $model->legal_bases ?></td>
                            <td scope="row" colspan="1"><?= $model->sectorName ?></td>
                        </tr>                
                        <tr>
                            <td scope="row" colspan="3" class="table-label">3. Impact to Stakeholder </th>
                        </tr> 
                        <tr>
                            <td scope="row" colspan="2" class="table-label" class="table-label"> Coverage </th>
                            <td scope="row" colspan="1" class="table-label" class="table-label"> Measure </th>
                        </tr>
                        <tr>
                            <td scope="row" colspan="2"> <?= $model->coverageName ?> </td>
                            <td scope="row" colspan="1"> <?= $model->measureName ?> </td>
                        </tr>               
                        <tr>
                            <td scope="col" colspan="3" class="table-label">4. Status of Regulations for Repeal/Amend/Consolidate</td>
                        </tr>  
                        <tr>
                            <td scope="col" colspan="2" class="table-label"> Recommended policy option </td>
                            <td scope="col" colspan="1" class="table-label"> Reason for policy option</td>
                        </tr>  
                        <tr>
                            <td scope="row" colspan="2"> <?= $model->policyName ?> </td>
                            <td scope="row" colspan="1"> <?= $model->reasfpol ?></td>
                        </tr>                  
                        <tr>
                            <td scope="col" colspan="3" class="table-label"> New Policy Issuance</td>
                        </tr>
                        <tr>
                            <td scope="row" colspan="3"> <?= $model->reasfpol ?></td>
                        </tr>                      
                        <tr>
                            <td scope="row" colspan="3" class="table-label"> Remarks </td>
                        </tr>
                        <tr>
                            <td scope="row" colspan="3"> <?= $model->remarks ?> </td>
                        </tr>                                                                                                                                                           
                    </table>                      
                </div>
            </div>
        </div><!-- /.card-body -->
    </div><!-- /.card -->

</div>
