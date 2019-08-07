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
			<p><?= Html::encode(Yii::t('doc', "Here you can see all the members of the team and if you have the right permissions you can add and remove members to the team. To add members to the team simply press the plus button beside the user you want to add to the team.")) ?></p>
			<p><?= Html::encode(Yii::t('doc', "One very important setting here is the 'always notify' field for each member of the team. If this is set to true then that person will receive all the notifications that come to the team from the event manager. If you want you can have all the members of the team receive these notifications. But at least you would want the team leader to have this set to true.")) ?></p>
		</div>
	</div>
</div> 