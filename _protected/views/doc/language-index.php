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
			<p><?= Html::encode(Yii::t('doc', "This is a completely translated system at all levels. To achieve this you must define here the languages that you will be using. Probably you have recieved a lot of languages installed when you first installed the system. Feel free to delete any languages you are sure you don't want.")) ?></p>
			<p><?= Html::encode(Yii::t('doc', "A very critical setting on your system is the configuration web file that sets the default language for the whole system. Shown below:")) ?></p>
			<div class="well">
				<p>/wwwroot/[yourProgName]/_protected/config/web.php</p>
				<p>'language' => 'en',</p>
			</div>
			<p><?= Html::encode(Yii::t('doc', "The ISO Name is very important that you get it exactly right. Several directories are to be named the exact same name.")) ?></p>
			<div class="well">
				<p>/wwwroot/[yourProgName]/_protected/messages/ar</p>
				<p>/wwwroot/[yourProgName]/_protected/messages/da</p>
				<p>/wwwroot/[yourProgName]/_protected/messages/de</p>
				<p>/wwwroot/[yourProgName]/_protected/messages/[ISO <?=Yii::t('app', 'name')?>]</p>

			</div>
			<p><?= Html::encode(Yii::t('doc', "If you create a new language then you must create a directory as shown above and in that directory you need to copy files from a similar directory and make the appropriate translations.")) ?></p>
			<p><?= Html::encode(Yii::t('doc', "If you improve on an existing translation then please send that translation to us so that others can enjoy your work.")) ?></p>
			<p><?= Html::encode(Yii::t('doc', "Another important setting for language is in the user profile. Go there to define what language you want to see.")) ?></p>
		</div>
	</div>
</div>