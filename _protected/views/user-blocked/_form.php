<?php
use app\rbac\models\AuthItem;
use app\models\EventTemplate;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use nex\datepicker\DatePicker;
use app\models\Language;
$language=Language::findOne(Yii::$app->user->identity->language_id);
Yii::setAlias('@bower', dirname(__DIR__,2). DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'bower-asset');
?>
<div class="user-blocked-form">

	<div class="col-lg-6">
		<?php $form = ActiveForm::begin(['id' => 'form-user-blocked']); ?>

			<?= $form->field($model, 'start_date')->widget(
				DatePicker::className(), [
					'addon' => false,
					'size' => 'sm',
					'language'=>Language::getLanguageIsoNameForCalendar($language),					
					'clientOptions' => [
						'format' => 'YYYY-MM-DD',
						'stepping' => 1,
					],
			]);?>
			<?= $form->field($model, 'end_date')->widget(
				DatePicker::className(), [
					'addon' => false,
					'size' => 'sm',
					'language'=>Language::getLanguageIsoNameForCalendar($language),					
					'clientOptions' => [
						'format' => 'YYYY-MM-DD',
						'stepping' => 1,
					],
			]);?>
			<div class="form-group">     
				<?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') 
					: Yii::t('app', 'Update'), ['class' => $model->isNewRecord 
					? 'btn btn-success' : 'btn btn-primary']) ?>

				<?= Html::a(Yii::t('app', 'Cancel'), ['user-blocked/index?id='.$model->user_id], ['class' => 'btn btn-default']) ?>
			</div>

		<?php ActiveForm::end(); ?>

	</div>

</div>