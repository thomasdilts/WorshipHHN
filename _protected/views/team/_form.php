<?php
use app\rbac\models\AuthItem;
use kartik\password\PasswordInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


?>
<div class="team-form">

    <?php $form = ActiveForm::begin(['id' => 'form-team']); ?>

        <?= $form->field($model, 'name')->textInput(
                ['placeholder' => Yii::t('app', 'Create team type name'), 'autofocus' => true]) ?>
		<?= $form->field($model, 'team_type_id')->dropDownList(ArrayHelper::map(app\models\TeamType::find()->where([
			'church_id' => $church_id])->orderBy("name ASC")->all(), 'id', 'name')) ?>

    <div class="form-group">     
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') 
            : Yii::t('app', 'Update'), ['class' => $model->isNewRecord 
            ? 'btn btn-success' : 'btn btn-primary']) ?>

        <?= Html::a(Yii::t('app', 'Cancel'), ['team/index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>
 
</div>