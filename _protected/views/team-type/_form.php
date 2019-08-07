<?php
use app\rbac\models\AuthItem;
use kartik\password\PasswordInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="teamtype-form">

    <?php $form = ActiveForm::begin(['id' => 'form-teamtype']); ?>

        <?= $form->field($model, 'name')->textInput(
                ['placeholder' => Yii::t('app', 'Create team type name'), 'autofocus' => true]) ?>

    <div class="form-group">     
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') 
            : Yii::t('app', 'Update'), ['class' => $model->isNewRecord 
            ? 'btn btn-success' : 'btn btn-primary']) ?>

        <?= Html::a(Yii::t('app', 'Cancel'), ['team-type/index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>
 
</div>