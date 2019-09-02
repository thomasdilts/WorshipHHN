<?php
use app\helpers\CssHelper;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

//GLOBALS['urlAddition']=$urlAddition;
?>

<div class="row">
	<div class="col-lg-6">	
		<h1>
			<?= Html::encode( Yii::t('app', 'Choose message')) ?> 
		</h1>	
		<?php $form = ActiveForm::begin(['id' => 'form-notification']); ?>
			<?= $form->field($model, 'message_template_id')->dropDownList(ArrayHelper::map($templates, 'id', 'name'),['prompt' => Yii::t('app', 'Select')]) ?>
			<?= $form->field($model, 'custom_message')->textArea(['style'=>'display:none;']) ?>
			<?=  Html::checkbox('Notification[send_from_address]', strlen(Yii::$app->user->identity->mobilephone)>4,['style'=>'display:none;','id'=>'notification-send_from_address']); ?>
			<label id='send_from_address' style='display:none;margin-bottom:40px;'>&nbsp;&nbsp;<?= Html::encode( Yii::t('app', 'Send SMS replies to me')) ?></label>
			
			<div class="form-group">     
				<?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') 
					: Yii::t('app', 'Update'), ['class' => $model->isNewRecord 
					? 'btn btn-success' : 'btn btn-primary','style' => 'display:none;','id'=>'create_button','onclick'=>'$("#create_button").hide();$("#cancel_button").hide();']) ?>

				<?= Html::a(Yii::t('app', 'Cancel'), ['event/notifications?id='.$eventid], ['class' => 'btn btn-default','id'=>'cancel_button']) ?>
			</div>
		<?php ActiveForm::end(); ?>

	</div>
	<div id="preview-label" style="display:none;" class="col-lg-6">	
		<h1>
			<?= Html::encode( Yii::t('app', 'Preview')) ?> 
		</h1>	
		<div id='preview' class="col-lg-6" style="display:none;background-color: #d2f5ff;min-height: 200px;width:100%;border-style: ridge;"></div>
	</div>
	<script>
		var jsonTemplates=`<?= $jsonTemplates ?>`;
		$( document ).ready(function() {
			$("#notification-message_template_id").change(function(){
				var selectedTemplate=$("#notification-message_template_id").val();
				$('label[for=notification-custom_message]').hide();
				$("#preview").hide();
				$("#preview-label").hide();
				$("#notification-custom_message").hide();
				$("#create_button").hide();
				$("#notification-send_from_address").hide();
				$("#send_from_address").hide();
				if(selectedTemplate!=0)
				{
					var foundTemplate=null;
					var allTemplates=JSON.parse(jsonTemplates.replace(/\r\n/g,'<br />').replace(/\n/g,'<br />'));
					allTemplates.forEach(function(template){
						if(template.id==selectedTemplate) {
					  		foundTemplate=template;
					  	}
					  }
					);
					$("#preview").html('');
					
					
					
					
					if(foundTemplate.message_system=='Email'){
						$("#preview").append("<label style='min-width:100%;' class='col-lg-6'>" + "<?= Yii::t('app', 'To')?>" + "</label>");
						$("#preview").append(
								"<div style='background-color: #d2f5ff;width:100%;border-style: solid;border-color: lightblue;margin:5px' class='col-lg-6'>" + '<?=$emails?>' + "</div>");
						$("#preview").append("<label style='min-width:100%;' class='col-lg-6'>" + "<?= Yii::t('app', 'Subject')?>" + "</label>");
						if(foundTemplate.use_auto_subject){
							$("#preview").append(
								"<div style='background-color: #d2f5ff;width:100%;border-style: solid;border-color: lightblue;margin:5px' class='col-lg-6'>" + '<?=$subject?>' + "</div>");
						}
						else{
							$("#preview").append(
								"<div style='background-color: #d2f5ff;width:100%;border-style: solid;border-color: lightblue;margin:5px' class='col-lg-6'>" + foundTemplate.subject + "</div>");
						}
						$("#preview").append("<label style='min-width:100%;' class='col-lg-6'>" + "<?= Yii::t('app', 'Message')?>" + "</label>");
						if(foundTemplate.allow_custom_message){
							$('label[for=notification-custom_message]').show();
							$("#notification-custom_message").show();
							$("#preview").append("<div  style='min-width:100%;' class='col-lg-6' id='custom-message-preview'></div>");
							$("#preview").append("<hr style='color:lightblue;background-color:lightblue;height:2px;margin:3px;padding:2px;'>");
						}

						$("#preview").append("<p  style='width:100%;' class='col-lg-6'>" + foundTemplate.body + '</p>');
						if(foundTemplate.show_accept_button){
							$("#preview").append("<div style='background-color: lightgreen;border-style: solid;border-color: lightblue;padding:10px;margin:5px;text-align:center;max-width:40%;' class='col-lg-5' >" + foundTemplate.accept_button_text + "</div>");
						}
						if(foundTemplate.show_reject_button){
							$("#preview").append("<div style='background-color: #DDB0A0;border-style: solid;border-color: lightblue;padding:10px;margin:5px;text-align:center;max-width:40%;'  class='col-lg-5'>" + foundTemplate.reject_button_text + "</div>");
						}
						if(foundTemplate.show_link_to_object){
							$("#preview").append("<div style='background-color: #d2f5ff;color:blue;text-decoration:underline;margin:5px' class='col-lg-6'>" + foundTemplate.link_text + "</div>");
						}
					}else{
						if('<?=Yii::$app->user->identity->mobilephone ?>'.length>5){
							$("#notification-send_from_address").show();
							$("#send_from_address").show();		
						}

						
						$("#preview").append("<p  style='width:100%;' class='col-lg-6'>" + foundTemplate.body + '</p>');
						if(foundTemplate.allow_custom_message){
							$('label[for=notification-custom_message]').show();
							$("#notification-custom_message").show();
							$("#preview").append("<div  style='min-width:100%;' class='col-lg-6' id='custom-message-preview'></div>");
						}						
						if(foundTemplate.use_auto_subject){
							$("#preview").append(
								"<div style='background-color: #d2f5ff;width:100%;margin:5px' class='col-lg-6'>" + '<?=$subject?>' + "</div>");
						}
						if(foundTemplate.show_link_to_object){
							$linkHost = '<?=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . Yii::$app->request->baseUrl?>'; 
							$("#preview").append("<div style='background-color: #d2f5ff;color:blue;text-decoration:underline;margin:5px' class='col-lg-6'>" + $linkHost + "/event/activities?id=19</div>");
						}						
					}

					$("#preview").show();
					$("#preview-label").show();
					$("#create_button").show();
				}
			});
			$("#notification-custom_message").keyup(function(){
				$("#custom-message-preview").html($("#notification-custom_message").val().replace(/\r\n/g,'<br />').replace(/\n/g,'<br />'));
			});
			$('label[for=notification-custom_message]').hide();
		});
	</script>
</div>