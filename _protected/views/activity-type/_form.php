<?php
use app\rbac\models\AuthItem;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use nex\datepicker\DatePicker;
use yii\helpers\ArrayHelper;
use app\models\Language;

$language=Language::findOne(Yii::$app->user->identity->language_id);
?>
 
<div class="activitytype-form">

    <?php $form = ActiveForm::begin(['id' => 'form-activitytype']); ?>

        <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
		<?= $form->field($model, 'using_team')->dropDownList(['Not used'=>Yii::t('app', 'Not used'),'Allow'=>Yii::t('app', 'Allow'),'Demand'=>Yii::t('app', 'Demand'),]) ?>
		<?= $form->field($model, 'team_type_id')->dropDownList(ArrayHelper::map(app\models\TeamType::find()->where([
					'church_id' => $model->church_id])->orderBy("name ASC")->all(), 'id', 'name'),['prompt' => Yii::t('app', 'Select')]) ?>
		<?= $form->field($model, 'using_user')->dropDownList(['Not used'=>Yii::t('app', 'Not used'),'Allow'=>Yii::t('app', 'Allow'),'Demand'=>Yii::t('app', 'Demand'),]) ?>
        <?= $form->field($model, 'notify_user_event_errors')->checkbox();?>
		<?= $form->field($model, 'description')->dropDownList(['Not used'=>Yii::t('app', 'Not used'),'Allow'=>Yii::t('app', 'Allow'),'Demand'=>Yii::t('app', 'Demand'),]) ?>
		<?= $form->field($model, 'using_song')->dropDownList(['Not used'=>Yii::t('app', 'Not used'),'Allow'=>Yii::t('app', 'Allow'),'Demand'=>Yii::t('app', 'Demand'),]) ?>
		<?= $form->field($model, 'file')->dropDownList(['Not used'=>Yii::t('app', 'Not used'),'Allow'=>Yii::t('app', 'Allow'),'Demand'=>Yii::t('app', 'Demand'),]) ?>
		<?= $form->field($model, 'bible_verse')->dropDownList(['Not used'=>Yii::t('app', 'Not used'),'Allow'=>Yii::t('app', 'Allow'),'Demand'=>Yii::t('app', 'Demand'),]) ?>
		<?= $form->field($model, 'special_needs')->dropDownList(['Not used'=>Yii::t('app', 'Not used'),'Allow'=>Yii::t('app', 'Allow'),'Demand'=>Yii::t('app', 'Demand'),]) ?>

		
        <?= $form->field($model, 'use_globally')->checkbox();?>
        <?= $form->field($model, 'default_global_order')->textInput(['type' => 'number','placeholder' => Yii::t('app', 'Integer value')]);?>
		<?= $form->field($model, 'default_start_time')->widget(
			DatePicker::className(), [
				'addon' => false,
				'size' => 'sm',
				'language'=>Language::getLanguageIsoNameForCalendar($language),
				'clientOptions' => [
					'format' => 'HH:mm',
					'stepping' => 1,
				],
		]);?>
		<div class="form-group">     
			<?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') 
				: Yii::t('app', 'Update'), ['class' => $model->isNewRecord 
				? 'btn btn-success' : 'btn btn-primary']) ?>

			<?= Html::a(Yii::t('app', 'Cancel'), ['activity-type/index'], ['class' => 'btn btn-default']) ?>
		</div>

    <?php ActiveForm::end(); ?>
 
</div>