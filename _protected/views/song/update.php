<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Update Song') . ': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Songs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="song-update">

    <h1><?= Html::encode($this->title) ?>
        <span class="pull-right" style="margin-bottom:5px">
            <a href='<?=URL::toRoute('doc/doc')?>?page=song-index&returnName=<?=$this->title?>&returnUrl=<?=URL::toRoute('song/update?id='.$model->id)?>' class='btn btn-primary'><span class="glyphicon glyphicon-question-sign"></span></a>			                 
        </span>  
	</h1>

    <div class="col-md-5 well bs-component">

        <?= $this->render('_form', ['model' => $model]) ?>

    </div>

</div>
