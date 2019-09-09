<?php
use app\rbac\models\AuthItem;
use kartik\password\PasswordInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="church-form">

    <?php $form = ActiveForm::begin(['id' => 'form-church']); ?>

        <?= $form->field($model, 'name')->textInput(
                ['placeholder' => Yii::t('app', 'Create church name'), 'autofocus' => true]) ?>
        <?= $form->field($model, 'admin_email')->input('email', ['placeholder' => Yii::t('app', 'Enter admin e-mail')]) ?>
        <?= $form->field($model, 'time_zone')->textInput() ?>
        <?= $form->field($model, 'paper_size')->textInput() ?>
        <?= $form->field($model, 'paper_margin_top_bottom')->input('float') ?>
        <?= $form->field($model, 'paper_margin_right_left')->input('float') ?>
        <?= $form->field($model, 'refuse_task_days')->input('integer') ?>

    <div class="form-group">     
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') 
            : Yii::t('app', 'Update'), ['class' => $model->isNewRecord 
            ? 'btn btn-success' : 'btn btn-primary']) ?>

        <?= Html::a(Yii::t('app', 'Cancel'), Yii::$app->user->can('theCreator')?['church/index']:['/home'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>
 
</div>