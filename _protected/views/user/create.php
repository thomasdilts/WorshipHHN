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

    <h1><?= Html::encode($this->title) ?>
		<span class="pull-right" style="margin-bottom:5px">
			<a href='<?=URL::toRoute('doc/doc')?>?page=user-profile&returnName=<?=$this->title?>&returnUrl=<?=URL::toRoute('user/create')?>' class='btn btn-primary'><span class="glyphicon glyphicon-question-sign"></span></a>			                 
		</span>
	</h1>

    <div class="">

        <?= $this->render('_form', ['model' => $model,'returnUrl'=>'index','image'=>$image]) ?>

    </div>

</div>

