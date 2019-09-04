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
			<p><?= Html::encode(Yii::t('doc', "This is the heart of all configuration for 'WorshipHHN'. Therefore it is important that you spend time here to make your event management correct. Here is where the contents of all tasks are defined but not the tasks themselves.")) ?></p>
			<p><?= Html::encode(Yii::t('doc', "In your definition of a task you decide what items must be present and what items can be present. If you simply want the item to be present you define it as 'Allow'. If the item must be present in the task you define it as 'Demand'. When the item is demanded, if it is not present in the task then a red warning text will be shown signifying that something is wrong.")) ?></p>
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
						<td><?= Html::encode(Yii::t('doc', 'Use Team'))?> </td>
						<td><?= Html::encode(Yii::t('doc', 'Will a team be needed or used to do this task?'))?></td>	
						<td></td>	
					</tr>
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Allow text name entry for team'))?> </td>
						<td><?= Html::encode(Yii::t('doc', 'If you want a team selected will you allow a text entry of the team instead?'))?></td>	
						<td></td>	
					</tr>
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Team Type'))?> </td>
						<td><?= Html::encode(Yii::t('doc', 'If you are using a team to do this task then this MUST be defined. Otherwise it will be impossible to select any team for the task. You may need to go back and define all your team types first if this list is empty.'))?></td>	
						<td><?= Html::encode(Yii::t('doc', 'Team type examples: Prayer team, Hosting team, Usher team, Praise and psalm team'))?></td>	
					</tr>
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Use User'))?> </td>
						<td><?= Html::encode(Yii::t('doc', 'Will a user be needed or used to do this task?'))?></td>	
						<td></td>	
					</tr>
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Allow text name entry for user'))?> </td>
						<td><?= Html::encode(Yii::t('doc', 'If you want a user selected will you allow a text entry of the user instead?'))?></td>	
						<td></td>	
					</tr>
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Notify this user of event problems'))?> </td>
						<td><?= Html::encode(Yii::t('doc', 'If a user is defined for this task then that user will be notified by email anytime a task is rejected by a team or user.'))?></td>	
						<td><?= Html::encode(Yii::t('doc', 'This is mainly for the service organizer task.'))?></td>	
					</tr> 
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Use Description'))?> </td>
						<td><?= Html::encode(Yii::t('doc', "Is a description to be used in this task. This is rarely needed but on some tasks it could be used. This item is very similar to the 'Use Special Needs' where the only difference is perhaps the severity or importance."))?></td>	
						<td><?= Html::encode(Yii::t('doc', 'Allows a person to enter a simple description of what will be done in the task'))?></td>	
					</tr>
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Use Song'))?> </td>
						<td><?= Html::encode(Yii::t('doc', 'If a song will be done in this task then this must be used.'))?></td>	
						<td><?= Html::encode(Yii::t('doc', ''))?></td>	
					</tr>
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Use file'))?> </td>
						<td><?= Html::encode(Yii::t('doc', 'Will some sort of file be needed to properly define this task?'))?></td>
						<td><?= Html::encode(Yii::t('doc', ''))?></td>	
					</tr>
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Use bible verse'))?> </td>
						<td><?= Html::encode(Yii::t('doc', 'Will a bible verse need to be defined so others can coordinate the showing of that verse? Or possibly just tell others what bible verses you plan to use.'))?></td>	
						<td><?= Html::encode(Yii::t('doc', ''))?></td>
					</tr>
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Use Special Needs'))?> </td>
						<td><?= Html::encode(Yii::t('doc', 'This is very similar to a description however it is more for comunicating specific needs for the task.'))?></td>	
						<td><?= Html::encode(Yii::t('doc', 'In the actual task you might define here what your needs are for sound equipment or perhaps video equipment as well as any type of assistance.'))?></td>	
					</tr>
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Use Globally (No start time)'))?> </td>
						<td><?= Html::encode(Yii::t('doc', 'This must be set to true if the task is not defined for a specific time slot.'))?></td>	
						<td><?= Html::encode(Yii::t('doc', "In the task you could use this for possibly 'sound technition' or 'service organizer'. These are tasks that are performed throughout the service and not at any specific time slot."))?></td>	
					</tr>
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Default global order'))?> </td>
						<td><?= Html::encode(Yii::t('doc', "If 'Use Globally' is set to true, then you should fill in here number showing where on the task list you want this task to be shown. This is an integer."))?></td>	
						<td>1, 2, 3, 4, 5, ...</td>	
					</tr>
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Default Start Time'))?> </td>
						<td><?= Html::encode(Yii::t('doc', "If 'Use Globally' is set to false then this field could be set to the approximate time that this task will be performed. There is also good reason to leave this blank because then whoever writes the actual task will be forced to enter the correct time."))?></td>	
						<td>11:00  12:00</td>	
					</tr>
				</tbody>
			</table>
		</div>		
	</div>
</div> 