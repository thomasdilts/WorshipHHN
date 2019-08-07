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
			<p><?= Html::encode(Yii::t('doc', "Included in this program is a notification system that is built upon predefined messages. Here is where these messages are defined. There is an added level of language translations in this module so that a person may get the message in the language that they prefer. Of course this language independence works only if you make the necessary translations of your messages.  It is not necessary if you don't need it.")) ?></p>
			<p><?= Html::encode(Yii::t('doc', "The messages you define here may or may not require the user to respond by pressing a button that is in the email they receive. There is a lot of flexability in these message definitions.")) ?></p>
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th><?= Html::encode(Yii::t('doc', 'Data field name'))?> </th>
						<th><?= Html::encode(Yii::t('doc', 'Description'))?></th>
						<th><?= Html::encode(Yii::t('doc', 'Examples'))?> </th>
					</tr>
				</thead> 
				<tbody>
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Language'))?> </td>
						<td><?= Html::encode(Yii::t('doc', 'What language will this message be in? This is an important part of being able to send the same message to different persons in different languages'))?></td>	
						<td>English, Swedish, Deutsche, ...</td>	
					</tr>
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Message Type'))?> </td>
						<td><?= Html::encode(Yii::t('doc', 'This is the abstraction that allows the language independence. If you define two or more message templates with the same message type and different languages then you have the ability to send one or the other depending on which language your user prefers.'))?></td>	
						<td><?= Html::encode(Yii::t('doc', 'Message type examples: Demand response, Empty email, Reminder'))?></td>	
					</tr>
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Name'))?> </td>
						<td><?= Html::encode(Yii::t('doc', 'This name is only for the user to be able to quickly recognize which message this is about?'))?></td>	
						<td><?= Html::encode(Yii::t('doc', 'Name examples: Demand response, Empty email, Reminder. Basically the same as Message Type'))?></td>		
					</tr>
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Show Accept Button'))?> </td>
						<td><?= Html::encode(Yii::t('doc', 'If this is selected then the message will include a green button that the receiver is always expected to press. If the user doesn\'t press the accept button in the message then the task that this message refers to will have a yellow marked message showing that the user has not responded.'))?></td>	
						<td></td>	
					</tr> 
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Accept Button Text'))?> </td>
						<td><?= Html::encode(Yii::t('doc', "Only fill this in if 'Show Accept Button' is true. In that case you must enter some positive text."))?></td>	
						<td><?= Html::encode(Yii::t('doc', 'Yes, I will come and do this task'))?></td>	
					</tr>
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Show Reject Button'))?> </td>
						<td><?= Html::encode(Yii::t('doc', 'If this is selected then the message will include a red button that the receiver may press to tell you that he can\'t come. If the receiver presses this button then the task will be marked with a red rejected notice.'))?></td>	
						<td><?= Html::encode(Yii::t('doc', ''))?></td>	
					</tr>
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Reject Button Text'))?> </td>
						<td><?= Html::encode(Yii::t('doc', "Only fill this in if 'Show Reject Button' is true. In that case you must enter some text showing a negative response."))?></td>
						<td><?= Html::encode(Yii::t('doc', "No, I can't come and do this task"))?></td>	
					</tr>
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Show Link To Object'))?> </td>
						<td><?= Html::encode(Yii::t('doc', 'You probably should always set this to true. This will add a link at the bottom of the email that if the user presses the link they will come to the exact event the message is about.'))?></td>	
						<td></td>
					</tr>
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Link Text'))?> </td>
						<td><?= Html::encode(Yii::t('doc', "Only fill this in if 'Show Link To Object' is true. Write something that shows that this is a link to the event"))?></td>	
						<td><?= Html::encode(Yii::t('doc', 'Click here to see the event.'))?></td>	
					</tr>
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Allow Custom Message'))?> </td>
						<td><?= Html::encode(Yii::t('doc', 'If this is true then the sender of the message can write some personalized comment into the email. The sender doesn\'t have to write a comment but it is then an option for the sender.'))?></td>	
						<td></td>	
					</tr>
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Use an automatically created subject'))?> </td>
						<td><?= Html::encode(Yii::t('doc', 'If this is true then the subject of the email will contain an automatically generated text. That text has the following format: Event name, event start date, task name'))?></td>	
						<td></td>	
					</tr>
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Subject'))?> </td>
						<td><?= Html::encode(Yii::t('doc', "Only fill in this if 'Use an automatically created subject' is false (not checked). This will then be the subject of the email."))?></td>	
						<td><?= Html::encode(Yii::t('doc', "You are requested to perform a task at our church"))?></td>	
					</tr>
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Body'))?> </td>
						<td><?= Html::encode(Yii::t('doc', 'This is the body of the email and you must always put something here.  If you want this message to be completely blank to only show the custom message then put something here like a period.'))?></td>	
						<td><?= Html::encode(Yii::t('doc', "You are scheduled to do the task given in the subject of this email. Please let us know if you can come or not by clicking on one of the buttons below. If you want to see more about the event then click on the link at the bottom of the email. Thank you and may God Bless You!"))?></td>	
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div> 