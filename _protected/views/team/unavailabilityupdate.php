<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Team Unavailability') . ' : ' . $model->teamModel->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Teams'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Team Unavailability'), 'url' => ['unavailability?id='.$model->teamModel->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="team-blocked-update">

    <h1><?= Html::encode($this->title) ?>
        <span class="pull-right">     	
			<a href='<?=URL::toRoute('doc/doc')?>?page=team-unavailability&returnName=<?=$this->title?>&returnUrl=<?=URL::toRoute('team/unavailabilityupdate%3Fid%3D'.$model->id.'%26teamid%3D'.$model->teamModel->id)?>' class='btn btn-primary'><span class="glyphicon glyphicon-question-sign"></span></a>			                 
        </span>                 	
	</h1>

    <div class="col-md-5 well bs-component">

        <?= $this->render('_unavailabilityform', ['model' => $model,'action'=>'update' ]) ?>

    </div>

</div>