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
			<p><?= Html::encode(Yii::t('doc', "This screen shows you all the tasks you are scheduled to do in the near future.")) ?></p>			
			<p><?= Html::encode(Yii::t('doc', "The most important challange here is finding your task. There is a filter to aid in finding the task but this filter is shown as a button. Click on the icon to the right of the filter button and then the filter will open up and you can specify exactly what dates you are interested in seeing. If you hit the button 'clean' then you will empty the data fields. Then when you hit filter you will get all the defined tasks. By default you will see only tasks from today and 3 months forward in time.")) ?></p>
			<p><?= Html::encode(Yii::t('doc', "Under the 'menu' column you can see up two icons depending on what your permission level is. They are for accepting or rejecting the task. In some installations this might be your primary way of accepting or rejecting tasks. Or it might be done in emails instead. Consult your system administrator to find out how it will be done.")) ?></p>
			<p><?= Html::encode(Yii::t('doc', "Many prefer to have this list on paper so here you can also print out the list in PDF format or EXCEL format. Also there is an ICS format which is the standard format to import into your personal calendar. Simply export in this ICS format from here and click on the file you downloaded. That will usually automatically import all these tasks into your personal calendar.")) ?></p>

		</div>
	</div>
</div> 