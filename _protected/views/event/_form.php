<?php
use app\rbac\models\AuthItem;
use app\models\EventTemplate;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use nex\datepicker\DatePicker;
use app\models\Language;
$language=Language::findOne(Yii::$app->user->identity->language_id);

?>
<div class="event-form">

	<div class="col-lg-6">
		<?php $form = ActiveForm::begin(['id' => 'form-event']); ?>

			<?= $form->field($model, 'name')->textInput(
					['placeholder' => Yii::t('app', 'Create Event name'), 'autofocus' => true]) ?>
			<?= $form->field($model, 'description')->textarea(
					['placeholder' => Yii::t('app', 'Description')]) ?>
			<?= $form->field($model, 'start_date')->widget(
				DatePicker::className(), [
					'addon' => false,
					'size' => 'sm',	
					'language'=>Language::getLanguageIsoNameForCalendar($language),				
					'clientOptions' => [
						'format' => 'YYYY-MM-DD HH:mm:ss',
						'stepping' => 1,
					],
			]);?>
			<?= $form->field($model, 'end_date')->widget(
				DatePicker::className(), [
					'addon' => false,
					'size' => 'sm',
					'language'=>Language::getLanguageIsoNameForCalendar($language),		
					'clientOptions' => [
						'format' => 'YYYY-MM-DD HH:mm:ss',
						'stepping' => 1,
					],
			]);?>
			<?= Html::activeHiddenInput($model, 'church_id') ?>
			<?php if($model->copyFromEventId) {?>
				<?= Html::activeHiddenInput($model, 'copyFromEventId') ?>			
				<?= $form->field($model, 'copy_persons_teams')->checkbox();?>
				<?= $form->field($model, 'copy_all_songs')->checkbox();?>
				<?= $form->field($model, 'number_weeks_repeat')->textInput();?>
			<?php } ?>
			<div class="form-group">     
				<?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') 
					: Yii::t('app', 'Update'), ['class' => $model->isNewRecord 
					? 'btn btn-success' : 'btn btn-primary']) ?>

				<?= Html::a(Yii::t('app', 'Cancel'), ['event/index'], ['class' => 'btn btn-default']) ?>
			</div>

		<?php ActiveForm::end(); ?>

	</div>

</div>