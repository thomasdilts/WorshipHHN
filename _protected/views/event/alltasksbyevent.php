<?php
use app\rbac\models\AuthItem;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\i18n\Formatter;
use app\models\Notification;
use app\models\Activity;
use app\models\EventActivitySearch;
use app\models\BibleVerse;
use yii\helpers\ArrayHelper;
use app\models\User;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Tasks by event');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Events'), 'url' => ['index?EventSearch%5Bfilter_start_date%5D='.$start.'&EventSearch%5Bfilter_end_date%5D='.$end]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tasks'), 'url' => ['alltasks?start='.$start.'&end='.$end]];
$this->params['breadcrumbs'][] = $this->title ;
?>

<div class="eventtemplate-form">
	<h1>
		<?= Html::encode( Yii::t('app', 'Tasks by event'))?>  
		<span class="pull-right" style="margin-bottom:5px;display:inline-block">
			<a href="exportalltasksbyevent?start=<?=$start?>&end=<?=$end?>" class='btn btn-success'><span class="glyphicon glyphicon-download-alt"></span>Excel</a>
			<a href="alltasks?start=<?=$start?>&end=<?=$end?>" class='btn btn-warning'><span class="glyphicon glyphicon-step-backward"></span><?=Yii::t('app', 'Return')?></a>
		</span>  					
	</h1>
	<div class="row">

	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th><?= Yii::t('app', 'Start Date')?> </th>
				<th><?= Yii::t('app', 'Event')?> </th>
				<?php foreach($columns as $key => $value){?>  
					<th><?= $value['name'] ?> </th>
				<?php } ?>  
			</tr>
		</thead> 
		<tbody>
			<?php foreach( $dataRows as $rowKey=>$rowValue){?>  
				<tr>
				<td><?= $rowValue['start_date'] ?> </td>
				<td><?= $rowValue['event_name'] ?> </td>
				
				<?php foreach($columns as $key=>$value){?>  
					<?php if(array_key_exists($value['id'],$rowValue)){ ?> 
						<td><?= $rowValue[$value['id']]['text'] ?> </td>
					<?php }else{ ?>  
						<td></td>
					<?php } ?>  
				<?php } ?>  
				<tr>
			<?php } ?>  			
		</tbody>
	</table>			
	
	</div>
	
</div>