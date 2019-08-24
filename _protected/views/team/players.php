<?php
use app\helpers\CssHelper;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use app\models\User;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Team Members');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Teams'), 'url' => ['team/index']];;
$this->params['breadcrumbs'][] = $this->title;
$GLOBALS['teamid']=$model->id;
?>
<style>
.grid-view td {
    white-space: normal;
}
</style>
<div class="user-index">
	<div class="row">
		<div class="col-lg-6">
			<h1>
				<?= Html::encode($this->title).' - '. Html::encode($model->name)?>  
				<span class="pull-right">
					<a href="index" class='btn btn-warning'><span class="glyphicon glyphicon-step-backward"></span><?=Yii::t('app', 'Return')?></a>
					<a href='<?=URL::toRoute('doc/doc')?>?page=team-players&returnName=<?=$this->title?>&returnUrl=<?=URL::toRoute('team/players?id='.$model->id)?>' class='btn btn-primary'><span class="glyphicon glyphicon-question-sign"></span></a>			                 
				</span>  				
			</h1>
			<a href="mailto:<?=implode(';',ArrayHelper::getColumn($dataMembersProvider->query->all(), 'email', false))?>"><?=Yii::t('app', 'Send mail to all team members')?></a>

			<?= GridView::widget([
				'dataProvider' => $dataMembersProvider,
				'filterModel' => $searchMembersModel,
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
					'email:email',
					[
						'attribute' => 'admin',
						'format' => 'raw',
						'value' => function ($model, $index, $widget) {
							//fix for a bug in my TeamMemberSearch
							$byTeam = ArrayHelper::index($model->teamUser, 'team_id');
							return Html::checkbox('admin[]', $byTeam[$GLOBALS['teamid']]->admin, ['value' => $index, 'onChange' => 'window.location = window.location.protocol + \'//\'+window.location.hostname + window.location.pathname+\'admin?id='.$GLOBALS['teamid'].'&userid='.$model->id.'&value='.$byTeam[$GLOBALS['teamid']]->admin.';\'','disabled' => !Yii::$app->user->can('TeamManager')]);
						},
					],
					// buttons
					['class' => 'yii\grid\ActionColumn',
					'header' => Yii::t('app', 'Menu'),
					'template' => '{user/tasks}  {user-blocked/index} {removefromteam} ',
						'buttons' => [
						   'removefromteam' => function ($url, $model, $key) {
								return Html::a('', $url. '&teamid='.$GLOBALS['teamid'], ['title'=>Yii::t('app', 'Delete'), 'class'=>'glyphicon glyphicon-trash menubutton', 'style'=>Yii::$app->user->can('TeamManager')?'display:inline;':'display:none;' ]);
							},
							'user/tasks' => function ($url, $model, $key) {
								return Html::a('', $url, ['title'=>'Tasks', 'class'=>'glyphicon glyphicon-tasks menubutton']);
							},
							'user-blocked/index' => function ($url, $model, $key) {
								return Html::a('', $url, ['title'=>'Unavailability', 'class'=>'glyphicon glyphicon-ban-circle menubutton']);
							},
						]

					], // ActionColumn

				], // columns

			]); ?>
		</div>	
		<?php if(Yii::$app->user->can('TeamManager')){ ?> 
		<div class="col-lg-6">	
			<h1>
				<?= Html::encode( Yii::t('app', 'Add members to the team')) ?> 
			</h1>	
			
			
			<?= GridView::widget([
				'dataProvider' => $dataUsersProvider,
				'filterModel' => $searchUsersModel,
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
					'email:email',
					// buttons
					['class' => 'yii\grid\ActionColumn',
					'header' => Yii::t('app', 'Menu'),
					'template' => '{addtoteam}',
						'buttons' => [
							'addtoteam' => function ($url, $model, $key) {
								global $teamid;
								return Html::a('', $url. '&teamid='.$GLOBALS['teamid'], ['title'=>Yii::t('app', 'Add member to the team'), 'class'=>'glyphicon glyphicon-plus menubutton']);
							}
						]

					], // ActionColumn

				], // columns

			]); ?>
		</div>
		<?php } ?>
	</div>

</div>