<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $user app\models\User */

$this->title = Yii::t('app', 'Update User') . ': ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="user">

    <h1><?= Html::encode($this->title) ?>
		<span class="pull-right" style="margin-bottom:5px">
			<a href='<?=URL::toRoute('doc/doc')?>?page=user-profile&returnName=<?=$this->title?>&returnUrl=<?=URL::toRoute('user/update?id='.$model->id)?>' class='btn btn-primary'><span class="glyphicon glyphicon-question-sign"></span></a>			                 
		</span>
	</h1>

    <div class="">

        <?= $this->render('_form', ['model' => $model,'returnUrl'=>$returnUrl,'image'=>$image]) ?>

    </div>

</div>
