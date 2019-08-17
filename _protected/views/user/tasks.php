<?php
use app\helpers\CssHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use nex\datepicker\DatePicker;
use app\models\Notification;
use yii\helpers\ArrayHelper;
use app\models\User;
use app\models\Language;

$language=Language::findOne(Yii::$app->user->identity->language_id);
$this->title = Yii::t('app', 'Tasks') . ' - ' .$model->display_name;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-task">
	<div class="row">
		<h1>
			<?= Html::encode($this->title) . User::getThumbnailMedium($model->id) ?>
			<span class="pull-right" style="margin-bottom:5px">
				<a href="taskexportexcel?id=<?=$model->id?>&start=<?=$searchModel->filter_start_date?>&end=<?=$searchModel->filter_end_date?>" class='btn btn-success'><span class="glyphicon glyphicon-download-alt"></span>Excel</a>
				<a href="taskexportpdf?id=<?=$model->id?>&start=<?=$searchModel->filter_start_date?>&end=<?=$searchModel->filter_end_date?>" class='btn btn-success'><span class="glyphicon glyphicon-download-alt"></span>PDF</a>
				<a href="taskexportics?id=<?=$model->id?>&start=<?=$searchModel->filter_start_date?>&end=<?=$searchModel->filter_end_date?>" class='btn btn-success'><span class="glyphicon glyphicon-download-alt"></span><?=Yii::t('app', 'Calendar')?>-ICS</a>					
				<a href='<?=URL::toRoute('doc/doc')?>?page=user-activities&returnName=<?=$this->title?>&returnUrl=<?=URL::toRoute('user/tasks?id='.$model->id)?>' class='btn btn-primary'><span class="glyphicon glyphicon-question-sign"></span></a>			                 
			</span>  		
		</h1>
	</div>
	<div class="row">
        <div class="col-sm-3">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <strong><?php echo Yii::t('app', 'Filters');?>
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFilter" aria-expanded="true" aria-controls="collapseFilter">
                      <span class="glyphicon glyphicon-resize-small pull-right" aria-hidden="true"></span>
                    </a>
                  </strong>
                </div>
                <div id="collapseFilter" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">

					<?php $form = ActiveForm::begin([
						'action' => ['user/tasks','id'=>$model->id],
						'method' => 'get',
					]); ?>

					<div class="row">
						<div class="col-sm-11">
							<?= $form->field($searchModel, 'filter_start_date')->widget(
								DatePicker::className(), [
									'addon' => false,
									'size' => 'sm',			
									'language'=>Language::getLanguageIsoNameForCalendar($language),		
									'clientOptions' => [
										'format' => 'YYYY-MM-DD',
										'stepping' => 1,
									],
							]);?>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-11">
							<?= $form->field($searchModel, 'filter_end_date')->widget(
								DatePicker::className(), [
									'addon' => false,
									'size' => 'sm',		
									'language'=>Language::getLanguageIsoNameForCalendar($language),			
									'clientOptions' => [
										'format' => 'YYYY-MM-DD',
										'stepping' => 1,
									],
							]);?>

						</div>
					</div>

					<div class="form-group">
						<?= Html::submitButton('<i class="fa fa-filter"></i> ' . Yii::t('app', 'Filter'), ['class' => 'btn btn-primary']) ?>
						<?= Html::resetButton('<i class="fa fa-eraser"></i> ' . Yii::t('app', 'Clean'), ['class' => 'btn btn-default', 'onClick'=>'$( "#useractivitysearch-filter_start_date" ).val("");$( "#useractivitysearch-filter_end_date" ).val("");return false;']) ?>
					</div>

					<?php ActiveForm::end(); ?>

                  </div>
                </div>
              </div>
            </div>
        </div>
		<div class="col-sm-9">
			<div id="div_wide" style="display:none">
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
							'attribute' => 'team',
							'format' => 'raw',
							'value' => function ($model, $index, $widget) {
								return $model->team ? Html::encode($model->team->name) : '';
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
						// buttons
						['class' => 'yii\grid\ActionColumn',
						'header' => Yii::t('app', 'Menu'),
						'template' => '{taskaccept} {taskreject}',
							'buttons' => [
								'taskaccept' => function ($url, $model, $key) {
									return $model->team || Yii::$app->user->identity->id != $model->user_id?'':Html::a('', $url, 
									['title'=>Yii::t('app', 'Accept'), 
										'class'=>'glyphicon glyphicon-check menubutton',
										'data' => [
											'confirm' => Yii::t('app', 'Are you sure you want to accept this task?'),
											'method' => 'post']
									]);
								},
								'taskreject' => function ($url, $model, $key) {
									return $model->team || Yii::$app->user->identity->id != $model->user_id?'':Html::a('', $url, 
									['title'=>Yii::t('app', 'Delete'), 
										'class'=>'glyphicon glyphicon-trash menubutton',
										'data' => [
											'confirm' => Yii::t('app', 'Are you sure you want to reject this task?'),
											'method' => 'post']
									]);
								}
							]

						], // ActionColumn

					], // columns

				]); ?>
			</div>
			<div id="div_thin" style="display:none">			
				<?= GridView::widget([
					'dataProvider' => $dataProvider,

					'summary' => false,
					'columns' => [
						[
							'attribute' => 'event.name',
							'format' => 'raw',
							'value' => function ($model, $index, $widget) {
								$value=Html::a($model->event->name, URL::toRoute('event/activities'). '?id='.$model->event->id, ['title'=>Yii::t('app', 'View')]);
								$value.= '<br />'.date('Y-m-d H:i',strtotime($model->event->start_date));
								return $value;
							},
						],										
						[
							'attribute' => 'name',
							'format' => 'raw',
							'value' => function ($model, $index, $widget) {
								$value=Yii::$app->user->can('EventManager')?
									Html::a($model->name, URL::toRoute('event/editactivity'). '?id='.$model->id.'&eventid='.$model->event->id, ['title'=>Yii::t('app', 'View')])
									:Html::encode($model->name);
								$value.=$model->team ? '<br />'.Html::encode($model->team->name) : '';
								$notifications= Notification::find()->where(['activity_id'=>$model->id])->all();
								if($notifications && count($notifications)>0) {									
									$statuses = ArrayHelper::getColumn($notifications,'status');
									if(in_array('Accepted',$statuses)){
										$value.='<br /><span style="color:lightgreen">'.Yii::t('app', 'Accepted').'</span>';
									}elseif(in_array('Not replied yet',$statuses)) {
										$value.='<br /><span style="color:goldenrod">'.Yii::t('app', 'Not replied yet').'</span>';
									}elseif(in_array('Rejected',$statuses)) {
										$value.='<br /><span style="color:red">'.Yii::t('app', 'Rejected').'</span>';
									}
								}
								if(isset($model->team) && $model->team->IsTeamBlocked($model->event->start_date)){
									$value.='<br /><span style="color:red">'.Yii::t('app', 'Unavailable-team').'</span>';													
								}elseif(isset($model->user) && $model->user->IsUserBlocked($model->event->start_date)){
									$value.='<br /><span style="color:red">'.Yii::t('app', 'Unavailable-user').'</span>';							
								}
								return $value;
							},
						],													
						// buttons
						['class' => 'yii\grid\ActionColumn',
						'header' => Yii::t('app', 'Menu'),
						'template' => '{taskaccept} {taskreject}',
							'buttons' => [
								'taskaccept' => function ($url, $model, $key) {
									return $model->team|| Yii::$app->user->identity->id != $model->user_id?'':Html::a('', $url, 
									['title'=>Yii::t('app', 'Accept'), 
										'class'=>'glyphicon glyphicon-check menubutton',
										'data' => [
											'confirm' => Yii::t('app', 'Are you sure you want to accept this task?'),
											'method' => 'post']
									]);
								},
								'taskreject' => function ($url, $model, $key) {
									return $model->team|| Yii::$app->user->identity->id != $model->user_id?'':Html::a('', $url, 
									['title'=>Yii::t('app', 'Delete'), 
										'class'=>'glyphicon glyphicon-trash menubutton',
										'data' => [
											'confirm' => Yii::t('app', 'Are you sure you want to reject this task?'),
											'method' => 'post']
									]);
								}
							]

						], // ActionColumn

					], // columns

				]); ?>
			</div>
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
