<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Unavailability') . ' : ' . $model->user_display_name;
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index','id'=>$model->user_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="user-blocked-update">

    <h1><?= Html::encode($this->title) ?>
		<span class="pull-right" style="margin-bottom:5px">
			<a href='<?=URL::toRoute('doc/doc')?>?page=user-blocked-index&returnName=<?=$this->title?>&returnUrl=<?=URL::toRoute('user-blocked/update?id='.$model->id)?>' class='btn btn-primary'><span class="glyphicon glyphicon-question-sign"></span></a>			                 
		</span>
	</h1>

    <div class="col-md-5 well bs-component">

        <?= $this->render('_form', ['model' => $model,'action'=>'update' ]) ?>

    </div>

</div>