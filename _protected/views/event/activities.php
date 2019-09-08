<?php
use app\rbac\models\AuthItem;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\i18n\Formatter;
use app\models\Notification;
use app\models\Activity;
use app\models\BibleVerse;
use yii\helpers\ArrayHelper;
use app\models\User;
use yii\helpers\Url;

$GLOBALS['event_id']=$model->id;
$GLOBALS['start_date']=$model->start_date;

$this->title = Yii::t('app', 'Tasks');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Events'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name . ' ' . Yii::$app->formatter->asDate($model->start_date, "Y-MM-dd H:mm");
?>

<div class="eventtemplate-form">
	<h1>
		<?= Html::encode( $model->name . ' ' . Yii::$app->formatter->asDate($model->start_date, "Y-MM-dd H:mm"))?>  
	</h1>
	<div class="row">

		<div class="col-lg-6">
			<h1>
				<?= Html::encode( Yii::t('app', 'Tasks'))?>  
				<span class="pull-right" style="margin-bottom:5px;display:inline-block">
					<a href="index" class='btn btn-warning'><span class="glyphicon glyphicon-step-backward"></span><?=Yii::t('app', 'Return')?></a>
					<a href="exportexcel?id=<?=$model->id?>" class='btn btn-success'><span class="glyphicon glyphicon-download-alt"></span>Excel</a>
					<a href="exportpdf?id=<?=$model->id?>" class='btn btn-success'><span class="glyphicon glyphicon-download-alt"></span>PDF</a>
					<a href='<?=URL::toRoute('doc/doc')?>?page=event-activities&returnName=<?=$this->title?>&returnUrl=<?=URL::toRoute('event/activities?id='.$model->id)?>' class='btn btn-primary'><span class="glyphicon glyphicon-question-sign"></span></a>
				</span>  			
			</h1>
			<?= GridView::widget([
				'dataProvider' => $dataMembersProvider,
				'summary' => false,
				'columns' => [
					[
						'attribute' => 'start_time',
						'format' => 'raw',
						'value' => function ($model, $index, $widget) {
							$value='';
							if($model->activityType->use_globally){
								$value=$model->global_order;
							}else{
								$value=$model->start_time==null || strlen($model->start_time)==0 ? '<span style="color:red">'.Yii::t('app', 'Missing').'</span>': 
								date('H:i',mktime( (int)substr($model->start_time, 0,2),(int)substr($model->start_time, 3,2),(int)substr($model->start_time, 6,2),1,1,1990));
							}
							if($model->activityType->use_globally || !Yii::$app->user->can('EventEditor')){
								return $value;
							}else{
								return $value . ' ' . Html::a('', URL::toRoute('event/uptime'). '?eventid='.$GLOBALS['event_id'].'&activityid='.$model->id, ['title'=>Yii::t('app', 'Add one minute to the duration'), 'class'=>'glyphicon glyphicon-triangle-top menubutton','id'=>'actid'.$model->id])
										. Html::a('', URL::toRoute('event/downtime'). '?eventid='.$GLOBALS['event_id'].'&activityid='.$model->id, ['title'=>Yii::t('app', 'Subtract one minute from the duration'), 'class'=>'glyphicon glyphicon-triangle-bottom menubutton','id'=>'actid'.$model->id]);
							}	
						},
					],				
					'name',
					[
						'format' => 'raw',
						'value' => function ($model, $index, $widget) {
							return Activity::getOtherColumnWeb($model,$GLOBALS['start_date']);
						},
					],					
					// buttons
					['class' => 'yii\grid\ActionColumn',
					'header' => Yii::t('app', 'Menu'),
					'template' => '{moveup} {movedown} {editactivity} {removefromevent}',
						'buttons' => [
							'moveup' => function ($url, $model, $key) {
								if($model->activityType->use_globally){
									return '';
								}else{
									return Yii::$app->user->can('EventEditor')?Html::a('', $url. '&eventid='.$GLOBALS['event_id'], ['title'=>Yii::t('app', 'Move the task up'), 'class'=>'glyphicon glyphicon-arrow-up menubutton']):'';
								}								
							},
							'movedown' => function ($url, $model, $key) {
								if($model->activityType->use_globally){
									return '';
								}else{
									return Yii::$app->user->can('EventEditor')?Html::a('', $url. '&eventid='.$GLOBALS['event_id'], ['title'=>Yii::t('app', 'Move the task down'), 'class'=>'glyphicon glyphicon-arrow-down menubutton']):'';
								}								
							},
							'editactivity' => function ($url, $model, $key) {
								return Yii::$app->user->can('EventEditor')?Html::a('', $url. '&eventid='.$GLOBALS['event_id'].'&returnurl=activities%3Fid%3D'.$GLOBALS['event_id'], ['title'=>Yii::t('app', 'Edit'), 'class'=>'glyphicon glyphicon-pencil menubutton']):'';
							},
							
							'removefromevent' => function ($url, $model, $key) {
								return Yii::$app->user->can('EventEditor')?Html::a('', $url. '&eventid='.$GLOBALS['event_id'], 
								['title'=>Yii::t('app', 'Remove task from the event'), 
									'class'=>'glyphicon glyphicon-trash menubutton',
									'data' => [
										'confirm' => Yii::t('app', 'Are you sure you want to delete this?'),
										'method' => 'post']
								]):'';
							}
						]

					], // ActionColumn

				], // columns

			]); ?>				
			
		</div>		

	</div>
	<div class="row">
	
		<?php if(Yii::$app->user->can('EventEditor')) { ?>
			<div class="col-lg-6">
				<h1>
					<?= Html::encode( Yii::t('app', 'Add task to the event'))?>  
				</h1>
				<?= GridView::widget([
					'dataProvider' => $dataTypesProvider,
					'filterModel' => $searchTypesModel,
					'summary' => false,
					'columns' => [

						'name',
						// buttons
						['class' => 'yii\grid\ActionColumn',
						'header' => Yii::t('app', 'Menu'),
						'template' => '{addtoevent}',
							'buttons' => [
								'addtoevent' => function ($url, $model, $key) {
									global $teamid;
									return Html::a('', $url. '&eventid='.$GLOBALS['event_id'], ['title'=>Yii::t('app', 'Add task to the event'), 'class'=>'glyphicon glyphicon-plus']);
								}
							]

						], // ActionColumn

					], // columns

				]); ?>				
				
			</div>
		<?php } ?>	
	</div>
</div>
<script>
$( document ).ready(function() {
	<?php if($activityid){ ?>
		$(document).scrollTop( $("#actid<?=$activityid?>").offset().top-100 );  
	<?php } ?>
});
$(function() {
});

</script>