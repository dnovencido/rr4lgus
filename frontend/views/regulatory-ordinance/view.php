<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\RegulatoryOrdinance */

$this->title = 'Regulatory Reform Technical Report';
$this->params['breadcrumbs'][] = ['label' => 'Regulatory Ordinances', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['template' => "<li class='breadcrumb-item'>{link}</li>", 'label' => 'Preview' ];
\yii\web\YiiAsset::register($this);
?>
<div class="regulatory-ordinance-view">
    <div class="card card-default">
        <div class="card-header card-header-border-bottom">
            <h2><?= Html::encode($this->title) ?></h2>
            <?= $model->currentOrderVal ?>
            <?= $model->maxOrder; ?>
            <?= $model->currentLevel; ?>
            <?= $model->nextOrderVal; ?>
            <?= Yii::$app->user->identity->processType['level']; ?>
        </div>
        <div class="card-body">
            <div class="regulatory-ordinance-view-tool-bar">
                    <h4><i class="mdi mdi-toolbox-outline"></i> Information </h4>
                    <div class="entry-info">
                        <p> 
                            <span class="entry-info-label"> Current Status: </span> <span class="circle" style="background:<?= $model->statusLabelColor ?>;"></span> <?= $model->statusLabel ?>
                        </p>                        
                    </div>
                </div>
                <hr>        
            <div class="regulatory-ordinance-view-tool-bar">
                <h4><i class="mdi mdi-toolbox-outline"></i> Toolbar </h4>
                <div class="btn-group mt-3" role="group">
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
                    <!-- Submission -->
                    <?= ($model->currentLevelId == intVal(Yii::$app->user->identity->processType['level'])) ?  Html::a('<i class="mdi mdi-refresh"></i> Submit to '. $model->nextProcessLabel.'', ['submit', 'id' => $model->id], ['class' => 'btn btn-light btn-md btn-toolbar btn-refresh-reg-map']) : ''; ?>
                </div>
            </div>         
            <table class="table table-bordered regulatory-reform-tech-report mt-4">
                <tbody>
                    <tr>
                        <td scope="row" colspan="3" class="table-label"><b>1. LGU Information</b></td>
                    </tr>       

                    <tr>
                        <td scope="row" class="table-label">Name</td>
                        <td colspan="2" class="table-desc"><?= $model->lguName ?></td>
                    </tr>
                    <tr>
                        <td scope="row" class="table-label">Department/Office</td>
                        <td colspan="2" class="table-desc"><?= $model->officeName ?></td>
                    </tr>
                    <tr>
                        <td scope="row" class="table-label">Date of Submission</td>
                        <td colspan="2" class="table-desc"><?= $model->dateSub ?></td>
                    </tr>
                    <tr>
                        <td scope="row" colspan="3" class="table-label"><b>2. List of governing ordinance(s) that need to be repealed, amended, consolidated</b></td>
                    </tr>  
                    <tr>
                        <td scope="row" class="table-label">Ordinance/Resolution Number</td>
                        <td colspan="2" scope="row" class="table-label">Ordinance/Resolution Title</td>
                    </tr>
                    <tr>
                        <td scope="row" class="table-desc"><?= $model->ordinanceResNo ?></td>
                        <td colspan="2" scope="row" rowspan="3" class="table-desc"><?= $model->ordinanceTitle ?></td>
                    </tr>      
                    <tr>
                        <td scope="row" class="table-label">Date of effectivity/passage</td>
                    </tr>
                    <tr>
                        <td scope="row" class="table-desc"><?= $model->effDatePass ?></td>
                    </tr>   
                    <tr>
                        <td scope="row" colspan="3" class="table-label"><b>3. Brief description og the Ordinance/Resolution</b></td>
                    </tr>
                    <tr>
                        <td colspan="3" scope="row" colspan="3" class="table-desc"><?= $model->ordinanceDesc ?></td>
                    </tr>  
                    <tr>
                        <td scope="row" colspan="3" class="table-label"><b>4. List of agency-level issuance(s) it affect</b></td>
                    </tr>
                    <tr>    
                        <td scope="row" class="table-label">Code</td>
                        <td colspan="2" scope="row" class="table-label">Title</td>
                    </tr>
                    
                        <?php
                            if(!empty($model->listAffectedOrdinance)){
                                foreach($model->listAffectedOrdinance  as $row) {
                                    echo "<tr><td scope='row'class='table-desc'>".$row['ordinance_res_no']."</td><td colspan='2' scope='row' class='table-desc'>".$row['title']."</td></tr>";
                                }
                            } else {
                                echo "<tr><td scope='row'class='table-desc'>--None--</td><td colspan='2' scope='row' class='table-desc'>--None--</td></tr>";
                            }
                        ?>
                                
                    <tr>
                        <td scope="row" colspan="3" class="table-label"><b>5. Rationale behind recommended policy option</b></td>
                    <tr>  
                    <tr>
                        <td scope="row" colspan="3" class="table-desc"><?= $model->rationale ?></td>
                    </tr>                                                                           
                </tbody>
            </table> <!-- /.table table-bordered -->
        </div> <!-- /.card-body -->
    </div> <!-- /.card -->
</div>
