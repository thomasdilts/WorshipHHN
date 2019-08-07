<?php
use app\helpers\CssHelper;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Url;
use app\models\Language;
$language=Language::findOne(Yii::$app->user->identity->language_id);
$GLOBALS['urlAddition']=$urlAddition;
?>
<div class="row">
	<div class="col-lg-6">	
		<h1>
			<?= Html::encode( Yii::t('app', 'File sharing')) ?> 
			<span class="pull-right">
				<a href="<?=$backurl?>" class='btn btn-warning'><span class="glyphicon glyphicon-step-backward"></span><?=Yii::t('app', 'Return')?></a>
			</span>  				
		</h1>	
		<?= GridView::widget([
			'dataProvider' => $dataProvider,
			'filterModel' => $searchModel,
			'summary' => false,
			'columns' => [
				'name',
				'size',
				// buttons
				['class' => 'yii\grid\ActionColumn',
				'header' => Yii::t('app', 'Menu'),
				'template' => '{'.$filedownloadUrl .'} {'.$deletefileUrl.'}',
					'buttons' => [
						$filedownloadUrl => function ($url, $model, $key) {
							return Html::a('', $url. $GLOBALS['urlAddition'], ['title'=>Yii::t('app', 'Download'), 'class'=>'glyphicon glyphicon-download-alt menubutton']);
						},
						$deletefileUrl => function ($url, $model, $key) {
							return Html::a('', $url. $GLOBALS['urlAddition'], 
							['title'=>Yii::t('app', 'Delete'), 
								'class'=>'glyphicon glyphicon-trash menubutton',
								'data' => [
									'confirm' => Yii::t('app', 'Are you sure you want to delete this?'),
									'method' => 'post']
							]);
						}
					]

				], // ActionColumn

			], // columns

		]); ?>	
	</div>
	<div class="col-lg-6">	
		<?php $form = ActiveForm::begin(['id' => 'form-teamplayers']); ?>
			<h1>
				<?= Html::encode( Yii::t('app', 'Add files to file sharing')) ?> 		
			</h1>	
			<?= $form->field($model, 'imageFiles')->widget(FileInput::classname(), [
			    'options' => ['accept' => '*','multiple' => true],
			    'language' =>  $language->iso_name,
			]); ?>


			<!--<input id="input-b3" name="input-b3[]" type="file" class="file" multiple 
			data-show-upload="false" data-show-caption="true" data-msg-placeholder="Select {files} for upload...">-->
		<?php ActiveForm::end(); ?>		
	</div>
</div>
<script>

</script>