<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\RegulatoryOrdinance */

$this->title = 'Regulatory Reform Technical Report';
$this->params['breadcrumbs'][] = ['label' => 'Regulatory Issuances', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['template' => "<li class='breadcrumb-item'>{link}</li>", 'label' => 'Preview' ];
\yii\web\YiiAsset::register($this);
?>
<div class="regulatory-ordinance-view">
    <div class="card card-default">
        <div class="card-header card-header-border-bottom">
            <h2><?= Html::encode($this->title) ?></h2>          
        </div>
        <div class="card-body">
            <div class="regulatory-issuance-view-tool-bar">
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
                </div>
            </div> 
            <div class="regulatory-issuance-list mt-4">
                <table class="table table-bordered regulatory-reform-tech-report">
                    <tr>
                        <td scope="row" colspan="5" class="table-label">1. LGU Information</td>
                    </tr>       
                    <tr>
                        <td scope="row" class="table-label">Name</td>
                        <td scope="row" colspan="4" class="table-desc"><?= $model->LguName ?></td>
                    </tr>
                    <tr>
                        <td scope="row" class="table-label">Department/Office</td>
                        <td scope="row" colspan="4" class="table-desc"><?= $model->officeName ?></td>
                    </tr>
                    <tr>
                        <td scope="row" class="table-label">Date of Submission</td>
                        <td scope="row" colspan="4" class="table-desc"><?= $model->dateSub ?></td>
                    </tr>
                    <tr>
                        <td scope="row" colspan="5" class="table-label">2. Issuance Information</td>
                    </tr>  
                    <tr>
                        <td scope="row" class="table-label">Issuance Number</td>
                        <td scope="row" colspan="4" class="table-label">Issuance Title</td>
                    </tr>
                    <tr>
                        <td scope="row" colspan="1" class="table-desc"><?= $model->issuanceNo ?></td>
                        <td scope="row" colspan="4" class="table-desc"><?= $model->issuanceTitle ?></td>
                    </tr>       
                    <tr>
                        <td scope="row" colspan="5" class="table-label">3. Brief description of new issuance</td>
                    </tr>
                    <tr>
                        <td scope="row" colspan="5" class="table-desc"><?= (!empty($model->issuanceDesc)) ?  $model->issuanceDesc : '-- None --' ?></td>
                    </tr>  
                    <tr>
                        <td scope="row" colspan="5" class="table-label">4. Affected issuances</td>
                    </tr>
                    <tr>    
                        <td scope="row" class="table-label">Code</td>
                        <td scope="row" colspan="4" class="table-label">Title</td>
                    </tr>
                        <?php
                            if(!empty($model->listAffectedIssuances)){
                                foreach($model->listAffectedIssuances as $row) {
                                    echo "<tr>
                                        <td scope='row' class='table-desc'>".$row['issuance_no']."</td>
                                        <td scope='row' colspan='4' class='table-desc'>".$row['title']."</td>
                                    </tr>";
                                }
                            } else {
                                echo "<tr>
                                    <td scope='row' class='table-desc'>-- None --</td><td scope='row' colspan='4' class='table-desc'>-- None --</td>
                                </tr>";
                            }
                        ?>       
                    <tr>
                        <td scope="row" colspan="5"class="table-label">5. Impact of New Issuance</td>
                    <tr>  
                    <tr>    
                        <td scope="row" class="table-label">Stakeholder</td>
                        <td scope="row" class="table-label">Nature of Impact</td>
                        <td scope="row" class="table-label">Magnitude of Impact</td>
                        <td scope="row" colspan="2" class="table-label">Duration of Impact</td>
                    </tr>                    
                    <?php
                        if(!empty($model->listImpactIssuances)){
                            foreach ($model->listImpactIssuances as $row) {
                                echo "<tr>";
                                    echo "<td scope='row' class='table-desc'>".$row['stakeholder']."</td>";
                                    echo "<td scope='row' class='table-desc'>".(!empty($row['nature_m']) ? $row['nature_m'] : '--None--')."</td>";
                                    echo "<td scope='row' class='table-desc'>".(!empty($row['magnitude_m']) ? $row['magnitude_m'] : '--None--')."</td>";
                                    echo "<td scope='row' colspan='2' class='table-desc'>".(!empty($row['duration']) ? $row['duration'] : '--None--')."</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr>";
                                echo "<td scope='row' class='table-desc'>-- None --</td>";
                                echo "<td scope='row' class='table-desc'>-- None --</td>";
                                echo "<td scope='row' class='table-desc'>-- None --</td>";
                                echo "<td scope='row' colspan='2' class='table-desc'>-- None --</td>";
                            echo "<tr>";
                        }
                    ?>                                                                           
                </table> <!-- /.table table-bordered -->                 
            </div>          
        </div> <!-- /.card-body -->
    </div> <!-- /.card -->
</div>
