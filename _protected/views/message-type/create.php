<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $user app\models\User */

$this->title = Yii::t('app', 'Create Message Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Message Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="team-type-create">

    <h1><?= Html::encode($this->title)?>
        <span class="pull-right">
            <a href='<?=URL::toRoute('doc/doc')?>?page=message-type-index&returnName=<?=$this->title?>&returnUrl=<?=URL::toRoute('message-type/create')?>' class='btn btn-primary'><span class="glyphicon glyphicon-question-sign"></span></a>			
        </span>         
	</h1>

    <div class="col-md-5 well bs-component">

        <?= $this->render('_form', ['model' => $model]) ?>

    </div>

</div>