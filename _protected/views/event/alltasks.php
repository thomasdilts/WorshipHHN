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

$GLOBALS['filter_start_date']=$searchModel->filter_start_date;
$GLOBALS['filter_end_date']=$searchModel->filter_end_date;

$this->title = Yii::t('app', 'Tasks');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Events'), 'url' => ['index?EventSearch%5Bfilter_start_date%5D='.$searchModel->filter_start_date.'&EventSearch%5Bfilter_end_date%5D='.$searchModel->filter_end_date]];
$this->params['breadcrumbs'][] = $this->title ;
?>

<div class="eventtemplate-form">
	<div class="row">
		<h1 style="margin-left:15px;">
			<?= Html::encode( Yii::t('app', 'Tasks'))?>  
			<span class="pull-right" style="margin-bottom:5px;">
				<a href='alltasksbyevent?start=<?=$searchModel->filter_start_date?>&end=<?=$searchModel->filter_end_date?>' class='btn btn-primary'><span class="glyphicon glyphicon-tasks"></span><?=Yii::t('app', 'Tasks by event')?></a>
				<a href="index?EventSearch%5Bfilter_start_date%5D=<?=$searchModel->filter_start_date?>&EventSearch%5Bfilter_end_date%5D=<?=$searchModel->filter_end_date?>" class='btn btn-warning'><span class="glyphicon glyphicon-step-backward"></span><?=Yii::t('app', 'Return')?></a>
			</span>  			
		</h1>
	</div>
	<div class="row">

		<div class="col-lg-6">

				<?= GridView::widget([
					'dataProvider' => $dataProvider,
					'filterModel' => $searchModel,
					'summary' => false,
					'columns' => [
						[
							'attribute' => 'event_name',
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
							'attribute' => 'team_name',
							'format' => 'raw',
							'value' => function ($model, $index, $widget) {
								return $model->team ? Html::encode($model->team->name) : ($model->freehand_team?$model->freehand_team:'');
							},
						],					
						[
							'format' => 'raw',
							'value' => function ($model) {
								return $model->user ? User::getThumbnailMedium($model->user->id):'';
							}
						],
						[
							'attribute' => 'user_display_name',
							'format' => 'raw',
							'value' => function ($model, $index, $widget) {
								return $model->user ? Html::encode($model->user->display_name) : ($model->freehand_user?$model->freehand_user:'');
							},
						],					
						[
							'attribute' => 'status',
							'format' => 'raw',
							'value' => function ($model, $index, $widget) {
								return EventActivitySearch::getStatus($model)[0];
							},
						],						
						[
							'attribute' => 'name',
							'format' => 'raw',
							'value' => function ($model, $index, $widget) {

								return Yii::$app->user->can('EventManager')?
									Html::a($model->name, URL::toRoute('event/editactivity'). '?id='.$model->id.'&eventid='.$model->event->id.'&returnurl=alltasks%3Fstart%3D'.$GLOBALS['filter_start_date'] . '%26end%3D'.$GLOBALS['filter_end_date'], ['title'=>Yii::t('app', 'View')])
									:Html::encode($model->name);
							},
						],						

					], // columns

				]); ?>
			
			
		</div>		
	</div>
	
</div>