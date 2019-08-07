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
			<p><?= Html::encode(Yii::t('doc', "This is the main screen where everything happens. This one screen is the goal of the entire program. Here you see all the tasks which must be done to ensure a successful event.")) ?></p>
			<p><?= Html::encode(Yii::t('doc', "Many prefer to have this list on paper so here you can also print out the list in PDF format or EXCEL format.")) ?></p>
			<p><?= Html::encode(Yii::t('doc', "If you have the permissions to edit this list then here is also where all the work is done. You can edit each task as well delete tasks or add new tasks. If you feel there is no task template that defines your task then you can speak to the administrator of this program so that they can create a new task template for you.")) ?></p>
		</div>
	</div>
</div>