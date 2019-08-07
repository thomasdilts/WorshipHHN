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
			<p><?= Html::encode(Yii::t('doc', "Here you see and define unavailability dates. This tells everyone that you cannot be assigned to a task during these date intervals. The date intervals must be logical. They cannot cross into each other or you will get an error message. Also the stop date must be greater than or equal to the start date.")) ?></p>
			<p><?= Html::encode(Yii::t('doc', "A challange here is finding your unavailability date. There is a filter to aid in finding the unavailability date but this filter is shown as a button. Click on the icon to the right of the filter button and then the filter will open up and you can specify exactly what dates you are interested in seeing. If you hit the button 'clean' then you will empty the data fields. Then when you hit filter you will get all the defined unavailability dates. By default you will see only unavailability dates from today and 8 months forward in time.")) ?></p>
			<p><?= Html::encode(Yii::t('doc', "It is ok to delete unavailability dates that are in the past if you wish.")) ?></p>
		</div>
	</div>
</div> 