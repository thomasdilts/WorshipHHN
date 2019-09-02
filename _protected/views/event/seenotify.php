<?php
use app\helpers\CssHelper;
use app\models\Church;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = Yii::t('app', 'Notification');

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Events'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $event->name . ' ' . Yii::$app->formatter->asDate($event->start_date, "Y-MM-dd H:mm"), 'url' => ['notifications?id='.$event->id]]; 
$this->params['breadcrumbs'][] = $this->title;

$htmlMessage = str_replace("<a", "<span", $model->message_html);
$htmlMessage = str_replace("</a>", "</span>", $htmlMessage);

$colors=array('Not replied yet'=>'yellow','Accepted'=>'lightgreen','Rejected'=>'lightpink','No reply requested'=>'lightgreen',);
$church=Church::findOne(Yii::$app
	->user
	->identity
	->church_id);
$notified_date = new DateTime($model->notified_date, new DateTimeZone('UTC'));
$notified_date->setTimezone(new DateTimeZone($church->time_zone));

$notify_replied_date = new DateTime($model->notify_replied_date, new DateTimeZone('UTC'));
$notify_replied_date->setTimezone(new DateTimeZone($church->time_zone));
?>
<div class="song-index">
    <div class="col-lg-6">
        <h1>
            <?= Html::encode($this->title) ?>
            <span class="pull-right">
                <?= Html::a(Yii::t('app', 'Back'), ['notifications?id='.$event->id], ['class' => 'btn btn-warning']) ?>
            </span>         
        </h1>

        <label style='min-width:100%;' ><?= Yii::t('app', 'Status')?></label>       
        <span style='margin-left:40px;background-color:<?=$colors[$model->status]?>;'><?=Yii::t('app', $model->status)?></span>

        <label style='min-width:100%;' ><?= Yii::t('app', 'Notified Date')?></label>
        <span style="margin-left:40px"><?= $notified_date->format('Y-m-d H:i') ?></span>

        <label style='min-width:100%;' ><?= Yii::t('app', 'Replied Date')?></label>
        <span style="margin-left:40px"><?= $notify_replied_date->format('Y-m-d H:i') ?></span>

        <?php if(strlen($teamname)>0) { ?>
            <label style='min-width:100%;' ><?= Yii::t('app', 'Team')?></label>
            <span style="margin-left:40px"><?= Html::encode($teamname) ?></span>
        <?php } ?>

        <label style='min-width:100%;' ><?= Yii::t('app', 'To')?></label>
        <span style="margin-left:40px"><?= Html::encode($user->display_name . ': ' . $user->email) ?></span>

        <label style='min-width:100%;' ><?= Yii::t('app', 'Subject')?></label>
        <?php if($template->use_auto_subject) { ?>
            <span style="margin-left:40px"><?=$event->name . ' ' . Yii::$app->formatter->asDate($event->start_date, "Y-MM-dd H:mm") . ' ' . $activity->name  ?></span>
        <?php }else{ ?>   
            <span style="margin-left:40px"><?= Html::encode($template->subject) ?></span>     
        <?php } ?>    

        <label style='min-width:100%;' ><?= Yii::t('app', 'Message')?></label>
        <div class='well'>
            <?=$template->message_system=='Email'?$htmlMessage:str_replace("\r\n",'<br />',Html::encode($htmlMessage))?>
        </div>
    </div>
</div>