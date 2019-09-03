<?php
use app\helpers\CssHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use nex\datepicker\DatePicker;
use app\models\Language;
use yii\helpers\Url;

$language=Language::findOne(Yii::$app->user->identity->language_id);
$this->title = Yii::t('app', 'Event');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
	<div class="row">
		<h1 style="margin-left:15px;">
			<?= Html::encode($this->title) ?>
			<span class="pull-right" style="margin-bottom:5px;">
				<?php if(Yii::$app->user->can('EventManager')) { ?>
					<a href='create' class='btn btn-success'><span class="glyphicon glyphicon-plus"></span><?=Yii::t('app', 'Create Event')?></a>
				<?php } ?>        	
				<a href='alltasks?start=<?=$searchModel->filter_start_date?>&end=<?=$searchModel->filter_end_date?>' class='btn btn-primary'><span class="glyphicon glyphicon-tasks"></span><?=Yii::t('app', 'Tasks')?></a>
				<a href='<?=URL::toRoute('doc/doc')?>?page=event-index&returnName=<?=$this->title?>&returnUrl=<?=URL::toRoute('event/index')?>%3Ftemp%3Dtemp' class='btn btn-primary'><span class="glyphicon glyphicon-question-sign"></span></a>
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
						'action' => ['index'],
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
						<?= Html::resetButton('<i class="fa fa-eraser"></i> ' . Yii::t('app', 'Clean'), ['class' => 'btn btn-default', 'onClick'=>'$( "#eventsearch-filter_start_date" ).val("");$( "#eventsearch-filter_end_date" ).val("");return false;']) ?>
					</div>

					<?php ActiveForm::end(); ?>

                  </div>
                </div>
              </div>
            </div>
        </div>

		<div class="col-sm-9">
			<?= GridView::widget([
				'dataProvider' => $dataProvider,
				'filterModel' => $searchModel,
				'summary' => false,
				'columns' => [
					[
						'attribute' => 'start_date',
						'format' => 'raw',
						'value' => function ($model, $index, $widget) {
							return date('Y-m-d H:i',strtotime($model->start_date));
						},
					],						
					'name',
					// buttons
					['class' => 'yii\grid\ActionColumn',
					'header' => Yii::t('app', 'Menu'),
					'template' => '{activities} {notifications} {files} {copy} {update} {delete}',
						'buttons' => [
							'activities' => function ($url, $model, $key) {
								return Html::a('', $url, ['title'=>Yii::t('app', 'Tasks'), 'class'=>'glyphicon glyphicon-tasks menubutton']);
							},
							'notifications' => function ($url, $model, $key) {
								return Html::a('', $url, ['title'=>Yii::t('app', 'Notifications'), 'class'=>'glyphicon glyphicon-envelope menubutton']);
							},
							'files' => function ($url, $model, $key) {
								return Html::a('', $url, ['title'=>Yii::t('app', 'Shared files'), 'class'=>'glyphicon glyphicon-folder-open menubutton']);
							},
							'copy' => function ($url, $model, $key) {
								return Yii::$app->user->can('EventManager')?Html::a('', $url, 
								['title'=>Yii::t('app', 'Copy'), 
									'class'=>'glyphicon glyphicon-duplicate menubutton',
									'data' => [
										'confirm' => Yii::t('app', 'Are you sure you want to copy this event?'),
										'method' => 'post']									
								]):'';
							},
							'update' => function ($url, $model, $key) {
								return Yii::$app->user->can('EventManager')?Html::a('', $url, 
								['title'=>Yii::t('app', 'Edit'), 
									'class'=>'glyphicon glyphicon-pencil menubutton']):'';
							},
							'delete' => function ($url, $model, $key) {
								return Yii::$app->user->can('EventManager')?Html::a('', $url, 
								['title'=>Yii::t('app', 'Delete'), 
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
</div>
