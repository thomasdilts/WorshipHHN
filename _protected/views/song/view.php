<?php
use app\helpers\CssHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Song;
use yii\helpers\Url;


$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Song'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="song-view">

	<div class="row">
		<h1 style="margin-left:15px;">
			<?= Html::encode($this->title) ?>
			<div class="pull-right">
            <a href='<?=URL::toRoute('doc/doc')?>?page=song-index&returnName=<?=Yii::t('app', 'Song')?>&returnUrl=<?=URL::toRoute('song/index')?>%3Ftemp%3Dtemp' class='btn btn-primary'><span class="glyphicon glyphicon-question-sign"></span></a>			                 
			</div>
		</h1>
	</div>
	<div class="row">
		<?= DetailView::widget([
			'model' => $model,
			'attributes' => [		
				'name',
				'name2',
				'author',
				[
					'attribute' => 'description',
					'format' => 'raw',
					'value' => function ($model, $index) {
						$value=str_replace("\r\n", '<br />', $model->description);
						$value=str_replace("\n", '<br />', $value);
						return $value;
					},
				],
			],
		]) ?>
	</div>
</div>