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
			<p><?= Html::encode(Yii::t('doc', "Here you can edit all the important information about the user or yourself. This of course depends on what your permissions are.")) ?></p>
			<p><?= Html::encode(Yii::t('doc', "")) ?></p>
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th><?= Html::encode(Yii::t('doc', 'Data field name'))?> </th>
						<th><?= Html::encode(Yii::t('doc', 'Description'))?></th>
						<th><?= Html::encode(Yii::t('doc', 'Examples'))?> </th>
					</tr>
				</thead> 
				<tbody>
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Username'))?> </td>
						<td><?= Html::encode(Yii::t('doc', 'It is up to you to put in here what you want. This is what the user must enter each time they log in. It can be simple like a first name or an alias or nickname or if you want to make it formal put the email here.'))?></td>	 
						<td>john, joe, henry, iceman, john.smith@gmail.com</td>	
					</tr>
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Display name'))?> </td>
						<td><?= Html::encode(Yii::t('doc', 'Again, it is up to you what you want to put here. I prefer the users first name and last name. This will show up everywhere the user is refered to in the program.'))?></td>	
						<td>John Doe</td>	 
					</tr>
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Email'))?> </td>
						<td><?= Html::encode(Yii::t('doc', 'The valid email for the user. It is possible to put here a fake email in the case that your user will probably never log into the system and you don\'t need to have any communications with them.'))?></td>
						<td></td>		
					</tr>
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Password'))?> </td>
						<td><?= Html::encode(Yii::t('doc', 'A standard password input. you will be challenged to put in a reasonably difficult password.'))?></td>	
						<td></td>	
					</tr> 
					<tr> 
						<td><?= Html::encode(Yii::t('doc', 'Status'))?> </td>
						<td><?= Html::encode(Yii::t('doc', 'Hopefully always active. There is the possibility for inactive or deleted. If a user is inactive or deleted they can no long log in.'))?></td>	
						<td></td>	
					</tr> 
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Role'))?> </td>
						<td><?= Html::encode(Yii::t('doc', 'The definition of the role you can find in the concepts documentation. It is to large to put here.'))?>
						
						<a style="display:block;" href="<?=URL::toRoute('doc/doc')?>?page=concepts&returnName=<?=Yii::t('doc', "Concepts")?>&returnUrl=<?=URL::toRoute('doc/doc')?>%3Fpage%3Dhome%26returnName%3D<?=Yii::t('doc', "Home")?>%26returnUrl%3D<?=URL::toRoute('site/home')?>">
					<?= Html::encode(Yii::t('doc', "Concepts")) ?></a>
						
						</td>	
						<td></td>	
					</tr> 
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Hide user icons'))?> </td>
						<td><?= Html::encode(Yii::t('doc', 'If you check this then the user will no longer see all the images of other users or themselves. This is here because it is very personal whether you think the images add to the program or detract from it.'))?></td>	
						<td></td>
					</tr> 
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Language'))?> </td>
						<td><?= Html::encode(Yii::t('doc', 'The language you wish to view in all the menus and screens'))?></td>	
						<td></td>	
					</tr> 
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Photo of yourself'))?> </td>
						<td><?= Html::encode(Yii::t('doc', 'Here you may add a photo of yourself. Please put in a square photo because it will look the best.'))?></td>	
						<td></td>	 
					</tr> 
				</tbody>
			</table>			
		</div>
	</div>
</div> 