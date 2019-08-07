<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Update Message Type') . ': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Message Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="team-type-update">

    <h1><?= Html::encode($this->title) ?>
        <span class="pull-right">
            <a href='<?=URL::toRoute('doc/doc')?>?page=message-type-index&returnName=<?=$this->title?>&returnUrl=<?=URL::toRoute('message-type/update?id='.$model->id)?>' class='btn btn-primary'><span class="glyphicon glyphicon-question-sign"></span></a>			
        </span> 		
	</h1>
	</h1>

    <div class="col-md-5 well bs-component">

        <?= $this->render('_form', ['model' => $model]) ?>

    </div>

</div>
