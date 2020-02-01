<?php
use app\helpers\CssHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Picture;
use app\models\File;
use yii\helpers\Url;


$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Picture'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$GLOBALS['fileVault'] = substr(Yii::$app->params['fileVaultPath'],strlen(dirname(__DIR__,3)));
?>
<div class="picture-view">

	<div class="row">
		<h1 style="margin-left:15px;">
			<?= Html::encode($this->title) ?>
			<div class="pull-right">
            <a href='<?=URL::toRoute('doc/doc')?>?page=picture-index&returnName=<?=Yii::t('app', 'Picture')?>&returnUrl=<?=URL::toRoute('picture/index')?>%3Ftemp%3Dtemp' class='btn btn-primary'><span class="glyphicon glyphicon-question-sign"></span></a>			                 
			</div>
		</h1>
	</div>
	<div class="row">
		<?= DetailView::widget([
			'model' => $model,
			'attributes' => [		
				'name',
				[
					'attribute' => 'description',
					'contentOptions' => ['style' =>'white-space:pre-line;'],

				],    				
				[
					'attribute' => 'imageFiles',
					'format' => 'raw',
					'value' => function ($model) {
						$image=File::findOne(['model'=>$model->tableName(),'itemId'=>$model->id]);
						return $image==null?'':'<a href="'.Yii::$app->request->baseUrl. $GLOBALS['fileVault']. DIRECTORY_SEPARATOR . $image->hash.'" ><img src="'. Yii::$app->request->baseUrl. $GLOBALS['fileVault']. DIRECTORY_SEPARATOR . $image->hash.'" style="max-width:400px"></a>';
					}
				],		
			],
		]) ?>
	</div>
</div>