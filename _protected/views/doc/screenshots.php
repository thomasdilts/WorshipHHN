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
			<a href="<?=URL::toRoute('doc/doc').'?page=home&returnName=home&returnUrl=%2Fsite%2Fhome'?>&lang=<?=$model->language_iso_name?>" class='btn btn-warning'><span class="glyphicon glyphicon-step-backward"></span><?=Yii::t('app', 'Return')?></a>
        </span>         
    </h1>
	<div class="row">
		<div class="col-lg-10">
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th><?= Html::encode(Yii::t('doc', 'Area'))?> </th>
						<th><?= Html::encode(Yii::t('doc', 'Screen'))?></th>
						<th><?= Html::encode(Yii::t('doc', 'Full screen'))?> </th>
						<th><?= Html::encode(Yii::t('doc', 'Smartphone'))?> </th>
					</tr>
				</thead> 
				<tbody>
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Events'))?> </td>
						<td>
							<a style="display:block;" href="<?=URL::toRoute('doc/doc')?>?page=event-index&returnName=<?=Yii::t('doc', "Event")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('site/screenshots')?>&lang=<?=$model->language_iso_name?>">
								<?= Html::encode(Yii::t('doc', "Event")) ?></a>
						</td>	
						<td>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/full/event-index.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/full/event-index.png" class="thumbnaildocimage" /></a></div>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/full/event-index-context-doc.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/full/event-index-context-doc.png" class="thumbnaildocimage" /></a></div>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/full/event-index-filter.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/full/event-index-filter.png" class="thumbnaildocimage" /></a></div>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/full/event-update.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/full/event-update.png" class="thumbnaildocimage" /></a></div>
						</td>	
						<td>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/phone/event-index.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/phone/event-index.png" class="thumbnaildocimage" /></a></div>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/phone/event-index-context-doc.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/phone/event-index-context-doc.png" class="thumbnaildocimage" /></a></div>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/phone/event-index-filter.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/phone/event-index-filter.png" class="thumbnaildocimage" /></a></div>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/phone/event-update.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/phone/event-update.png" class="thumbnaildocimage" /></a></div>
						</td>						
					</tr>			
					<tr>
						<td></td>
						<td>
							<a style="display:block;" href="<?=URL::toRoute('doc/doc')?>?page=event-activities&returnName=<?=Yii::t('doc', "Tasks")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('site/screenshots')?>&lang=<?=$model->language_iso_name?>">
								<?= Html::encode(Yii::t('doc', "Tasks")) ?></a>
						</td>	
						<td>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/full/event-tasks.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/full/event-tasks.png" class="thumbnaildocimage" /></a></div>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/full/event-editactivity.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/full/event-editactivity.png" class="thumbnaildocimage" /></a></div>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/full/event-editactivity-user.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/full/event-editactivity-user.png" class="thumbnaildocimage" /></a></div>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/full/event-tasks-pdf-export.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/full/event-tasks-pdf-export.png" class="thumbnaildocimage" /></a></div>
						</td>	
						<td>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/phone/event-tasks.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/phone/event-tasks.png" class="thumbnaildocimage" /></a></div>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/phone/event-editactivity.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/phone/event-editactivity.png" class="thumbnaildocimage" /></a></div>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/phone/event-editactivity-user.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/phone/event-editactivity-user.png" class="thumbnaildocimage" /></a></div>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/phone/event-tasks-pdf-export.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/phone/event-tasks-pdf-export.png" class="thumbnaildocimage" /></a></div>
						</td>	
					</tr>
					<tr>
				
						<td></td>
						<td>
							<a style="display:block;" href="<?=URL::toRoute('doc/doc')?>?page=event-notifications&returnName=<?=Yii::t('doc', "Notifications")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('site/screenshots')?>&lang=<?=$model->language_iso_name?>">
								<?= Html::encode(Yii::t('doc', "Notifications")) ?></a>
						</td>	
						<td>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/full/event-notify.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/full/event-notify.png" class="thumbnaildocimage" /></a></div>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/full/event-notification.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/full/event-notification.png" class="thumbnaildocimage" /></a></div>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/full/email-notification.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/full/email-notification.png" class="thumbnaildocimage" /></a></div>
						</td>	
						<td>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/phone/event-notify.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/phone/event-notify.png" class="thumbnaildocimage" /></a></div>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/phone/event-notification.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/phone/event-notification.png" class="thumbnaildocimage" /></a></div>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/phone/email-notification.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/phone/email-notification.png" class="thumbnaildocimage" /></a></div>
						</td>	
					</tr>
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Teams'))?> </td>
						<td>
							<a style="display:block;" href="<?=URL::toRoute('doc/doc')?>?page=team-index&returnName=<?=Yii::t('doc', "Team")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('site/screenshots')?>&lang=<?=$model->language_iso_name?>">
								<?= Html::encode(Yii::t('doc', "Team")) ?></a>
						</td>	
						<td>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/full/team-index.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/full/team-index.png" class="thumbnaildocimage" /></a></div>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/full/team-update.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/full/team-update.png" class="thumbnaildocimage" /></a></div>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/full/team-create-select-type.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/full/team-create-select-type.png" class="thumbnaildocimage" /></a></div>
						</td>	
						<td>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/phone/team-index.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/phone/team-index.png" class="thumbnaildocimage" /></a></div>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/phone/team-update.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/phone/team-update.png" class="thumbnaildocimage" /></a></div>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/phone/team-create-select-type.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/phone/team-create-select-type.png" class="thumbnaildocimage" /></a></div>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/phone/team-index-vertical.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/phone/team-index-vertical.png" class="thumbnaildocimage" /></a></div>
						</td>	
					</tr>
					<tr>
						<td></td>
						<td>
							<a style="display:block;" href="<?=URL::toRoute('doc/doc')?>?page=team-activities&returnName=<?=Yii::t('doc', "Tasks")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('site/screenshots')?>&lang=<?=$model->language_iso_name?>">
								<?= Html::encode(Yii::t('doc', "Tasks")) ?></a>
						</td>	
						<td>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/full/team-tasks.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/full/team-tasks.png" class="thumbnaildocimage" /></a></div>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/full/team-tasks-filter.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/full/team-tasks-filter.png" class="thumbnaildocimage" /></a></div>
						</td>	
						<td>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/phone/team-tasks.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/phone/team-tasks.png" class="thumbnaildocimage" /></a></div>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/phone/team-tasks-filter.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/phone/team-tasks-filter.png" class="thumbnaildocimage" /></a></div>
						</td>	
					</tr>
					<tr>
						<td></td>
						<td>
							<a style="display:block;" href="<?=URL::toRoute('doc/doc')?>?page=team-unavailability&returnName=<?=Yii::t('doc', "Unavailability")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('site/screenshots')?>&lang=<?=$model->language_iso_name?>">
								<?= Html::encode(Yii::t('doc', "Unavailability")) ?></a>
						</td>	
						<td>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/full/team-unavailability.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/full/team-unavailability.png" class="thumbnaildocimage" /></a></div>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/full/team-unavailability-create.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/full/team-unavailability-create.png" class="thumbnaildocimage" /></a></div>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/full/team-unavailability-create-calendar.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/full/team-unavailability-create-calendar.png" class="thumbnaildocimage" /></a></div>
						</td>	
						<td>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/phone/team-unavailability.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/phone/team-unavailability.png" class="thumbnaildocimage" /></a></div>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/phone/team-unavailability-create.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/phone/team-unavailability-create.png" class="thumbnaildocimage" /></a></div>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/phone/team-unavailability-create-calendar.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/phone/team-unavailability-create-calendar.png" class="thumbnaildocimage" /></a></div>
						</td>	
					</tr>
					<tr>
						<td></td>
						<td>
							<a style="display:block;" href="<?=URL::toRoute('doc/doc')?>?page=team-players&returnName=<?=Yii::t('doc', "Team members")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('site/screenshots')?>&lang=<?=$model->language_iso_name?>">
								<?= Html::encode(Yii::t('doc', "Team members")) ?></a>
						</td>	
						<td>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/full/team-members.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/full/team-members.png" class="thumbnaildocimage" /></a></div>
						</td>	
						<td>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/phone/team-members.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/phone/team-members.png" class="thumbnaildocimage" /></a></div>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/phone/team-members-wide.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/phone/team-members-wide.png" class="thumbnaildocimage" /></a></div>
						</td>	
					</tr>
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'User'))?></td>
						<td>
							<a style="display:block;" href="<?=URL::toRoute('doc/doc')?>?page=user-profile&returnName=<?=Yii::t('doc', "Profile")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('site/screenshots')?>&lang=<?=$model->language_iso_name?>">
								<?= Html::encode(Yii::t('doc', "Profile")) ?></a>
						</td>	
						<td>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/full/user-view.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/full/user-view.png" class="thumbnaildocimage" /></a></div>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/full/user-update.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/full/user-update.png" class="thumbnaildocimage" /></a></div>
						</td>	
						<td>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/phone/user-view.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/phone/user-view.png" class="thumbnaildocimage" /></a></div>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/phone/user-update.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/phone/user-update.png" class="thumbnaildocimage" /></a></div>
						</td>	
					</tr>
					<tr>
						<td></td>
						<td>
							<a style="display:block;" href="<?=URL::toRoute('doc/doc')?>?page=user-activities&returnName=<?=Yii::t('doc', "Tasks")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('site/screenshots')?>&lang=<?=$model->language_iso_name?>">
								<?= Html::encode(Yii::t('doc', "Tasks")) ?></a>
						</td>	
						<td>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/full/user-tasks.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/full/user-tasks.png" class="thumbnaildocimage" /></a></div>
						</td>	
						<td>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/phone/user-tasks.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/phone/user-tasks.png" class="thumbnaildocimage" /></a></div>
						</td>	
					</tr>
					<tr>
						<td></td>
						<td>
							<a style="display:block;" href="<?=URL::toRoute('doc/doc')?>?page=user-blocked-index&returnName=<?=Yii::t('doc', "Unavailability")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('site/screenshots')?>&lang=<?=$model->language_iso_name?>">
								<?= Html::encode(Yii::t('doc', "Unavailability")) ?></a>
						</td>	
						<td>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/full/user-unavailability.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/full/user-unavailability.png" class="thumbnaildocimage" /></a></div>
						</td>	
						<td>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/phone/user-unavailability.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/phone/user-unavailability.png" class="thumbnaildocimage" /></a></div>
						</td>	
					</tr>
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Setup'))?></td>
						<td>
							<a style="display:block;" href="<?=URL::toRoute('doc/doc')?>?page=church-index&returnName=<?=Yii::t('doc', "Church")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('site/screenshots')?>&lang=<?=$model->language_iso_name?>">
								<?= Html::encode(Yii::t('doc', "Church")) ?></a>
						</td>	
						<td>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/full/church-index.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/full/church-index.png" class="thumbnaildocimage" /></a></div>
						</td>	
						<td>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/phone/church-index.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/phone/church-index.png" class="thumbnaildocimage" /></a></div>
						</td>	
					</tr>
					<tr>
						<td></td>
						<td>
							<a style="display:block;" href="<?=URL::toRoute('doc/doc')?>?page=language-index&returnName=<?=Yii::t('doc', "Language")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('site/screenshots')?>&lang=<?=$model->language_iso_name?>">
								<?= Html::encode(Yii::t('doc', "Language")) ?></a>
						</td>	
						<td>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/full/language-index.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/full/language-index.png" class="thumbnaildocimage" /></a></div>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/full/language-create.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/full/language-create.png" class="thumbnaildocimage" /></a></div>
						</td>	
						<td>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/phone/language-index.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/phone/language-index.png" class="thumbnaildocimage" /></a></div>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/phone/language-create.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/phone/language-create.png" class="thumbnaildocimage" /></a></div>
						</td>	
					</tr>
					<tr>
						<td></td>
						<td>
							<a style="display:block;" href="<?=URL::toRoute('doc/doc')?>?page=song-index&returnName=<?=Yii::t('doc', "Song")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('site/screenshots')?>&lang=<?=$model->language_iso_name?>">
								<?= Html::encode(Yii::t('doc', "Song")) ?></a>
						</td>	
						<td>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/full/song-index.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/full/song-index.png" class="thumbnaildocimage" /></a></div>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/full/song-create.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/full/song-create.png" class="thumbnaildocimage" /></a></div>
						</td>	
						<td>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/phone/song-index.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/phone/song-index.png" class="thumbnaildocimage" /></a></div>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/phone/song-create.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/phone/song-create.png" class="thumbnaildocimage" /></a></div>
						</td>	
					</tr>
					<tr>
						<td></td>
						<td>
							<a style="display:block;" href="<?=URL::toRoute('doc/doc')?>?page=user-index&returnName=<?=Yii::t('doc', "Users")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('site/screenshots')?>&lang=<?=$model->language_iso_name?>">
								<?= Html::encode(Yii::t('doc', "Users")) ?></a>
						</td>	
						<td>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/full/user-index.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/full/user-index.png" class="thumbnaildocimage" /></a></div>
						</td>	
						<td>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/phone/user-index.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/phone/user-index.png" class="thumbnaildocimage" /></a></div>
						</td>	
					</tr>
					<tr>
						<td></td>
						<td>
							<a style="display:block;" href="<?=URL::toRoute('doc/doc')?>?page=activity-type-index&returnName=<?=Yii::t('doc', "Task templates")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('site/screenshots')?>&lang=<?=$model->language_iso_name?>">
								<?= Html::encode(Yii::t('doc', "Task templates")) ?></a>
						</td>	
						<td>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/full/task-template-index.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/full/task-template-index.png" class="thumbnaildocimage" /></a></div>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/full/task-template-create.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/full/task-template-create.png" class="thumbnaildocimage" /></a></div>
						</td>	
						<td>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/phone/task-template-index.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/phone/task-template-index.png" class="thumbnaildocimage" /></a></div>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/phone/task-template-create.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/phone/task-template-create.png" class="thumbnaildocimage" /></a></div>
						</td>	
					</tr>
					<tr>
						<td></td>
						<td>
							<a style="display:block;" href="<?=URL::toRoute('doc/doc')?>?page=team-type-index&returnName=<?=Yii::t('doc', "Team Type")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('site/screenshots')?>&lang=<?=$model->language_iso_name?>">
								<?= Html::encode(Yii::t('doc', "Team Type")) ?></a>
						</td>	
						<td>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/full/team-types.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/full/team-types.png" class="thumbnaildocimage" /></a></div>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/full/team-type-create.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/full/team-type-create.png" class="thumbnaildocimage" /></a></div>
						</td>	
						<td>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/phone/team-types.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/phone/team-types.png" class="thumbnaildocimage" /></a></div>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/phone/team-type-create.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/phone/team-type-create.png" class="thumbnaildocimage" /></a></div>
						</td>	
					</tr>
					<tr>
						<td></td>
						<td>
							<a style="display:block;" href="<?=URL::toRoute('doc/doc')?>?page=message-template-index&returnName=<?=Yii::t('doc', "Message Template")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('site/screenshots')?>&lang=<?=$model->language_iso_name?>">
								<?= Html::encode(Yii::t('doc', "Message Template")) ?></a>
						</td>	
						<td>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/full/message-template-index.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/full/message-template-index.png" class="thumbnaildocimage" /></a></div>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/full/message-template-create.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/full/message-template-create.png" class="thumbnaildocimage" /></a></div>
						</td>	
						<td>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/phone/message-template-index.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/phone/message-template-index.png" class="thumbnaildocimage" /></a></div>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/phone/message-template-create.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/phone/message-template-create.png" class="thumbnaildocimage" /></a></div>
						</td>	
					</tr>
					<tr>
						<td></td>
						<td>
							<a style="display:block;" href="<?=URL::toRoute('doc/doc')?>?page=message-type-index&returnName=<?=Yii::t('doc', "Message Type")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('site/screenshots')?>&lang=<?=$model->language_iso_name?>">
								<?= Html::encode(Yii::t('doc', "Message Type")) ?></a>
						</td>	
						<td>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/full/message-types.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/full/message-types.png" class="thumbnaildocimage" /></a></div>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/full/message-type-create.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/full/message-type-create.png" class="thumbnaildocimage" /></a></div>
						</td>	
						<td>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/phone/message-types.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/phone/message-types.png" class="thumbnaildocimage" /></a></div>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/phone/message-type-create.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/phone/message-type-create.png" class="thumbnaildocimage" /></a></div>
						</td>	
					</tr>
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Other'))?></td>
						<td>
							<?= Html::encode(Yii::t('doc', 'Home'))?>
						</td>	
						<td>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/full/home.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/full/home.png" class="thumbnaildocimage" /></a></div>
						</td>	
						<td>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/phone/home.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/phone/home.png" class="thumbnaildocimage" /></a></div>
						</td>	
					</tr>
					<tr>
						<td></td>
						<td>
							<?= Html::encode(Yii::t('doc', 'File Sharing'))?>
						</td>	
						<td>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/full/file-sharing.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/full/file-sharing.png" class="thumbnaildocimage" /></a></div>
						</td>	
						<td>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/phone/file-sharing.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/phone/file-sharing.png" class="thumbnaildocimage" /></a></div>
						</td>	
					</tr>
					<tr>
						<td></td>
						<td>
							<?= Html::encode(Yii::t('doc', 'Login'))?>
						</td>	
						<td>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/full/login.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/full/login.png" class="thumbnaildocimage" /></a></div>
						</td>	
						<td>
							<div class="thumbnaildocimage" ><a href="<?=URL::toRoute('doc/screenshot')?>?image=/images/phone/login.png&returnName=<?=Yii::t('doc', "Screenshot")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dscreenshots%26returnName%3D<?=Yii::t('doc', "Screenshots")?>%26returnUrl%3D<?=URL::toRoute('doc/doc')?>&lang=<?=$model->language_iso_name?>"><img src="<?=Yii::$app->request->baseUrl?>/images/phone/login.png" class="thumbnaildocimage" /></a></div>
						</td>	
					</tr>

				</tbody>
			</table>
		</div>
	</div>
</div> 