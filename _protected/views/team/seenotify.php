<?php
use app\helpers\CssHelper;
use app\models\Church;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = Yii::t('app', 'Notification');

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Teams'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $team->name, 'url' => ['notifications?id='.$team->id]]; 
$this->params['breadcrumbs'][] = $this->title;

$church=Church::findOne(Yii::$app
	->user
	->identity
	->church_id);
$notified_date = new DateTime($model->notified_date, new DateTimeZone('UTC'));
$notified_date->setTimezone(new DateTimeZone($church->time_zone));
?>
<div class="song-index">
    <div class="col-lg-6">
		<div class="row">
			<h1 style="margin-left:15px;">
				<?= Html::encode($this->title) ?>
				<span class="pull-right">
					<?= Html::a(Yii::t('app', 'Back'), ['notifications?id='.$team->id], ['class' => 'btn btn-warning']) ?>
				</span>         
			</h1>
		</div>
		<div class="row">
			<label style='min-width:100%;' ><?= Yii::t('app', 'SMS status')?></label>       
			<span style='margin-left:40px;'><?=$model->sms_status_id . ': ' . Yii::t('app', $model->sms_status)?></span>

			<label style='min-width:100%;' ><?= Yii::t('app', 'Notified Date')?></label>
			<span style="margin-left:40px"><?= $notified_date->format('Y-m-d H:i') ?></span>
			
			<label style='min-width:100%;' ><?= Yii::t('app', 'From')?></label>
			<span style="margin-left:40px"><?= Html::encode($userFrom->display_name . ': ' . $userTo->email) ?></span>

			<label style='min-width:100%;' ><?= Yii::t('app', 'To')?></label>
			<span style="margin-left:40px"><?= Html::encode($userTo->display_name . ': ' . $userTo->email) ?></span>

			<label style='min-width:100%;' ><?= Yii::t('app', 'Message')?></label>
			<div class='well'>
				<?=str_replace("\r\n",'<br />',Html::encode($model->message_html))?>
			</div>
		</div>	
    </div>
</div>