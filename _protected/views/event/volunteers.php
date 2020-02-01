<?php
use app\rbac\models\AuthItem;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\i18n\Formatter;
use app\models\Team;
use app\models\File;
use yii\helpers\ArrayHelper;
use app\models\User;
use app\models\Church;
use yii\helpers\Url;
use thomasdilts\sms_worshiphhn\Sms;


$church=Church::findOne(Yii::$app->user->identity->church_id);

Yii::$app->formatter->defaultTimeZone=$church->time_zone;
Yii::$app->formatter->timeZone=$church->time_zone;

$this->title = Yii::t('app', 'Notifications');

?>

<div id="always_showing" class="eventtemplate-form">
	<div class="row">
		<h1><?= Yii::t('app', 'Find volunteers') .'. '.$eventname.' : '.$activityname?></h1>
		<h1><?= Yii::t('app', 'Send text message to')?></h1>
		<div class="col-lg-6 well">
			<label><?= Yii::t('app', 'List of users to receive a message')?></label>
			<div id="LinkToMail" style="display:none;"></div>
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th></th>
						<th><?= Yii::t('app', 'Display name')?> </th>
						<th><?= Yii::t('app', 'Email')?> </th>
						<th><?= Yii::t('app', 'Menu')?> </th>
					</tr>
				</thead> 
				<tbody id="tablebody">
				</tbody>
			</table>

			<?php $form = ActiveForm::begin(['id' => 'form-activity']); ?>
			
			<div style="width: 100%; display: table; margin-bottom:25px;">
				<label><?= Yii::t('app', 'User to add to the message')?></label>
				<div style="display: table-row;">
					<div style="width: 65%; display: table-cell;"> 
						<select id="ddslick-user_id" class="form-control" name="ddslick" aria-invalid="false">
							<option value=""><?=Yii::t('app', 'Select')?></option>
						<?php 
						$rowCounter=1;
						$fileVault = substr(Yii::$app->params['fileVaultPath'],strlen(dirname(__DIR__,3)));
						foreach($users as $user){ 
							$file=File::findOne(['model'=>'user','itemId'=>$user->id]);	
							$rowCounter++; ?>
							<option data-imagesrc="<?=$file?Yii::$app->request->baseUrl. $fileVault. DIRECTORY_SEPARATOR .$file->hash:''?>" data-description="<?=$user->email ?>" value="<?=$user->id ?>"><?=$user->display_name ?></option>

						<?php } ?>
				
						</select>

					</div>
				</div>
			</div>			
			<?= Html::activeHiddenInput($model, 'user_to_id') ?>
			<?php $linkHost = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . Yii::$app->request->baseUrl . '/event/activities?id='.$eventid; ?>
			<?= $form->field($model, 'message_html')->textarea(['rows'=>5,'value'=>"\r\n\r\n".$eventname."\r\n".$activityname."\r\n".$linkHost ]) ?>
			<div class="form-group" style="margin-top:20px;">     
				<?= Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-success']) ?>

			</div>
			<?php ActiveForm::end(); ?>				
		</div>	
	</div>
</div>
<script>
var selectedPersons=[];
$('#ddslick-user_id').ddslick({
	height:400,
	onSelected: function (data) {
		if(data.selectedData.value){
			selectedPersons.push(data.selectedData);
			$('#tablebody').append("<tr><td><img class='profilephotothumbnailmedium' src='"+data.selectedData.imageSrc+"' /></td><td>"+data.selectedData.text+"</td><td><a href='mailto:"+data.selectedData.description+"'>"+data.selectedData.description+"</a></td><td><a title='<?=Yii::t('app', 'Delete')?>' class='glyphicon glyphicon-trash menubutton' onclick='removeUser("+data.selectedData.value+");' ></a></td></tr>");
			
			// create the list of id's 
			var ids='';
			var mails='';
			selectedPersons.forEach(function(entry) {
				if(ids.length!=0){ids+='.';}
				ids+=entry.value;
				if(mails.length!=0){mails+=';';}
				mails+=entry.description;
			});			
			var linkHost = '<?=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . Yii::$app->request->baseUrl . "/event/activities?id=".$eventid ?>'; 
			$('#LinkToMail').html('<a href="mailto:' + mails + '?subject=<?=$eventname.' : '.$activityname?>&body='+ linkHost + '"><?= Yii::t('app', 'Send email to all in the list')?></a>');
			$('#usernotification-user_to_id').val(ids);
			$('#LinkToMail').show()
		}
	}
});
function removeUser(userId){
	var selectedPersonsCleaned=[];
	selectedPersons.forEach(function(entry) {
		if(entry.value!=userId){
			selectedPersonsCleaned.push(entry);
		}
	});	
	selectedPersons=selectedPersonsCleaned;
	
	// redraw all items.
	$('#tablebody').empty();
	var ids='';
	var mails='';
	selectedPersons.forEach(function(entry) {
		if(entry.value!=userId){
			$('#tablebody').append("<tr><td><img class='profilephotothumbnailmedium' src='"+entry.imageSrc+"' /></td><td>"+entry.text+"</td><td><a href='mailto:"+entry.description+"'>"+entry.description+"</a></td><td><a title='<?=Yii::t('app', 'Delete')?>' class='glyphicon glyphicon-trash menubutton' onclick='removeUser("+entry.value+");' ></a></td></tr>");
		}
		if(ids.length!=0){ids+='.';}
		ids+=entry.value;
		if(mails.length!=0){mails+=';';}
		mails+=entry.description;
	});		
	$('#usernotification-user_to_id').val(ids);
	var linkHost = '<?=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . Yii::$app->request->baseUrl . "/event/activities?id=".$eventid ?>'; 
	$('#LinkToMail').html('<a href="mailto:' + mails + '?subject=<?=$eventname.' : '.$activityname?>&body='+ linkHost + '"><?= Yii::t('app', 'Send email to all in the list')?></a>');
	if(selectedPersons.length>0){$('#LinkToMail').show();}else{$('#LinkToMail').hide();}
}

$(document).ready(function () {

});

</script>