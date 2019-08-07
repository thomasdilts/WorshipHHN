<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $user app\models\User */

$this->title = Yii::t('app', 'Create unavailability'). ' : ' . $model->user_display_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Unavailability'), 'url' => ['index','id'=>Yii::$app->user->identity->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="team-type-create">

    <h1><?= Html::encode($this->title)?>
		<span class="pull-right" style="margin-bottom:5px">
			<a href='<?=URL::toRoute('doc/doc')?>?page=user-blocked-index&returnName=<?=$this->title?>&returnUrl=<?=URL::toRoute('user-blocked/create')?>' class='btn btn-primary'><span class="glyphicon glyphicon-question-sign"></span></a>			                 
		</span> 
	</h1>

    <div class="col-md-5 well bs-component">

        <?= $this->render('_form', ['model' => $model,'action'=>'create']) ?>

    </div>

</div>