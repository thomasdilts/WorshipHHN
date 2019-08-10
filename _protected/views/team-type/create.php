<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $user app\models\User */

$this->title = Yii::t('app', 'Create Team Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Team Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="team-type-create">

    <h1><?= Html::encode($this->title)?>
        <span class="pull-right" style="margin-bottom:5px">
			<a href='<?=URL::toRoute('doc/doc')?>?page=team-type-index&returnName=<?=$this->title?>&returnUrl=<?=URL::toRoute('team-type/create')?>%3Ftemp%3Dtemp' class='btn btn-primary'><span class="glyphicon glyphicon-question-sign"></span></a>			                 
        </span>         
	</h1>

    <div class="col-md-5 well bs-component">

        <?= $this->render('_form', ['model' => $model]) ?>

    </div>

</div>