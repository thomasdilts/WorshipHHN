<?php
use app\helpers\CssHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use app\models\User;

$this->title = Yii::t('app', 'Team notify' . ' - ' . $model->name);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Teams'), 'url' => ['team/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Notifications'), 'url' => ['team/notifications?id='.$model->id]];
$this->params['breadcrumbs'][] = $this->title;

$GLOBALS['ids']=$ids;
$GLOBALS['team_id']=$model->id;
?>
<div class="team-notify">
	<div class="row">
		<div class="col-lg-6">
			<h1><?= Yii::t('app', 'Send text message to')?></h1>
			<?= GridView::widget([
				'dataProvider' => $membersNotify,
				'summary' => false,
				'columns' => [
					['class' => 'yii\grid\SerialColumn'],
		            [
		                'format' => 'raw',
		                'value' => function ($data) {
		                    return User::getThumbnailMedium($data->id);
		                }
		            ],					
					'display_name',
					// buttons
					['class' => 'yii\grid\ActionColumn',
					'header' => Yii::t('app', 'Menu'),
					'template' => '{removefromnotify} ',
						'buttons' => [
						   'removefromnotify' => function ($url, $model, $key) {
								return Html::a('', $url. '&teamid='.$GLOBALS['team_id'].'&ids='.$GLOBALS['ids'], ['title'=>Yii::t('app', 'Delete'), 'class'=>'glyphicon glyphicon-trash menubutton', 'style'=>Yii::$app->user->can('TeamManager')?'display:inline;':'display:none;' ]);
							},
						]

					], // ActionColumn

				], // columns

			]); ?>
		</div>		
	
	</div>
	<div class="row">
		<?php $form = ActiveForm::begin(['id' => 'team-notify']); ?>

			<?= $form->field($model, 'custom_sms')->textarea([ 'autofocus' => true]) ?>

		<div class="form-group">     
			<?= Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-success']) ?>

			<?= Html::a(Yii::t('app', 'Cancel'), ['team/notifications?id='.$model->id], ['class' => 'btn btn-default']) ?>
		</div>

		<?php ActiveForm::end(); ?>
	</div>
</div>