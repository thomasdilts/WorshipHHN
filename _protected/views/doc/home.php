<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\DocForm;

if($returnUrl=='/site/home'){
	$returnUrl=URL::toRoute('site/home') .'?page=home';
}

$this->title = Yii::t('doc', 'Documentation') . " : " . $returnName;
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
			<h3><?= Html::encode(Yii::t('doc', "Hello and a warm welcome to WorshipHHN")) ?></h3>
			<p><?= Html::encode(Yii::t('doc', "We think this program is a simple and powerful tool you can use to plan events for your church. We use it to plan all our church services.")) ?></p>
			<h3><?= Html::encode(Yii::t('doc', "Table of contents")) ?></h3>
			<div style="margin-left:20px;">
				<a style="display:block;" href="<?=URL::toRoute('doc/doc')?>?page=features&returnName=<?=Yii::t('doc', "Features")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dhome%26returnName%3D<?=Yii::t('doc', "Home")?>%26returnUrl%3D<?=URL::toRoute('site/home')?>%3Fpage%3Dhome&lang=<?=$model->language_iso_name?>">
					<?= Html::encode(Yii::t('doc', "Features")) ?></a>
				<a style="display:block;" href="<?=URL::toRoute('doc/doc')?>?page=screenshots&returnName=<?=Yii::t('doc', "Screenshots")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dhome%26returnName%3D<?=Yii::t('doc', "Home")?>%26returnUrl%3D<?=URL::toRoute('site/home')?>%3Fpage%3Dhome&lang=<?=$model->language_iso_name?>">
					<?= Html::encode(Yii::t('doc', "Screenshots")) ?></a>
				<a style="display:block;" href="<?=URL::toRoute('doc/doc')?>?page=concepts&returnName=<?=Yii::t('doc', "Concepts")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dhome%26returnName%3D<?=Yii::t('doc', "Home")?>%26returnUrl%3D<?=URL::toRoute('site/home')?>%3Fpage%3Dhome&lang=<?=$model->language_iso_name?>">
					<?= Html::encode(Yii::t('doc', "Concepts")) ?></a>
				<a style="display:block;" href="<?=URL::toRoute('doc/doc')?>?page=installation&returnName=<?=Yii::t('doc', "Installation")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dhome%26returnName%3D<?=Yii::t('doc', "Home")?>%26returnUrl%3D<?=URL::toRoute('site/home')?>%3Fpage%3Dhome&lang=<?=$model->language_iso_name?>">
					<?= Html::encode(Yii::t('doc', "Installation")) ?></a>
				<h4><?= Html::encode(Yii::t('doc', "User guide")) ?></h4>
				<div style="margin-left:20px;">
					<h5><?= Html::encode(Yii::t('doc', "Events")) ?></h5>
					<div style="margin-left:20px;">
						<a style="display:block;" href="<?=URL::toRoute('doc/doc')?>?page=event-index&returnName=<?=Yii::t('doc', "Event")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dhome%26returnName%3D<?=Yii::t('doc', "Home")?>%26returnUrl%3D<?=URL::toRoute('site/home')?>%3Fpage%3Dhome&lang=<?=$model->language_iso_name?>">
							<?= Html::encode(Yii::t('doc', "Event")) ?></a>
						<a style="display:block;" href="<?=URL::toRoute('doc/doc')?>?page=event-activities&returnName=<?=Yii::t('doc', "Tasks")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dhome%26returnName%3D<?=Yii::t('doc', "Home")?>%26returnUrl%3D<?=URL::toRoute('site/home')?>%3Fpage%3Dhome&lang=<?=$model->language_iso_name?>">
							<?= Html::encode(Yii::t('doc', "Tasks")) ?></a>
						<a style="display:block;" href="<?=URL::toRoute('doc/doc')?>?page=event-notifications&returnName=<?=Yii::t('doc', "Notifications")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dhome%26returnName%3D<?=Yii::t('doc', "Home")?>%26returnUrl%3D<?=URL::toRoute('site/home')?>%3Fpage%3Dhome&lang=<?=$model->language_iso_name?>">
							<?= Html::encode(Yii::t('doc', "Notifications")) ?></a>
						<a style="display:block;" href="<?=URL::toRoute('doc/doc')?>?page=activity-type-index&returnName=<?=Yii::t('doc', "Task templates")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dhome%26returnName%3D<?=Yii::t('doc', "Home")?>%26returnUrl%3D<?=URL::toRoute('site/home')?>%3Fpage%3Dhome&lang=<?=$model->language_iso_name?>">
							<?= Html::encode(Yii::t('doc', "Task templates")) ?></a>
					</div>
					<h5><?= Html::encode(Yii::t('doc', "Teams")) ?></h5>
					<div style="margin-left:20px;">
						<a style="display:block;" href="<?=URL::toRoute('doc/doc')?>?page=team-index&returnName=<?=Yii::t('doc', "Team")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dhome%26returnName%3D<?=Yii::t('doc', "Home")?>%26returnUrl%3D<?=URL::toRoute('site/home')?>%3Fpage%3Dhome&lang=<?=$model->language_iso_name?>">
							<?= Html::encode(Yii::t('doc', "Team")) ?></a>
						<a style="display:block;" href="<?=URL::toRoute('doc/doc')?>?page=team-activities&returnName=<?=Yii::t('doc', "Tasks")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dhome%26returnName%3D<?=Yii::t('doc', "Home")?>%26returnUrl%3D<?=URL::toRoute('site/home')?>%3Fpage%3Dhome&lang=<?=$model->language_iso_name?>">
							<?= Html::encode(Yii::t('doc', "Tasks")) ?></a>
						<a style="display:block;" href="<?=URL::toRoute('doc/doc')?>?page=team-unavailability&returnName=<?=Yii::t('doc', "Unavailability")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dhome%26returnName%3D<?=Yii::t('doc', "Home")?>%26returnUrl%3D<?=URL::toRoute('site/home')?>%3Fpage%3Dhome&lang=<?=$model->language_iso_name?>">
							<?= Html::encode(Yii::t('doc', "Unavailability")) ?></a>
						<a style="display:block;" href="<?=URL::toRoute('doc/doc')?>?page=team-players&returnName=<?=Yii::t('doc', "Team members")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dhome%26returnName%3D<?=Yii::t('doc', "Home")?>%26returnUrl%3D<?=URL::toRoute('site/home')?>%3Fpage%3Dhome&lang=<?=$model->language_iso_name?>">
							<?= Html::encode(Yii::t('doc', "Team members")) ?></a>
						<a style="display:block;" href="<?=URL::toRoute('doc/doc')?>?page=team-type-index&returnName=<?=Yii::t('doc', "Team Type")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dhome%26returnName%3D<?=Yii::t('doc', "Home")?>%26returnUrl%3D<?=URL::toRoute('site/home')?>%3Fpage%3Dhome&lang=<?=$model->language_iso_name?>">
							<?= Html::encode(Yii::t('doc', "Team Type")) ?></a>
					</div>
					<h5><?= Html::encode(Yii::t('doc', "User")) ?></h5>
					<div style="margin-left:20px;">
						<a style="display:block;" href="<?=URL::toRoute('doc/doc')?>?page=user-profile&returnName=<?=Yii::t('doc', "Profile")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dhome%26returnName%3D<?=Yii::t('doc', "Home")?>%26returnUrl%3D<?=URL::toRoute('site/home')?>%3Fpage%3Dhome&lang=<?=$model->language_iso_name?>">
							<?= Html::encode(Yii::t('doc', "Profile")) ?></a>
						<a style="display:block;" href="<?=URL::toRoute('doc/doc')?>?page=user-activities&returnName=<?=Yii::t('doc', "Tasks")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dhome%26returnName%3D<?=Yii::t('doc', "Home")?>%26returnUrl%3D<?=URL::toRoute('site/home')?>%3Fpage%3Dhome&lang=<?=$model->language_iso_name?>">
							<?= Html::encode(Yii::t('doc', "Tasks")) ?></a>
						<a style="display:block;" href="<?=URL::toRoute('doc/doc')?>?page=user-blocked-index&returnName=<?=Yii::t('doc', "Unavailability")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dhome%26returnName%3D<?=Yii::t('doc', "Home")?>%26returnUrl%3D<?=URL::toRoute('site/home')?>%3Fpage%3Dhome&lang=<?=$model->language_iso_name?>">
							<?= Html::encode(Yii::t('doc', "Unavailability")) ?></a>
					</div>
					<h5><?= Html::encode(Yii::t('doc', "Setup")) ?></h5>
					<div style="margin-left:20px;">
						<a style="display:block;" href="<?=URL::toRoute('doc/doc')?>?page=church-index&returnName=<?=Yii::t('doc', "Church")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dhome%26returnName%3D<?=Yii::t('doc', "Home")?>%26returnUrl%3D<?=URL::toRoute('site/home')?>%3Fpage%3Dhome&lang=<?=$model->language_iso_name?>">
							<?= Html::encode(Yii::t('doc', "Church")) ?></a>
						<a style="display:block;" href="<?=URL::toRoute('doc/doc')?>?page=language-index&returnName=<?=Yii::t('doc', "Language")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dhome%26returnName%3D<?=Yii::t('doc', "Home")?>%26returnUrl%3D<?=URL::toRoute('site/home')?>%3Fpage%3Dhome&lang=<?=$model->language_iso_name?>">
							<?= Html::encode(Yii::t('doc', "Language")) ?></a>
						<a style="display:block;" href="<?=URL::toRoute('doc/doc')?>?page=song-index&returnName=<?=Yii::t('doc', "Song")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dhome%26returnName%3D<?=Yii::t('doc', "Home")?>%26returnUrl%3D<?=URL::toRoute('site/home')?>%3Fpage%3Dhome&lang=<?=$model->language_iso_name?>">
							<?= Html::encode(Yii::t('doc', "Song")) ?></a>
						<a style="display:block;" href="<?=URL::toRoute('doc/doc')?>?page=user-index&returnName=<?=Yii::t('doc', "Users")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dhome%26returnName%3D<?=Yii::t('doc', "Home")?>%26returnUrl%3D<?=URL::toRoute('site/home')?>%3Fpage%3Dhome&lang=<?=$model->language_iso_name?>">
							<?= Html::encode(Yii::t('doc', "Users")) ?></a>
						<a style="display:block;" href="<?=URL::toRoute('doc/doc')?>?page=message-template-index&returnName=<?=Yii::t('doc', "Message Template")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dhome%26returnName%3D<?=Yii::t('doc', "Home")?>%26returnUrl%3D<?=URL::toRoute('site/home')?>%3Fpage%3Dhome&lang=<?=$model->language_iso_name?>">
							<?= Html::encode(Yii::t('doc', "Message Template")) ?></a>
						<a style="display:block;" href="<?=URL::toRoute('doc/doc')?>?page=message-type-index&returnName=<?=Yii::t('doc', "Message Type")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dhome%26returnName%3D<?=Yii::t('doc', "Home")?>%26returnUrl%3D<?=URL::toRoute('site/home')?>%3Fpage%3Dhome&lang=<?=$model->language_iso_name?>">
							<?= Html::encode(Yii::t('doc', "Message Type")) ?></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div> 