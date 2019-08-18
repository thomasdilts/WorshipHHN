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

$this->title = Yii::t('app', 'Tasks');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Events'), 'url' => ['index']];
?>

<div class="eventtemplate-form">
	<h1>
		<?= Html::encode( Yii::t('app', 'Tasks'))?>  
		<span class="pull-right">
			<a href="index" class='btn btn-warning'><span class="glyphicon glyphicon-step-backward"></span><?=Yii::t('app', 'Return')?></a>
		</span>  			
	</h1>
	<div class="row">

		<div class="col-lg-6">

				<?= GridView::widget([
					'dataProvider' => $dataProvider,

					'summary' => false,
					'columns' => [
						[
							'attribute' => 'event.name',
							'format' => 'raw',
							'value' => function ($model, $index, $widget) {
								return Html::a($model->event->name, URL::toRoute('event/activities'). '?id='.$model->event->id, ['title'=>Yii::t('app', 'View')]);
							},
						],						
						[
							'attribute' => 'start_date',
							'format' => 'raw',
							'value' => function ($model, $index, $widget) {
								return date('Y-m-d H:i',strtotime($model->event->start_date));
							},
						],						
						[
							'attribute' => 'team.name',
							'format' => 'raw',
							'value' => function ($model, $index, $widget) {
								return $model->team ? Html::encode($model->team->name) : '';
							},
						],					
						[
							'format' => 'raw',
							'value' => function ($model) {
								return $model->user ? User::getThumbnailMedium($model->user->id):'';
							}
						],
						[
							'attribute' => 'user.display_name',
							'format' => 'raw',
							'value' => function ($model, $index, $widget) {
								return $model->user ? Html::encode($model->user->display_name) : '';
							},
						],					
						[
							'attribute' => 'status',
							'format' => 'raw',
							'value' => function ($model, $index, $widget) {
								$value='';
								$notifications= Notification::find()->where(['activity_id'=>$model->id])->all();
								if($notifications && count($notifications)>0) {									
									$statuses = ArrayHelper::getColumn($notifications,'status');
									if(in_array('Accepted',$statuses)){
										$value.='<span style="color:lightgreen">'.Yii::t('app', 'Accepted').'</span>';
									}elseif(in_array('Not replied yet',$statuses)) {
										$value.='<span style="color:goldenrod">'.Yii::t('app', 'Not replied yet').'</span>';
									}elseif(in_array('Rejected',$statuses)) {
										$value.='<span style="color:red">'.Yii::t('app', 'Rejected').'</span>';
									}
								}
								if(isset($model->team) && $model->team->IsTeamBlocked($model->event->start_date)){
									$value.=strlen($value)>0?'; ':'';
									$value.='<span style="color:red">'.Yii::t('app', 'Unavailable-team').'</span>';													
								}elseif(isset($model->user) && $model->user->IsUserBlocked($model->event->start_date)){
									$value.=strlen($value)>0?'; ':'';
									$value.='<span style="color:red">'.Yii::t('app', 'Unavailable-user').'</span>';							
								}

								return $value;
							},
						],						
						[
							'attribute' => 'name',
							'format' => 'raw',
							'value' => function ($model, $index, $widget) {

								return Yii::$app->user->can('EventManager')?
									Html::a($model->name, URL::toRoute('event/editactivity'). '?id='.$model->id.'&eventid='.$model->event->id, ['title'=>Yii::t('app', 'View')])
									:Html::encode($model->name);
							},
						],						

					], // columns

				]); ?>
			
			
		</div>		
	</div>
	
</div>