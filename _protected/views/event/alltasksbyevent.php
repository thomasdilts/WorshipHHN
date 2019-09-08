<?php
use app\rbac\models\AuthItem;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\i18n\Formatter;
use app\models\Notification;
use app\models\Activity;
use app\models\EventActivitySearch;
use app\models\EventNameFilter;
use app\models\BibleVerse;
use yii\helpers\ArrayHelper;
use app\models\User;
use yii\helpers\Url;

$filterNameKeys=array_keys($filterNames);

$this->title = Yii::t('app', 'Tasks by event');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Events'), 'url' => ['index?EventSearch%5Bfilter_start_date%5D='.$start.'&EventSearch%5Bfilter_end_date%5D='.$end]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tasks'), 'url' => ['alltasks?start='.$start.'&end='.$end]];
$this->params['breadcrumbs'][] = $this->title ;
?>
<style>
	.multiselect {
	  width: 180px;
	}

	.selectBox {
	  position: relative;
	}

	.selectBox select {
	  width: 100%;
	  font-weight: normal;
	}

	.overSelect {
	  position: absolute;
	  left: 0;
	  right: 0;
	  top: 0;
	  bottom: 0;
	}

	#checkboxes {
	  display: none;
	  border: 1px #dadada solid;
	}

	#checkboxes label {
	  display: block;
	}

	#checkboxes label:hover {
	  background-color: #1e90ff;
	}

</style>
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
				<th><?= Yii::t('app', 'Event')?> 
				<?php $form = ActiveForm::begin(['id' => 'form-event']); ?>
				  <div class="multiselect">
					<div class="selectBox" onclick="showCheckboxes()">
					  <select>
						<option><?=Yii::t('app', 'Filter')?></option>
					  </select>
					  <div class="overSelect"></div>
					</div>
					<div id="checkboxes">
					<?php for($i=0;$i<EventNameFilter::NUM_VARIABLES && $i<count($filterNames);$i++){ 
					$options = ['onChange'=>"this.form.submit()"];
					if($model->{'i'.$i}){
						$options['checked']='checked';
					}					
					?>
					<?= $form->field($model, 'i'.$i)->checkbox($options)?>
					<?php } ?>
					</div>
				  </div>	
				<?php ActiveForm::end(); ?>
				  
				</th>
				<th><?= Yii::t('app', 'Description')?> </th>
				<?php foreach($columns as $key => $value){?>  
					<th><?= $value['name'] ?> </th>
				<?php } ?>  
			</tr>
		</thead> 
		<tbody>
			<?php $isWhiteRow=true;
				foreach( $dataRows as $rowKey=>$rowValue){
				$isWhiteRow = !$isWhiteRow;
				?>  
				<tr <?= $isWhiteRow?'style="background-color:white;"':''  ?> >
				<td><?= $rowValue['start_date'] ?> </td>
				<td><?= $rowValue['event_name'] ?> </td>
				<td><?= $rowValue['description'] ?> </td>
				
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
<script>
var expanded = false;
function showCheckboxes() {
  var checkboxes = document.getElementById("checkboxes");
  if (!expanded) {
    checkboxes.style.display = "block";
    expanded = true;
  } else {
    checkboxes.style.display = "none";
    expanded = false;
  }
}
$( document ).ready(function() {
});
</script>