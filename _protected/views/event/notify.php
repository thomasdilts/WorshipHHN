<?php
use app\helpers\CssHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::t('app', 'Event notify');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Events'), 'url' => ['event/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Notifications'), 'url' => ['event/notifications?id='.$eventid]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <div>
		<?php $form = ActiveForm::begin(['id' => 'form-notification']); ?>
			<?= $this->render('../_notify', [
				'form'=>$form, 
				'subject'=>$subject, 
				'emails'=>$emails,         	
				'jsonTemplates'=>$jsonTemplates,
				'actionid'=>$actionid, 
				'userid'=>$userid, 
				'eventid'=>$eventid,
				'model'=>$model,
				'templates' => $templates]) ?>
		<?php ActiveForm::end(); ?>
    </div>
</div>