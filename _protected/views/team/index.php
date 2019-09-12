<?php
use app\helpers\CssHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Teams');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="team-index">

	<div class="row">
		<h1 style="margin-left:15px;">
			<?= Html::encode($this->title) ?>
			<?php if(Yii::$app->user->can('TeamManager')){ ?> 
			<span class="pull-right">
				<?php if(Yii::$app->user->can('EventManager')) { ?>
					<a href='create' class='btn btn-success'><span class="glyphicon glyphicon-plus"></span><?=Yii::t('app', 'Create Team')?></a>
				<?php } ?>               
				<a href='<?=URL::toRoute('doc/doc')?>?page=team-index&returnName=<?=$this->title?>&returnUrl=<?=URL::toRoute('team/index')?>%3Ftemp%3Dtemp' class='btn btn-primary'><span class="glyphicon glyphicon-question-sign"></span></a>			                 
			</span>     
			<?php } ?> 		
		</h1>
	</div>
	<div class="row">
		<?= GridView::widget([
			'dataProvider' => $dataProvider,
			'filterModel' => $searchModel,
			'summary' => false,
			'columns' => [
				['class' => 'yii\grid\SerialColumn'],
				'name',
				[
					'attribute' => 'teamtypename',
					'format' => 'raw',
					'value' => function ($model, $index, $widget) {
						return $model->teamType->name;
					},
				],
				// buttons
				['class' => 'yii\grid\ActionColumn',
				'header' => Yii::t('app', 'Menu'),
				'template' => '{tasks} {players} {unavailability} {files} {update} {delete}',
					'buttons' => [
						'tasks' => function ($url, $model, $key) {
							return Html::a('', $url, ['title'=>Yii::t('app', 'Tasks'), 'class'=>'glyphicon glyphicon-tasks menubutton']);
						},
						'players' => function ($url, $model, $key) {
							return Html::a('', $url, ['title'=>Yii::t('app', 'Team members'), 'class'=>'glyphicon glyphicon-user menubutton']);
						},
						'files' => function ($url, $model, $key) {
							return Html::a('', $url, ['title'=>Yii::t('app', 'Files'), 'class'=>'glyphicon glyphicon-folder-open menubutton']);
						},
						'unavailability' => function ($url, $model, $key) {
							return Html::a('', $url , ['title'=>Yii::t('app', 'Unavailability'), 'class'=>'glyphicon glyphicon-ban-circle menubutton']);
						},
						'update' => function ($url, $model, $key) {
							return Html::a('', $url, ['title'=>Yii::t('app', 'Edit'), 'class'=>'glyphicon glyphicon-pencil menubutton', 'style'=>Yii::$app->user->can('TeamManager')?'display:inline;':'display:none;']);
						},
						'delete' => function ($url, $model, $key) {
							return Html::a('', $url, 
							['title'=>Yii::t('app', 'Delete team'), 
								'class'=>'glyphicon glyphicon-trash menubutton',
								'style'=>Yii::$app->user->can('ChurchAdmin')?'display:inline;':'display:none;',
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
</div>
