<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $user app\models\User */

$this->title = Yii::t('app', 'Create team unavailability'). ' : ' . $model->teamModel->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Teams'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Team Unavailability'), 'url' => ['unavailability?id='.$model->teamModel->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="team-type-create">

    <h1><?= Html::encode($this->title)?>
        <span class="pull-right">     	
			<a href='<?=URL::toRoute('doc/doc')?>?page=team-unavailability&returnName=<?=$this->title?>&returnUrl=<?=URL::toRoute('team/unavailabilitycreate?id='.$model->teamModel->id)?>' class='btn btn-primary'><span class="glyphicon glyphicon-question-sign"></span></a>			                 
        </span>                 	
	</h1>

    <div class="col-md-5 well bs-component">

        <?= $this->render('_unavailabilityform', ['model' => $model,'action'=>'create']) ?>

    </div>

</div>