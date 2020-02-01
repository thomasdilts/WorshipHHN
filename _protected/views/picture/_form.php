<?php
use app\rbac\models\AuthItem;
use kartik\password\PasswordInput;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Language;
$language=Language::findOne(Yii::$app->user->identity->language_id);
$fileVault = substr(Yii::$app->params['fileVaultPath'],strlen(dirname(__DIR__,3)));
?>
<div class="picture-form">

    <?php $form = ActiveForm::begin(['id' => 'form-picture']); ?>

        <?= $form->field($model, 'name')->textInput(
                ['placeholder' => Yii::t('app', 'Name'), 'autofocus' => true]) ?>
        <?= $form->field($model, 'description')->textarea(
                ['placeholder' => Yii::t('app', 'Description')]) ?>		

	<?php if(!$image) { ?>
		<?= $form->field($model, 'imageFiles')->widget(FileInput::classname(), [
			'options' => ['accept' => 'image/*','multiple' => false],
			'language' =>  $language->iso_name,
		]); ?>
	<?php } ?>	
		
    <div class="form-group">     
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') 
            : Yii::t('app', 'Update'), ['class' => $model->isNewRecord 
            ? 'btn btn-success' : 'btn btn-primary']) ?>

        <?= Html::a(Yii::t('app', 'Cancel'), ['picture/index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?> 
	
	
	<?php if($image) { ?>
		<img src="<?=Yii::$app->request->baseUrl. $fileVault. DIRECTORY_SEPARATOR .$image->hash?>" style='max-width:500px'>
		<?php $form = ActiveForm::begin(['id' => 'form-user2','action'=>'deletefile?id='.$image->id]); ?>
		 <?= Html::submitButton(Yii::t('app', 'Delete the photo'), ['class' => 'btn btn-primary']) ?>
		<?php ActiveForm::end(); ?>
	<?php } ?>		
 
</div>