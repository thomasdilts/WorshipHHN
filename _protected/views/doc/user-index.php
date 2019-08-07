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
			<p><?= Html::encode(Yii::t('doc', "Here you can see and manage all your users. Here you have access to all levels of the users activities if you have the right permissions.")) ?></p>
			<p><?= Html::encode(Yii::t('doc', "Note that the column headers can be clicked on to sort the list by that column in ascending or descending order.")) ?></p>
			<p><?= Html::encode(Yii::t('doc', "Under the 'menu' column you can see up to five icons depending on what your permission level is. Each of these icons will send you to different aspects of the event or perform an action on the event plan. The icons are defined as follows")) ?></p>
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th></th>
						<th><?= Html::encode(Yii::t('doc', 'Description'))?></th>
					</tr>
				</thead> 
				<tbody>
					<tr>
						<td style="text-align:center"><span class="glyphicon glyphicon-eye-open" style="color:#337ab7;"></span></td>
						<td><?= Html::encode(Yii::t('doc', 'Click on this icon and you will see more details about the user.'))?></td>	 
					</tr>
					<tr>
						<td style="text-align:center"><span class="glyphicon glyphicon-tasks" style="color:#337ab7;"></span></td>
						<td><?= Html::encode(Yii::t('doc', 'Click on this icon and you will come to the main screen showing all the tasks to be accomplished by this user.'))?></td>	
					</tr>
					<tr>
						<td style="text-align:center"><span class="glyphicon glyphicon-ban-circle" style="color:#337ab7;"></span></td>
						<td><?= Html::encode(Yii::t('doc', 'Click on this icon to see all dates defined as being unavailable for this user.'))?></td>	
					</tr>
					<tr>
						<td style="text-align:center"><span class="glyphicon glyphicon-pencil" style="color:#337ab7;"></span></td>
						<td><?= Html::encode(Yii::t('doc', 'This is where you edit the profile of the user.'))?></td>	
					</tr>
					<tr>
						<td style="text-align:center"><span class="glyphicon glyphicon-trash" style="color:#337ab7;"></span></td>
						<td><?= Html::encode(Yii::t('doc', 'Here you delete a user. It is not so easy to delete a user. You must first delete all tasks assigned to the user as well as all notifications used by the user. Then it might be possible to do this delete function. Another way is to simply remove all rights for this person or you can even define the person as deleted or not active in the profile.'))?></td>	
					</tr>
				</tbody>
			</table>				 
		</div>
	</div>
</div> 