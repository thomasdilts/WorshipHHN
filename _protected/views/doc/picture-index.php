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
			<p><?= Html::encode(Yii::t('doc', 'This is a picture archive for your church. These pictures are mainly for use in activity types that have defined "using pictures." Then when you define the activity you can attach as many of these pictures to the activity as you want.')) ?></p>
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
						<td><?= Html::encode(Yii::t('doc', 'Name'))?> </td>
						<td><?= Html::encode(Yii::t('doc', 'A name that best describes the picture'))?></td>	
						<td>Come to our alpha course, ...</td>	
					</tr>
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Description'))?> </td>
						<td><?= Html::encode(Yii::t('doc', 'More detailed description of the picture. It may be left out'))?></td>	
						<td>You will learn all the basics about christianity</td>	
					</tr> 
					<tr>
						<td><?= Html::encode(Yii::t('app', 'Picture'))?> </td>
						<td><?= Html::encode(Yii::t('doc', 'The actual picture file'))?></td>	
						<td></td>	
					</tr> 
				</tbody>
			</table>
		</div>
	</div>
</div>