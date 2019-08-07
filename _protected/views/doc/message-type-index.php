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
			<p><?= Html::encode(Yii::t('doc', "This is an abstraction level in the messaging system that allows you to group together identical message templates that are in different languages. The goal of this grouping is so that a person may get the message in the language that they prefer. Of course, most implementations of this program will only be in one language so that this abstraction level is only an irritation and doesn't offer any new functionality.")) ?></p>
			<p><?= Html::encode(Yii::t('doc', "Simply put a name here describing what the message is about. For example: Demand response, Empty email, Reminder")) ?></p>
		</div>
	</div>
</div>  