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


$church=Church::findOne(Yii::$app
	->user
	->identity
	->church_id);
$GLOBALS['time_zone']=$church->time_zone;
$GLOBALS['id']=$id;
Yii::$app->formatter->defaultTimeZone=$church->time_zone;
Yii::$app->formatter->timeZone=$church->time_zone;

//$uriParts=explode('/',$_SERVER['REQUEST_URI']);
//$GLOBALS['eventuri']='/'.$uriParts[1].'/'.$uriParts[2];

$this->title = Yii::t('app', 'Notifications');

?>

<div id="always_showing" class="eventtemplate-form">
<?php if($id){ ?>
	<div class="row">
		<h1><?= Yii::t('app', 'Send text message to')?></h1>
		<div class="col-lg-6 well">
			<label><?= Yii::t('app', 'List of users to receive a message')?></label>
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

			<?php $form = ActiveForm::begin(['id' => 'form-activity','action'=>'notify?id='.$id]); ?>
			
			<div style="width: 100%; display: table; margin-bottom:25px;">
				<label><?= Yii::t('app', 'User to add to the message')?></label>
				<div style="display: table-row;">
					<div style="width: 65%; display: table-cell;"> 
						<select id="ddslick-user_id" class="form-control" name="ddslick" aria-invalid="false">
							<option value=""><?=Yii::t('app', 'Select')?></option>
						<?php 
						$users=app\models\User::find()->where(['church_id' => $church_id])->orderBy("display_name ASC")->all();
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
			<?= $form->field($model, 'message_html')->textarea() ?>
			<div class="form-group" style="margin-top:20px;">     
				<?= Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-success']) ?>

			</div>
			<?php ActiveForm::end(); ?>				
		</div>	
	</div>
<?php } ?>	
	<div class="row">
		<div class="col-lg-6">
			<h1>
				<?= Html::encode( Yii::t('app', 'Notifications'))?>  
				<?php if(Yii::$app->user->can('TeamManager') && Yii::$app->has('SmsMessaging') && (Yii::$app->SmsMessaging->getImplementationLevel()&Sms::IMPLEMENTED_ID_AND_STATUS)==Sms::IMPLEMENTED_ID_AND_STATUS) { ?>
					<span class="pull-right">				
						<?php $form = ActiveForm::begin(['id' => 'form-notifications','action'=>'notifications?id='.$id]); ?>         
							<div class="form-group">     
								<?= Html::submitButton(Yii::t('app', 'Refresh SMS status'), ['class' => 'btn btn-primary']) ?>
							</div>
						<?php ActiveForm::end(); ?>			
					</span>  
				<?php } ?>
			</h1>

			<?= GridView::widget([
				'dataProvider' => $dataNotificationProvider,
				//'filterModel' => $searchNotificationModel,
				'summary' => false,
				'columns' => [			
					[
						'attribute' => 'from',
						'format' => 'raw',
						'value' => function ($data) {
							return User::getThumbnailMedium($data->user_from_id);
						}
					],
					'userFrom.display_name',
					[
						'attribute' => 'to',
						'format' => 'raw',
						'value' => function ($data) {
							return User::getThumbnailMedium($data->user_to_id);
						}
					],
					'userTo.display_name',					
					[
						'attribute' => 'notified_date',
						'format' => 'raw',
						'value' => function ($model, $index, $widget) {
							if($model->notified_date==null || strlen($model->notified_date)==0){
								return '';
							}
							$dt = new DateTime($model->notified_date, new DateTimeZone('UTC'));
							$dt->setTimezone(new DateTimeZone($GLOBALS['time_zone']));
							return $dt->format('Y-m-d H:i');
						},
					],				
					[
						'attribute' => 'sms_status',
						'format' => 'raw',
						'value' => function ($model, $index, $widget) {
							return $model->sms_status_id . ': ' . Yii::t('app', $model->sms_status);
						},
					],			
					// buttons
					['class' => 'yii\grid\ActionColumn',
					'header' => Yii::t('app', 'Menu'),
					'template' => '{seenotify} {deletenotify}',
						'buttons' => [
							'seenotify' => function ($url, $model, $key) {
								return Html::a('', $url . '&userid='.$GLOBALS['id'], ['title'=>Yii::t('app', 'See details'), 'class'=>'glyphicon glyphicon-eye-open menubutton']);
							},
							'deletenotify' => function ($url, $model, $key) {
								return Yii::$app->user->can('ChurchAdmin')?Html::a('', $url . '&userid='.$GLOBALS['id'], ['title'=>Yii::t('app', 'Delete'), 'class'=>'glyphicon glyphicon-trash menubutton','data' => [
											'confirm' => Yii::t('app', 'Are you sure you want to delete this?'),
											'method' => 'post']]):'';
							},
						]

					], // ActionColumn								
					
				], // columns

			]); ?>			
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
			selectedPersons.forEach(function(entry) {
				if(ids.length!=0){ids+='.';}
				ids+=entry.value;
			});				
			$('#usernotification-user_to_id').val(ids);
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
	selectedPersons.forEach(function(entry) {
		if(entry.value!=userId){
			$('#tablebody').append("<tr><td><img class='profilephotothumbnailmedium' src='"+entry.imageSrc+"' /></td><td>"+entry.text+"</td><td><a href='mailto:"+entry.description+"'>"+entry.description+"</a></td><td><a title='<?=Yii::t('app', 'Delete')?>' class='glyphicon glyphicon-trash menubutton' onclick='removeUser("+entry.value+");' ></a></td></tr>");
		}
		if(ids.length!=0){ids+='.';}
		ids+=entry.value;
	});		
	$('#usernotification-user_to_id').val(ids);
}

$(document).ready(function () {

});

</script>