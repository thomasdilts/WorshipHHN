<?php
use yii\helpers\Html;

$this->title = Yii::t('doc', 'Documentation') . " : " . $returnName;
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
			<p><?= Html::encode(Yii::t('doc', "In most churches you have several teams which perform the same job. For instance the praise and worship (song) team. Here is where you define all the team types that you have.")) ?></p>
			<p><?= Html::encode(Yii::t('doc', "This is only a single name input. Nothing else. The group name.")) ?></p>
		</div>
	</div>
</div> 