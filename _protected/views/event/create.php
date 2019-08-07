<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user app\models\User */

$this->title = Yii::t('app', 'Create Event');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Event'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="team-type-create">

    <h1><?= Html::encode($this->title)?></h1>

    <div class="col-md-5 well bs-component">

        <?= $this->render('_form', ['model' => $model,'action'=>'create']) ?>

    </div>

</div>