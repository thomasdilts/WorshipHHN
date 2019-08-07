<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('doc', 'Documentation') . " : " . Yii::t('doc', 'Screenshot');
$this->params['breadcrumbs'][] = ['label' => $returnName, 'url' => $returnUrl];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <h1 style="display:inline-block;">
        <?= Html::encode($this->title) ?>
        <span class="pull-right" style="margin-left:20px;">
			<a href="<?=$returnUrl?>" class='btn btn-warning'><span class="glyphicon glyphicon-step-backward"></span><?=Yii::t('app', 'Return')?></a>
        </span>         
    </h1>
	<div class="row">
		<div class="col-lg-10">
			<img class="screenshotdocfullsize" src="<?=Yii::$app->request->baseUrl.$image?>" />
		</div>
	</div>
</div>