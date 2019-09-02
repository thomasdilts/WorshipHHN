<?php
use app\rbac\models\AuthItem;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\i18n\Formatter;
use app\models\Team;
use yii\helpers\ArrayHelper;
use app\models\User;
use app\models\Church;
use yii\helpers\Url;
use thomasdilts\sms_worshiphhn\Sms;

$GLOBALS['event_id']=$model->id;
$GLOBALS['start_date']=$model->start_date;
$church=Church::findOne(Yii::$app
	->user
	->identity
	->church_id);
$GLOBALS['time_zone']=$church->time_zone;
Yii::$app->formatter->defaultTimeZone=$church->time_zone;
Yii::$app->formatter->timeZone=$church->time_zone;

//$uriParts=explode('/',$_SERVER['REQUEST_URI']);
//$GLOBALS['eventuri']='/'.$uriParts[1].'/'.$uriParts[2];

$this->title = Yii::t('app', 'Notifications');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Events'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name . ' ' . Yii::$app->formatter->asDate($model->start_date, "Y-MM-dd H:mm");
?>

<div id="always_showing" class="eventtemplate-form">
	<div class="row">
	<h1>
		<?= Html::encode( $model->name . ' ' . Yii::$app->formatter->asDate($model->start_date, "Y-MM-dd H:mm"))?>  
	</h1>
		<h1>
			<?= Html::encode( Yii::t('app', 'Users in the event'))?>  
			<span class="pull-right">
				<a href="index" class='btn btn-warning'><span class="glyphicon glyphicon-step-backward"></span><?=Yii::t('app', 'Return')?></a>
				<?php if(Yii::$app->user->can('EventManager')) { ?>
					<a href='notify?eventid=<?=$model->id?>&userid=0&actionid=0' class='btn btn-success'><span class="glyphicon glyphicon-envelope"></span><?=Yii::t('app', 'Notify All')?></a>
				<?php } ?>
				<a href='<?=URL::toRoute('doc/doc')?>?page=event-notifications&returnName=<?=$this->title?>&returnUrl=<?=URL::toRoute('event/notifications?id='.$model->id)?>' class='btn btn-primary'><span class="glyphicon glyphicon-question-sign"></span></a>
			</span>  			
		</h1>
		<div id="w0" class="">
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th><?= Yii::t('app', 'Tasks')?> </th>
						<th> </th>
						<th><?= Yii::t('app', 'User')?> </th>
						<th><?= Yii::t('app', 'Team')?> </th>
						<th class="action-column"><?= Yii::t('app', 'Menu')?></th>
					</tr>
				</thead> 
				<tbody>
					<?php 

					foreach($userArray as $row){ ?>
							<tr data-key="2">
								<td><?= $row['name']  ?></td>
								<td><?= User::getThumbnailMedium($row['user_id'])?><a href="mailto:<?=$row['email']?>"><?=$row['email']?></a> </td>
								<td><?= $row['display_name'] ?></td>
								<td><?= $row['teamname'] ?></td>
								<td>
									<?php if(Yii::$app->user->can('EventManager')) { ?>
										<a class="glyphicon glyphicon-envelope" href="<?='notify?eventid='.$GLOBALS['event_id'].'&userid='.$row['user_id'].'&actionid='.$row['action_id']?>" title="Notify"></a>
									<?php } ?>
								</td>
							</tr>

					<?php } ?>
				</tbody>
			</table>
		</div>		
		
	</div>
	<div class="row">
		<h1>
			<?= Html::encode( Yii::t('app', 'Notifications'))?>  
			<?php if(Yii::$app->user->can('EventManager') && Yii::$app->has('SmsMessaging') && (Yii::$app->SmsMessaging->getImplementationLevel()&Sms::IMPLEMENTED_ID_AND_STATUS)==Sms::IMPLEMENTED_ID_AND_STATUS) { ?>
				<span class="pull-right">				
					<?php $form = ActiveForm::begin(['id' => 'form-notifications','action'=>'notifications?id='.$model->id]); ?>         
						<div class="form-group">     
							<?= Html::submitButton(Yii::t('app', 'Refresh SMS status'), ['class' => 'btn btn-primary']) ?>
						</div>
					<?php ActiveForm::end(); ?>			
				</span>  
			<?php } ?>
		</h1>
		<div id="div_wide" style="display:none;">
			<?= GridView::widget([
				'dataProvider' => $dataNotificationProvider,
				'summary' => false,
				'columns' => [
					[
						'attribute' => 'status',
						'format' => 'raw',
						'value' => function ($model, $index, $widget) {
							$colors=array('Not replied yet'=>'yellow','Accepted'=>'lightgreen','Rejected'=>'lightpink','No reply requested'=>'lightgreen',);
							return "<span style='background-color:".$colors[$model->status] . ";'>" . Yii::t('app', $model->status) . '</span>';
						},
					],					
					[
						'format' => 'raw',
						'value' => function ($data) {
							return User::getThumbnailMedium($data->user->id);
						}
					],
					'user.display_name',
					[ //team name
						'attribute' => 'team_id',
						'format' => 'raw',
						'value' => function ($model, $index, $widget) {
							return $model->team!=null ? $model->team->name:'';
						},
					],					
					'activity.name',
					[
						'attribute' => 'notified_date',
						'format' => 'raw',
						'value' => function ($model, $index, $widget) {
							if($model->notified_date==null || strlen($model->notified_date)==0){
								return '';
							}
							$dt = new DateTime($model->notified_date, new DateTimeZone('UTC'));
							$dt->setTimezone(new DateTimeZone($GLOBALS['time_zone']));
							return $dt->format('Y-m-d H:i');
						},
					],				
					[
						'attribute' => 'notify_replied_date',
						'format' => 'raw',
						'value' => function ($model, $index, $widget) {
							if($model->notify_replied_date==null || strlen($model->notify_replied_date)==0){
								return '';
							}
							$dt = new DateTime($model->notify_replied_date, new DateTimeZone('UTC'));
							$dt->setTimezone(new DateTimeZone($GLOBALS['time_zone']));
							return $dt->format('Y-m-d H:i');
						},
					],
					[
						'attribute' => 'sms_status',
						'format' => 'raw',
						'value' => function ($model, $index, $widget) {
							return $model->sms_status_id . ': ' . Yii::t('app', $model->sms_status);
						},
					],			
					// buttons
		            ['class' => 'yii\grid\ActionColumn',
		            'header' => Yii::t('app', 'Menu'),
		            'template' => '{seenotify} {deletenotify}',
		                'buttons' => [
		                    'seenotify' => function ($url, $model, $key) {
		                        return Html::a('', $url . '&eventid='.$GLOBALS['event_id'], ['title'=>Yii::t('app', 'See details'), 'class'=>'glyphicon glyphicon-eye-open menubutton']);
		                    },
		                    'deletenotify' => function ($url, $model, $key) {
		                        return Yii::$app->user->can('EventManager')?Html::a('', $url . '&eventid='.$GLOBALS['event_id'], ['title'=>Yii::t('app', 'Delete'), 'class'=>'glyphicon glyphicon-trash menubutton','data' => [
											'confirm' => Yii::t('app', 'Are you sure you want to delete this?'),
											'method' => 'post']]):'';
		                    },
		                ]

		            ], // ActionColumn								
					
				], // columns

			]); ?>				
		</div>
		<div id="div_thin" style="display:none">
<style>
.grid-view td {
    white-space: normal;
}
</style>		
			<?= GridView::widget([
				'dataProvider' => $dataNotificationProvider,
				'summary' => false,
				'columns' => [
					[
						'attribute' => 'status',
						'format' => 'raw',
						'value' => function ($model, $index, $widget) {
							$colors=array('Not replied yet'=>'yellow','Accepted'=>'lightgreen','Rejected'=>'lightpink','No reply requested'=>'lightgreen',);
							return "<span style='background-color:".$colors[$model->status] . ";'>" . Yii::t('app', $model->status) . '</span>';
						},
					],					
					[
						'format' => 'raw',
						'value' => function ($data) {
							return User::getThumbnailMedium($data->user->id);
						}
					],
					[ 
						'attribute' => 'user.display_name',
						'format' => 'raw',
						'value' => function ($model, $index, $widget) {
							$value = $model->user->display_name;
							$value .= $model->team!=null ? '<br />' . $model->team->name:'';
							$value .= '<br />' . $model->activity->name;
							return $value;
						},
					],					
					[
						'attribute' => 'dates',
						'format' => 'raw',
						'value' => function ($model, $index, $widget) {
							$value='';
							if($model->notified_date==null || strlen($model->notified_date)==0){
								//nothing
							}else{
								$dt = new DateTime($model->notified_date, new DateTimeZone('UTC'));
								$dt->setTimezone(new DateTimeZone($GLOBALS['time_zone']));
								$value .= $dt->format('Y-m-d H:i');
							}
							if($model->notify_replied_date==null || strlen($model->notify_replied_date)==0){
								//nothing
							}else{
								$dt = new DateTime($model->notify_replied_date, new DateTimeZone('UTC'));
								$dt->setTimezone(new DateTimeZone($GLOBALS['time_zone']));
								$value .= '<br />'.$dt->format('Y-m-d H:i');
							}
							return $value;
						},
					],				
					[
						'attribute' => 'sms_status',
						'format' => 'raw',
						'value' => function ($model, $index, $widget) {
							return $model->sms_status_id . ': ' . Yii::t('app', $model->sms_status);
						},
					],				
					// buttons
		            ['class' => 'yii\grid\ActionColumn',
		            'header' => Yii::t('app', 'Menu'),
		            'template' => '{seenotify} {deletenotify}',
		                'buttons' => [
		                    'seenotify' => function ($url, $model, $key) {
		                        return Html::a('', $url . '&eventid='.$GLOBALS['event_id'], ['title'=>Yii::t('app', 'See details'), 'class'=>'glyphicon glyphicon-eye-open menubutton']);
		                    },
		                    'deletenotify' => function ($url, $model, $key) {
		                        return Yii::$app->user->can('EventManager')?Html::a('', $url . '&eventid='.$GLOBALS['event_id'], ['title'=>Yii::t('app', 'Delete'), 'class'=>'glyphicon glyphicon-trash menubutton','data' => [
											'confirm' => Yii::t('app', 'Are you sure you want to delete this?'),
											'method' => 'post']]):'';
		                    },
		                ]

		            ], // ActionColumn								
					
				], // columns

			]); ?>	
		</div>
	</div>
</div>
<script>
	function showThinScreen(){
		if($(window).outerWidth()<768){
			$( "#div_wide" ).hide();
			$( "#div_thin" ).show();
		}
		else{
			$( "#div_wide" ).show();
			$( "#div_thin" ).hide();
		}		
	}
	$( document ).ready(function() {
		showThinScreen();
		$( window ).on('resize', function() {
			showThinScreen();
		});
	});

</script>