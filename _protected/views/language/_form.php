<?php
use app\rbac\models\AuthItem;
use kartik\password\PasswordInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="teamtype-form">

    <?php $form = ActiveForm::begin(['id' => 'form-teamtype']); ?>

        <?= $form->field($model, 'iso_name')->textInput(
                ['placeholder' => Yii::t('app', 'ISO Name (xx or xx_xx)'), 'autofocus' => true]) ?>
        <?= $form->field($model, 'display_name_english')->textInput(
                ['placeholder' => Yii::t('app', 'Display Name English'), 'autofocus' => true]) ?>
        <?= $form->field($model, 'display_name_native')->textarea(
                ['placeholder' => Yii::t('app', 'Display Name Natie'), 'autofocus' => true]) ?>

    <div class="form-group">     
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') 
            : Yii::t('app', 'Update'), ['class' => $model->isNewRecord 
            ? 'btn btn-success' : 'btn btn-primary']) ?>

        <?= Html::a(Yii::t('app', 'Cancel'), ['language/index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?> 
 
</div>