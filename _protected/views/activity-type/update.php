<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Update Task Template') . ': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Task templates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="team-type-update">

    <h1><?= Html::encode($this->title) ?>
        <span class="pull-right">
            <a href='<?=URL::toRoute('doc/doc')?>?page=activity-type-index&returnName=<?=$this->title?>&returnUrl=<?=URL::toRoute('activity-type/update?id='.$model->id)?>' class='btn btn-primary'><span class="glyphicon glyphicon-question-sign"></span></a>			
        </span> 	
	</h1>

    <div class="col-md-5 well bs-component">

        <?= $this->render('_form', ['model' => $model]) ?>

    </div>

</div>