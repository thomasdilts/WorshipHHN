<?php
use app\helpers\CssHelper;
use yii\helpers\Html;
use kartik\file\FileInput;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use app\models\Language;
$language=Language::findOne(Yii::$app->user->identity->language_id);

$this->title = Yii::t('app', 'Import Songs') ;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Songs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title ;

?>
<div class="song-import">

    <h1><?= Html::encode($this->title) ?></h1>

	<div class="row">

		<div class="col-lg-6">	
			<?php $form = ActiveForm::begin(['id' => 'form-teamplayers']); ?>
				<h1>
					<?= Html::encode( Yii::t('app', 'Add files to file sharing')) ?> 		
				</h1>	
                        <?= $form->field($model, 'imageFiles[]')->widget(FileInput::classname(), [
                            'options' => ['accept' => $mimeType,'multiple' => false],
                            'language' =>  $language->iso_name,
                        ]); ?>
				
				
				<!--<input id="input-b3" name="input-b3[]" type="file" class="file" multiple 
				data-show-upload="false" data-show-caption="true" data-msg-placeholder="Select {files} for upload...">-->
			<?php ActiveForm::end(); ?>		
		</div>
	</div>

</div>
