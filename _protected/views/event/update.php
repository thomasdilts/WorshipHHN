<?php
use yii\helpers\Html;

$this->title = Yii::t('app', 'Update Event') . ': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Event'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="team-type-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="col-md-5 well bs-component">

        <?= $this->render('_form', ['model' => $model,'action'=>'update' ]) ?>

    </div>

</div>