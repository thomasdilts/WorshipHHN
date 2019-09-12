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

$filterNameKeys=array_keys($filterNames);
$filtersArray=$filters?explode(':',$filters):array();

$this->title = Yii::t('app', 'Tasks by event');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Events'), 'url' => ['index?EventSearch%5Bfilter_start_date%5D='.$start.'&EventSearch%5Bfilter_end_date%5D='.$end]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tasks'), 'url' => ['alltasks?start='.$start.'&end='.$end]];
$this->params['breadcrumbs'][] = $this->title ;
?>
<style>
	.multiselect {
	  margin-left:-8px;
	  width: 115%;
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
		font-weight:normal;
		white-space: nowrap;
	  display: block;
	}

	#checkboxes label:hover {
	  background-color: #1e90ff;
	}
	#lables label {
		
	  display: block;
	}
</style>
<div class="eventtemplate-form">
	<div class="row">
		<h1 style="margin-left:15px;">
			<?= Html::encode( Yii::t('app', 'Tasks by event'))?>  
			<span class="pull-right" style="margin-bottom:5px;display:inline-block">
				<a href="exportalltasksbyevent?start=<?=$start?>&end=<?=$end?><?=$filters?'&filters='.$filters:''?>" class='btn btn-success'><span class="glyphicon glyphicon-download-alt"></span>Excel</a>
				<a href="alltasks?start=<?=$start?>&end=<?=$end?>" class='btn btn-warning'><span class="glyphicon glyphicon-step-backward"></span><?=Yii::t('app', 'Return')?></a>
			</span>  					
		</h1>
	</div>
	<div class="row">

	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th><?= Yii::t('app', 'Start Date')?> </th>
				<th><?= Yii::t('app', 'Event')?> 
				  <div class="multiselect">
					<div class="selectBox" onclick="showCheckboxes()">
					  <select>
						<option><?=Yii::t('app', 'Filter')?></option>
					  </select>
					  <div class="overSelect"></div>
					</div>
					<div id="checkboxes">
					<label for="all123"><input type="checkbox" id="all123" onChange="checkboxAll(true);" /><?=Yii::t('app', 'All')?></label>
					<label for="none123" style="border-bottom: 3px solid grey;" ><input type="checkbox" id="none123" onChange="checkboxAll(false);" /><?=Yii::t('app', 'None')?></label>
					<?php for($i=0;$i<count($filterNames);$i++){ 
						$isChecked=$filters?$filtersArray[$i]:true;					
						?>
						<label for="i<?=$i?>"><input <?=$isChecked?'checked':''?> type="checkbox" id="i<?=$i?>" onChange="checkboxChanged();" /><?=$filterNameKeys[$i]?></label>
					<?php } ?>
					</div>
				  </div>	

				  
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
				<td style="white-space: nowrap;"><?= $rowValue['event_name'] ?> </td>
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
var isInCodechecking=false;
function checkboxChanged(){
	if(isInCodechecking){
		return;
	}
	var filters='';
	for(var i=0;i< <?=count($filterNames)?>;i++){
		filters += filters.length>0?':':'';
		filters += $('#i'+i).is(':checked')?'1':'0';
	}
	
	window.location.href = "<?=URL::toRoute('event/alltasksbyevent').'?start='.$start . '&end='. $end . '&filters=' ?>" + filters;
}
function checkboxAll($ischecked){
	isInCodechecking=true;
	for(var i=0;i< <?=count($filterNames)?>;i++){
		$('#i'+i).prop('checked', $ischecked);
	}	
	isInCodechecking=false;
	checkboxChanged();
}

$( document ).ready(function() {
	<?php if($filters){ ?> 
	
	<?php } else {?> 
	
	<?php } ?> 
});
</script>