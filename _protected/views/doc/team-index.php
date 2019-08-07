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
			<p><?= Html::encode(Yii::t('doc', "")) ?></p>
			<p><?= Html::encode(Yii::t('doc', "This screen allows you to find the event plan you need to see or edit. Plus there are many different aspects of the event you can go to from this screen.")) ?></p>
			<p><?= Html::encode(Yii::t('doc', "The most important challange here is finding your event. There is a filter to aid in finding the event but this filter is shown as a button. Click on the icon to the right of the filter button and then the filter will open up and you can specify exactly what dates you are interested in seeing. If you hit the button 'clean' then you will empty the data fields. Then when you hit filter you will get all the defined events. By default you will see only events from today and 3 months forward in time.")) ?></p>
			<p><?= Html::encode(Yii::t('doc', "Note that the column headers can be clicked on to sort the list by that column in ascending or descending order.")) ?></p>
			<p><?= Html::encode(Yii::t('doc', "Under the 'menu' column you can see up to six icons depending on what your permission level is. Each of these icons will send you to different aspects of the team or perform an action on the team. The icons are defined as follows")) ?></p>
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
						<td><?= Html::encode(Yii::t('doc', 'Click on this icon and you will come to the main screen showing all the tasks to be accomplished by this team.'))?></td>	
					</tr>
					<tr>
						<td style="text-align:center"><span class="glyphicon glyphicon-user" style="color:#337ab7;"></span></td>
						<td><?= Html::encode(Yii::t('doc', 'Click on this icon and you will come to the list of all members of this team. You can also add new members from this screen if you have the right permissions.'))?></td>	
					</tr>
					<tr>
						<td style="text-align:center"><span class="glyphicon glyphicon-ban-circle" style="color:#337ab7;"></span></td>
						<td><?= Html::encode(Yii::t('doc', 'Click on this icon to see all dates you have defined as this team being unavailable. You can also add new unavailable dates from this screen if you have the right permissions.'))?></td>	
					</tr>
					<tr>
						<td style="text-align:center"><span class="glyphicon glyphicon-folder-open" style="color:#337ab7;"></span></td>
						<td><?= Html::encode(Yii::t('doc', 'This will take you to the file sharing area for the team.'))?></td>	
					</tr>
					<tr>
						<td style="text-align:center"><span class="glyphicon glyphicon-pencil" style="color:#337ab7;"></span></td>
						<td><?= Html::encode(Yii::t('doc', 'This is where you edit the name of the team and the team type.'))?></td>	
					</tr>
					<tr>
						<td style="text-align:center"><span class="glyphicon glyphicon-trash" style="color:#337ab7;"></span></td>
						<td><?= Html::encode(Yii::t('doc', 'Here you delete a team. It is not so easy to delete a team. You must first delete all tasks assigned to the team as well as all notifications used by the team. Then it is possible to do this delete function.'))?></td>	
					</tr>
				</tbody>
			</table>			
		</div>
	</div>
</div> 