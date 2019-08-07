<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\DocForm;

$this->title = Yii::t('doc', 'Documentation') . " : " . $returnName;
$this->params['breadcrumbs'][] = ['label' => $returnName, 'url' => $returnUrl];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
	<span class="pull-right" style="">		
		<?php if(Yii::$app->user->isGuest){ ?>
			<?php $form = ActiveForm::begin(['id' => 'form-home']); ?>
				<?= $form->field($model, 'language_iso_name')->dropDownList(DocForm::getLanguages(),['onChange'=>'this.form.submit();']) ?>
			<?php ActiveForm::end(); ?>
		<?php } ?>		
	</span>	 
    <h1 style="display:inline-block;">
        <?= Html::encode($this->title) ?>
        <span class="pull-right" style="margin-left:20px;">
			<a href="<?=$returnUrl?>&lang=<?=$model->language_iso_name?>" class='btn btn-warning'><span class="glyphicon glyphicon-step-backward"></span><?=Yii::t('app', 'Return')?></a>
        </span>         
    </h1>
	<div class="row">
		<div class="col-lg-10">
			<p><?= Html::encode(Yii::t('doc', "Here you can send notifications to any or all persons defined in the event plan if you have the permissions to do so. Also you can see all notifications that have been previously sent as well as the current status of those notifications.")) ?></p>
			<p><?= Html::encode(Yii::t('doc', "The envelope icon beside each name allows you to send a predefined email to that person. If you don't see that envelope icon it is because you don't have permissions to do that. There is also a button to send a predefined email to all the persons in this list.")) ?></p>
			<p><?= Html::encode(Yii::t('doc', "If your predefined email that you send requires the user to reply then that notification will appear in the list at the bottom and the status of the notification. The status will show if it has been accepted, rejected, or not replied to yet.")) ?></p>
			<p><?= Html::encode(Yii::t('doc', "It is still possible that if no emails were sent to these users that you still have a notification reply. That can happen when the user sends a reject or accept notice from their own task list showing all their personal tasks. You may set up in your routines that users use this technique of communication instead of emails if you wish.")) ?></p>
			<p><?= Html::encode(Yii::t('doc', "It is possible to delete a notification. Why would you want to do that? Any reject notifications might show up as red alerts in your event plan. To quickly remove the red alert you can delete the notification.")) ?></p>
		</div>
	</div>
</div>