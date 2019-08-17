<?php
use app\rbac\models\AuthItem;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use nex\datepicker\DatePicker;
use yii\helpers\ArrayHelper;

?>
<div class="messagetemplate-form"> 

    <?php $form = ActiveForm::begin(['id' => 'form-messagetemplate']); ?>
        <?= $form->field($model, 'language_id')->dropDownList(ArrayHelper::map(app\models\Language::find()->where([
			'church_id' => $church_id])->orderBy("display_name_native ASC")->all(), 'id', 'display_name_native')) ?>
        <?= $form->field($model, 'message_type_id')->dropDownList(ArrayHelper::map(app\models\MessageType::find()->where([
            'church_id' => $church_id])->orderBy("name ASC")->all(), 'id', 'name')) ?>            
        <?= $form->field($model, 'name')->textInput(
                ['autofocus' => true]) ?>
        <?= $form->field($model, 'show_accept_button')->checkbox();?>
        <?= $form->field($model, 'accept_button_text')->textInput();?>
        <?= $form->field($model, 'show_reject_button')->checkbox();?>
        <?= $form->field($model, 'reject_button_text')->textInput();?>
        <?= $form->field($model, 'show_link_to_object')->checkbox();?>
        <?= $form->field($model, 'link_text')->textInput();?>
        <?= $form->field($model, 'allow_custom_message')->checkbox();?>
        <?= $form->field($model, 'use_auto_subject')->checkbox();?>
        <?= $form->field($model, 'subject')->textInput();?>
        <?= $form->field($model, 'body')->textArea();?>
		<div class="form-group">     
			<?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') 
				: Yii::t('app', 'Update'), ['class' => $model->isNewRecord 
				? 'btn btn-success' : 'btn btn-primary']) ?>

			<?= Html::a(Yii::t('app', 'Cancel'), ['message-template/index'], ['class' => 'btn btn-default']) ?>
		</div>

    <?php ActiveForm::end(); ?>
 
</div>