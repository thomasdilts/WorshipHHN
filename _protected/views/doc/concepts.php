<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\DocForm;

$this->title = Yii::t('doc', 'Documentation') . " : " . $returnName;
$this->params['breadcrumbs'][] = ['label' => $returnName, 'url' => $returnUrl];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
	<span class="pull-right" style="">		
		<?php if(Yii::$app->user->isGuest){ ?>
			<?php $form = ActiveForm::begin(['id' => 'form-home']); ?>
				<?= $form->field($model, 'language_iso_name')->dropDownList(DocForm::getLanguages(),['onChange'=>'this.form.submit();']) ?>
			<?php ActiveForm::end(); ?>
		<?php } ?>		
	</span>	 
    <h1 style="display:inline-block;">
        <?= Html::encode($this->title) ?>
        <span class="pull-right" style="margin-left:20px;">
			<a href="<?=$returnUrl?>&lang=<?=$model->language_iso_name?>" class='btn btn-warning'><span class="glyphicon glyphicon-step-backward"></span><?=Yii::t('app', 'Return')?></a>
        </span>         
    </h1>
	<div class="row">
		<div class="col-lg-10">
			<h3><?= Html::encode(Yii::t('doc', "Roles")) ?></h3>
			<p><?= Html::encode(Yii::t('doc', "The following is the list of roles and their meaning. This is a heirarchical list where each time you go up a level you inherit all the permissions of the lower levels. This list is shown from the lowest to the highest level")) ?></p>
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th><?= Html::encode(Yii::t('doc', 'Role name'))?> </th>
						<th><?= Html::encode(Yii::t('doc', 'Permissions'))?></th>
					</tr>
				</thead> 
				<tbody>
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Member Unaccepted'))?> </td>
						<td><?= Html::encode(Yii::t('doc', 'This is a person who has verified his email but not yet been given any permissions at all. This role has no permissions'))?> </td>
					</tr>
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Member'))?> </td>
						<td>
							<ul>
								<li><?= Html::encode(Yii::t('doc', "See and edit their own profile.")) ?></li>
								<li><?= Html::encode(Yii::t('doc', "See own task list and reject/accept tasks.")) ?></li>
								<li><?= Html::encode(Yii::t('doc', "See the events.")) ?></li>
								<li><?= Html::encode(Yii::t('doc', "See teams and team task lists that they are associated with.")) ?></li>
								<li><?= Html::encode(Yii::t('doc', "Share files at all levels.")) ?></li>
							</ul>						
						</td>
					</tr>
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Event Editor'))?> </td>
						<td><?= Html::encode(Yii::t('doc', 'May edit tasks and add tasks to an event.'))?> </td>
					</tr> 
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Team Manager'))?> </td>
						<td>
							<ul>
								<li><?= Html::encode(Yii::t('doc', "May see all teams.")) ?></li>
								<li><?= Html::encode(Yii::t('doc', "May add/remove members to teams.")) ?></li>
								<li><?= Html::encode(Yii::t('doc', "May reject/accept task assignments to teams.")) ?></li>
							</ul>							
						</td>
					</tr> 
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Event Manager'))?> </td>
						<td>
							<ul>
								<li><?= Html::encode(Yii::t('doc', "May create and fully edit events")) ?></li>
								<li><?= Html::encode(Yii::t('doc', "May send notifications about an event.")) ?></li>
								<li><?= Html::encode(Yii::t('doc', "May delete notifications.")) ?></li>
							</ul>							
						</td>
					</tr> 
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Church Admin'))?> </td>
						<td>
							<ul>
								<li><?= Html::encode(Yii::t('doc', "May see all other users profiles and task lists.")) ?></li>
								<li><?= Html::encode(Yii::t('doc', "May create and fully edit users.")) ?></li>
								<li><?= Html::encode(Yii::t('doc', "May create/edit teams and team types.")) ?></li>
								<li><?= Html::encode(Yii::t('doc', "May create/edit task templates.")) ?></li>
								<li><?= Html::encode(Yii::t('doc', "May create/edit message templates.")) ?></li>
								<li><?= Html::encode(Yii::t('doc', "May create/edit message types.")) ?></li>
								<li><?= Html::encode(Yii::t('doc', "May create/edit languages.")) ?></li>
							</ul>			
						</td>							
					</tr> 
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'the Creator'))?> </td>
						<td><?= Html::encode(Yii::t('doc', 'May create new churches'))?> </td>
					</tr> 
				</tbody>
			</table>
		</div>
	</div>
</div> 