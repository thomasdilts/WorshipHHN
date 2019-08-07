<?php
use yii\helpers\Html;
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
			<h3><?= Html::encode(Yii::t('doc', "List of features")) ?></h3>
			<ul>
				<li><?= Html::encode(Yii::t('doc', "Can be used on any size screen, from full size to smartphone")) ?></li>
				<li><?= Html::encode(Yii::t('doc', "Contextual help at every turn. Fully documented with quick and easy access to the relative documentation")) ?></li>
				<li><?= Html::encode(Yii::t('doc', "Available in over ten languages and new languages will be available when requested")) ?></li>
				<li><?= Html::encode(Yii::t('doc', "Tasks are easy to define with a multitude of possibilities")) ?></li>
				<ul>
					<li><?= Html::encode(Yii::t('doc', "Team association. People can be organized into teams when desired.")) ?></li>
					<li><?= Html::encode(Yii::t('doc', "Person association")) ?></li>
					<li><?= Html::encode(Yii::t('doc', "Description")) ?></li>
					<li><?= Html::encode(Yii::t('doc', "Song attachement")) ?></li>
					<li><?= Html::encode(Yii::t('doc', "File attachement")) ?></li>
					<li><?= Html::encode(Yii::t('doc', "Bible verses")) ?></li>
					<li><?= Html::encode(Yii::t('doc', "Special needs")) ?></li>
					<li><?= Html::encode(Yii::t('doc', "All of the above can be defined to give an alert if information in the task is missing.")) ?></li>
				</ul>
				<li><?= Html::encode(Yii::t('doc', "Automatic email notification system.")) ?></li>
				<ul>
					<li><?= Html::encode(Yii::t('doc', "Emails sent from the notification system can contain yes/no buttons and if the user presses one of the buttons then the task status is updated to show the users response")) ?></li>
					<li><?= Html::encode(Yii::t('doc', "The event orgainizer will recieve an email notification anytime a task is rejected by a user.")) ?></li>
					<li><?= Html::encode(Yii::t('doc', "Tasks may also be accepted or rejected by the user inside of the program instead of by email.")) ?></li>
				</ul>
				<li><?= Html::encode(Yii::t('doc', "Both the team and the user each have their own task list which summarizes all the events they are involved in.")) ?></li>
				<ul>
					<li><?= Html::encode(Yii::t('doc', "The task lists can be directly transfered over to your own personal calendar.")) ?></li>
					<li><?= Html::encode(Yii::t('doc', "The task lists can also be exported to PDF or EXCEL format.")) ?></li>
				</ul>
				<li><?= Html::encode(Yii::t('doc', "The event task list is easy to read and exportable in PDF or EXCEL format.")) ?></li>
				<li><?= Html::encode(Yii::t('doc', "User images can be shown where ever a users name appears.")) ?></li>
				<li><?= Html::encode(Yii::t('doc', "Easy file sharing on many different levels.")) ?></li>
				<li><?= Html::encode(Yii::t('doc', "Song database with CSV and OpenLP import and CSV export.")) ?></li>
				<li><?= Html::encode(Yii::t('doc', "Several churches can share the same installation yet they will see nothing of each others information")) ?></li>
			</ul> 
		</div>
	</div>
</div> 