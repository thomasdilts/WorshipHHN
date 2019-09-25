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

$GLOBALS['team_id']=$model->id;
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
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Teams'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name ;

$allMemberIds = implode('.',ArrayHelper::getColumn($dataMembersProvider->query->all(),'id'));
?>

<div id="always_showing" class="eventtemplate-form">
	<div class="row">
		<div class="col-lg-6">
			<h1>
				<?= Html::encode($this->title).' - '. Html::encode($model->name)?>  
				<span class="pull-right">
					<a href="index" class='btn btn-warning'><span class="glyphicon glyphicon-step-backward"></span><?=Yii::t('app', 'Return')?></a>
					<?php if(Yii::$app->user->can('EventManager')) { ?>
						<a href='notify?teamid=<?=$model->id?>&id=<?=$allMemberIds?>' class='btn btn-success'><span class="glyphicon glyphicon-envelope"></span><?=Yii::t('app', 'Notify All')?></a>
					<?php } ?>
					<a href='<?=URL::toRoute('doc/doc')?>?page=team-players&returnName=<?=$this->title?>&returnUrl=<?=URL::toRoute('team/players?id='.$model->id)?>' class='btn btn-primary'><span class="glyphicon glyphicon-question-sign"></span></a>			                 
				</span>  				
			</h1>
			<a href="mailto:<?=implode(';',ArrayHelper::getColumn($dataMembersProvider->query->all(), 'email', false))?>"><?=Yii::t('app', 'Send mail to all team members')?></a>

			<?= GridView::widget([
				'dataProvider' => $dataMembersProvider,
				'filterModel' => $searchMembersModel,
				'summary' => false,
				'columns' => [
					['class' => 'yii\grid\SerialColumn'],
		            [
		                'format' => 'raw',
		                'value' => function ($data) {
		                    return User::getThumbnailMedium($data->id);
		                }
		            ],					
					'display_name',
					'email:email',
					// buttons
					['class' => 'yii\grid\ActionColumn',
					'header' => Yii::t('app', 'Menu'),
					'template' => '{notify} ',
						'buttons' => [
						   'notify' => function ($url, $model, $key) {
								return Html::a('', $url. '&teamid='.$GLOBALS['team_id'], ['title'=>Yii::t('app', 'Notification'), 'class'=>'glyphicon glyphicon-envelope menubutton', 'style'=>Yii::$app->user->can('TeamManager')?'display:inline;':'display:none;' ]);
							},
						]

					], // ActionColumn

				], // columns

			]); ?>
		</div>		
	
	</div>
	<div class="row">
		<h1>
			<?= Html::encode( Yii::t('app', 'Notifications'))?>  
			<?php if(Yii::$app->user->can('TeamManager') && Yii::$app->has('SmsMessaging') && (Yii::$app->SmsMessaging->getImplementationLevel()&Sms::IMPLEMENTED_ID_AND_STATUS)==Sms::IMPLEMENTED_ID_AND_STATUS) { ?>
				<span class="pull-right">				
					<?php $form = ActiveForm::begin(['id' => 'form-notifications','action'=>'notifications?id='.$model->id]); ?>         
						<div class="form-group">     
							<?= Html::submitButton(Yii::t('app', 'Refresh SMS status'), ['class' => 'btn btn-primary']) ?>
						</div>
					<?php ActiveForm::end(); ?>			
				</span>  
			<?php } ?>
		</h1>
		<div id="div_wide">
			<?= GridView::widget([
				'dataProvider' => $dataNotificationProvider,
				//'filterModel' => $searchNotificationModel,
				'summary' => false,
				'columns' => [			
					[
						'attribute' => 'from',
						'format' => 'raw',
						'value' => function ($data) {
							return User::getThumbnailMedium($data->user_from_id);
						}
					],
					'userFrom.display_name',
					[
						'attribute' => 'to',
						'format' => 'raw',
						'value' => function ($data) {
							return User::getThumbnailMedium($data->user_to_id);
						}
					],
					'userTo.display_name',					
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
		                        return Html::a('', $url . '&teamid='.$GLOBALS['team_id'], ['title'=>Yii::t('app', 'See details'), 'class'=>'glyphicon glyphicon-eye-open menubutton']);
		                    },
		                    'deletenotify' => function ($url, $model, $key) {
		                        return Yii::$app->user->can('TeamManager')?Html::a('', $url . '&teamid='.$GLOBALS['team_id'], ['title'=>Yii::t('app', 'Delete'), 'class'=>'glyphicon glyphicon-trash menubutton','data' => [
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
