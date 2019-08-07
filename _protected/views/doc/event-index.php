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
			<p><?= Html::encode(Yii::t('doc', "This screen allows you to find the event plan you need to see or edit. Plus there are many different aspects of the event you can go to from this screen.")) ?></p>
			<p><?= Html::encode(Yii::t('doc', "The most important challange here is finding your event. There is a filter to aid in finding the event but this filter is shown as a button. Click on the icon to the right of the filter button and then the filter will open up and you can specify exactly what dates you are interested in seeing. If you hit the button 'clean' then you will empty the data fields. Then when you hit filter you will get all the defined events. By default you will see only events from today and 3 months forward in time.")) ?></p>
			<p><?= Html::encode(Yii::t('doc', "Note that the column headers can be clicked on to sort the list by that column in ascending or descending order.")) ?></p>
			<p><?= Html::encode(Yii::t('doc', "Under the 'menu' column you can see up to six icons depending on what your permission level is. Each of these icons will send you to different aspects of the event or perform an action on the event plan. The icons are defined as follows")) ?></p>
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th></th>
						<th><?= Html::encode(Yii::t('doc', 'Description'))?></th>
					</tr>
				</thead> 
				<tbody>
					<tr>
						<td style="text-align:center"><span class="glyphicon glyphicon-tasks" style="color:#337ab7;"></span></td>
						<td><?= Html::encode(Yii::t('doc', 'Click on this icon and you will come to the main screen showing all the tasks to be accomplished in the event.'))?></td>	
					</tr>
					<tr>
						<td style="text-align:center"><span class="glyphicon glyphicon-envelope" style="color:#337ab7;"></span></td>
						<td><?= Html::encode(Yii::t('doc', 'Click on this icon and you will come to the notifications screen. There you can send notifications to any or all persons defined in the event plan. Also you can see all notifications that have been previously sent as well as the current status of those notifications.'))?></td>	
					</tr>
					<tr>
						<td style="text-align:center"><span class="glyphicon glyphicon-duplicate" style="color:#337ab7;"></span></td>
						<td><?= Html::encode(Yii::t('doc', 'Click on this icon to copy a event to a new event. This allows you to very quickly start defining new events.'))?></td>	
					</tr>
					<tr>
						<td style="text-align:center"><span class="glyphicon glyphicon-folder-open" style="color:#337ab7;"></span></td>
						<td><?= Html::encode(Yii::t('doc', 'This will take you to the file sharing area for the specific event. However, inside of the event you can attach files to individual tasks. Here is for putting files that you can\'t find a specific task to attach to.'))?></td>	
					</tr>
					<tr>
						<td style="text-align:center"><span class="glyphicon glyphicon-pencil" style="color:#337ab7;"></span></td>
						<td><?= Html::encode(Yii::t('doc', 'This is where you edit the name of the event and the start and end time of the event. That is all. The main editing is always done by clicking on the task icon'))?></td>	
					</tr>
					<tr>
						<td style="text-align:center"><span class="glyphicon glyphicon-trash" style="color:#337ab7;"></span></td>
						<td><?= Html::encode(Yii::t('doc', 'Here you delete an event. It is not so easy to delete an event. You must first delete all tasks used in the event as well as all notifications used in the event. Then it is possible to do this delete function.'))?></td>	
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div> 