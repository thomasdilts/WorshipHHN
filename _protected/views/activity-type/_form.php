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
		<?= $form->field($model, 'using_team')->dropDownList(['Not used'=>Yii::t('app', 'Not used'),'Allow'=>Yii::t('app', 'Allow'),'Demand'=>Yii::t('app', 'Demand')],['onChange'=>'redrawScreen();']) ?>
        <div id="using_the_team" style = "padding-left:30px">
		<?= $form->field($model, 'allow_freehand_team')->checkbox();?>
		<?= $form->field($model, 'team_type_id')->dropDownList(ArrayHelper::map(app\models\TeamType::find()->where([
					'church_id' => $model->church_id])->orderBy("name ASC")->all(), 'id', 'name'),['prompt' => Yii::t('app', 'Select')]) ?>
		</div>
		<?= $form->field($model, 'using_user')->dropDownList(['Not used'=>Yii::t('app', 'Not used'),'Allow'=>Yii::t('app', 'Allow'),'Demand'=>Yii::t('app', 'Demand'),],['onChange'=>'redrawScreen();']) ?>
        <div id="using_the_user" style = "padding-left:30px">
		<?= $form->field($model, 'allow_freehand_user')->checkbox();?>
        <?= $form->field($model, 'notify_user_event_errors')->checkbox();?>
		</div>
		<?= $form->field($model, 'description')->dropDownList(['Not used'=>Yii::t('app', 'Not used'),'Allow'=>Yii::t('app', 'Allow'),'Demand'=>Yii::t('app', 'Demand'),]) ?>
		<?= $form->field($model, 'using_song')->dropDownList(['Not used'=>Yii::t('app', 'Not used'),'Allow'=>Yii::t('app', 'Allow'),'Demand'=>Yii::t('app', 'Demand'),]) ?>
		<?= $form->field($model, 'file')->dropDownList(['Not used'=>Yii::t('app', 'Not used'),'Allow'=>Yii::t('app', 'Allow'),'Demand'=>Yii::t('app', 'Demand'),]) ?>
		<?= $form->field($model, 'bible_verse')->dropDownList(['Not used'=>Yii::t('app', 'Not used'),'Allow'=>Yii::t('app', 'Allow'),'Demand'=>Yii::t('app', 'Demand'),]) ?>
		<?= $form->field($model, 'special_needs')->dropDownList(['Not used'=>Yii::t('app', 'Not used'),'Allow'=>Yii::t('app', 'Allow'),'Demand'=>Yii::t('app', 'Demand'),]) ?>

		
        <?= $form->field($model, 'use_globally')->checkbox(['onChange'=>'redrawScreen();']);?>
		<div id="using_use_globally" style = "padding-left:30px">
        <?= $form->field($model, 'default_global_order')->textInput(['type' => 'number','placeholder' => Yii::t('app', 'Integer value')]);?>
		</div>
		<div class="form-group">     
			<?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') 
				: Yii::t('app', 'Update'), ['class' => $model->isNewRecord 
				? 'btn btn-success' : 'btn btn-primary']) ?>

			<?= Html::a(Yii::t('app', 'Cancel'), ['activity-type/index'], ['class' => 'btn btn-default']) ?>
		</div>

    <?php ActiveForm::end(); ?>
 
</div>
<script>
function redrawScreen(){
	
	if($('#activitytype-using_team').val()=='Not used'){
		$( "#using_the_team" ).hide();
		$( "#activitytype-allow_freehand_team" ).prop( "checked", false );
	}else{
		$( "#using_the_team" ).show();
	}
	if($('#activitytype-using_user').val()=='Not used' ){
		$( "#using_the_user" ).hide();
		$( "#activitytype-allow_freehand_user" ).prop( "checked", false );
		$( "#activitytype-notify_user_event_errors" ).prop( "checked", false );
	}else{
		$( "#using_the_user" ).show();
	}
	if($('#activitytype-use_globally').is(":checked")){
		$( "#using_use_globally" ).show();
	}else{
		$( "#activitytype-default_global_order" ).val('0');
		$( "#using_use_globally" ).hide();
	}
}

$( document ).ready(function() {
	redrawScreen()
});
</script>