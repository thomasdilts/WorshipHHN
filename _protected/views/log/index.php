<?php
use app\helpers\CssHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use nex\datepicker\DatePicker;
use app\models\Language;
use app\models\LogSearch;
use app\models\Church;
use yii\helpers\Url;

$language=Language::findOne(Yii::$app->user->identity->language_id);
$this->title = Yii::t('app', 'Activity log');
$this->params['breadcrumbs'][] = $this->title;

$church= Church::findOne(Yii::$app
	->user
	->identity
	->church_id);	
$GLOBALS['churchTimeZone']=$church->time_zone;	
?>
<div class="user-index">
    <h1>
        <?= Html::encode($this->title) ?>     
    </h1>
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
										'format' => 'YYYY-MM-DD HH:mm:ss',
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
										'format' => 'YYYY-MM-DD HH:mm:ss',
										'stepping' => 1,
									],
							]);?>

						</div>
					</div>

					<div class="form-group">
						<?= Html::submitButton('<i class="fa fa-filter"></i> ' . Yii::t('app', 'Filter'), ['class' => 'btn btn-primary']) ?>
						<?= Html::resetButton('<i class="fa fa-eraser"></i> ' . Yii::t('app', 'Clean'), ['class' => 'btn btn-default', 'onClick'=>'$( "#logsearch-filter_start_date" ).val("");$( "#logsearch-filter_end_date" ).val("");return false;']) ?>
					</div>

					<?php ActiveForm::end(); ?>

                  </div>
                </div>
              </div>
            </div>
        </div>
	</div>	
<style>
.grid-view td {
    white-space: normal;
}
</style>
	<div class="row">
		<?= GridView::widget([
			'dataProvider' => $dataProvider,
			'filterModel' => $searchModel,
			'summary' => false,
			'columns' => [
				[
					'attribute' => 'datestamp',
					'format' => 'raw',
					'value' => function ($model, $index, $widget) {
						return LogSearch::date_convert($model->datestamp, 'UTC', 'Y-m-d H:i:s', $GLOBALS['churchTimeZone'], 'Y-m-d H:i:s');
					},
				],						
				'place',
				'what',
				'who:email',
				'before',
				'after',
			], // columns

		]); ?>
	</div>
</div>
