<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $user app\models\User */

$this->title = Yii::t('app', 'Create User');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

	<div class="row">
		<h1 style="margin-left:15px;">
			<?= Html::encode($this->title) ?>
			<span class="pull-right" style="margin-bottom:5px">
				<a href='<?=URL::toRoute('doc/doc')?>?page=user-profile&returnName=<?=$this->title?>&returnUrl=<?=URL::toRoute('user/create')?>%3Ftemp%3Dtemp' class='btn btn-primary'><span class="glyphicon glyphicon-question-sign"></span></a>			                 
			</span>
		</h1>
	</div>
	<div class="row">	

        <?= $this->render('_form', ['model' => $model,'returnUrl'=>'index','image'=>$image]) ?>

	</div>
</div>

