<?php
use app\helpers\CssHelper;
use app\models\Language;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
//use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
$usedLanguages=app\models\MessageTemplate::find()->where(['message_type_id' => $model->message_type_id])->joinWith('language')->orderBy("language.display_name_native ASC")->all();



$this->title = Yii::t('app', 'Message templates');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1>
        <?= Html::encode($this->title) ?>
        <span class="pull-right" style="margin-bottom:5px">
            <a href='<?=URL::toRoute('doc/doc')?>?page=message-template-index&returnName=<?=$this->title?>&returnUrl=<?=URL::toRoute('message-template/index')?>%3Ftypeid%3D<?=$model->message_type_id?>%26langid%3D<?=$model->language_id?>' class='btn btn-primary'><span class="glyphicon glyphicon-question-sign"></span></a>			
        </span>         
    </h1>
	<div class="row">
		<div class="col-md-5 bs-component">
			<?php $form1 = ActiveForm::begin(['id' => 'form-messagetype']); ?>
				<?= $form1->field($model, 'message_type_id')->dropDownList(ArrayHelper::map(app\models\MessageType::find()->where([
					'church_id' => $model->church_id])->orderBy("name ASC")->all(), 'id', 'name'),['onChange'=>'this.form.submit();']) ?>   
				<?= Html::activeHiddenInput($model, 'language_id') ?>  	
			
			<?php ActiveForm::end(); ?>	
		</div>
		<div class="col-md-5 well bs-component pull-right">
			<?php $form2 = ActiveForm::begin(['id' => 'form-createmessagetype','action'=>'createtype']); ?>
			<?= $form2->field($model, 'type_name_create')->textInput() ?>  		
			<span class="pull-right" style="margin-bottom:5px">
				<?= Html::submitButton(Yii::t('app', 'Create Message Type'), ['class' => 'glyphicon glyphicon-plus btn btn-success']) ?>
				<a href='deletetype?typeid=<?=$model->message_type_id ?>&langid=<?=$model->language_id ?>' class='btn btn-warning' onclick="return confirm('<?=Yii::t('app', 'Are you sure you want to delete this?')?>')"><span class="glyphicon glyphicon-trash"></span> <?=Yii::t('app', 'Delete')?></a>			
			</span>     	
			<?php ActiveForm::end(); ?>	
		</div>
	</div>
	<?php if($model->message_type_id != ''){ ?>   
	<div class="row">
		<div class="col-md-5 bs-component">
			<?php $form3 = ActiveForm::begin(['id' => 'form-messagelanguage']); ?>
				<?= $form3->field($model, 'language_id')->dropDownList(ArrayHelper::map($usedLanguages, 'language_id', 'language.display_name_native'),['onChange'=>'this.form.submit();']) ?>          
				<?= Html::activeHiddenInput($model, 'message_type_id') ?>  			
			<?php ActiveForm::end(); ?>	
		</div>
		
		<div class="col-md-5 well bs-component pull-right">
			<?php $form4 = ActiveForm::begin(['id' => 'form-createmessagetemplate','action'=>'createmessage']); ?>
				<?= $form4->field($model, 'language_id_create')->dropDownList(ArrayHelper::map(Language::find()->where(['church_id'=>$model->church_id])->andWhere(['not in', 'id', ArrayHelper::getColumn($usedLanguages, 'language_id', false)])->orderBy("display_name_native ASC")->all(), 'id', 'display_name_native')) ?>          	
				<?= Html::activeHiddenInput($model, 'message_type_id') ?>  			
				<span class="pull-right" style="margin-bottom:5px">
					<?= Html::submitButton(Yii::t('app', 'Create Message Template'), ['class' => 'glyphicon glyphicon-plus btn btn-success']) ?>
					<a href='deletemessage?typeid=<?=$model->message_type_id ?>&langid=<?=$model->language_id ?>&messageid=<?=$model->message_id ?>' class='btn btn-warning' onclick="return confirm('<?=Yii::t('app', 'Are you sure you want to delete this?')?>')"><span class="glyphicon glyphicon-trash"></span> <?=Yii::t('app', 'Delete')?></a>			
				</span>     	
			<?php ActiveForm::end(); ?>	
		</div>
	</div>
	<?php } ?>  
	<?php if($model->language_id != ''){ ?>   
	<div class="row">
		<div class="col-lg-6 well">
			<?php $form = ActiveForm::begin(['id' => 'form-messagetemplate','action'=>'update?typeid='.$model->message_type_id.'&langid='.$model->language_id]); ?>         
				<?= $form->field($model, 'message_name')->textInput(
						['autofocus' => true]) ?>
				<?= Html::activeHiddenInput($model, 'message_id') ?> 
				<?= Html::activeHiddenInput($model, 'message_type_id') ?>  
				<?= Html::activeHiddenInput($model, 'language_id') ?>
				<?= $form->field($model, 'message_system')->dropDownList(['Email'=>Yii::t('app', 'Email'),'SMS'=>Yii::t('app', 'SMS'),],['onChange'=>'redrawPreview();']) ?>
				<div id='show_accept_button'>
					<?= $form->field($model, 'show_accept_button')->checkbox(['onChange'=>'redrawPreview();']);?>
					<?= $form->field($model, 'accept_button_text')->textInput(['onChange'=>'redrawPreview();','onKeyUp'=>'redrawPreview();']);?>
					<?= $form->field($model, 'show_reject_button')->checkbox(['onChange'=>'redrawPreview();']);?>
					<?= $form->field($model, 'reject_button_text')->textInput(['onChange'=>'redrawPreview();','onKeyUp'=>'redrawPreview();']);?>
				</div>
				<?= $form->field($model, 'show_link_to_object')->checkbox(['onChange'=>'redrawPreview();']);?>
				<div id='link_text'>
					<?= $form->field($model, 'link_text')->textInput(['onChange'=>'redrawPreview();','onKeyUp'=>'redrawPreview();']);?>
				</div>
				<?= $form->field($model, 'allow_custom_message')->checkbox(['onChange'=>'redrawPreview();']);?>
				<?= $form->field($model, 'use_auto_subject')->checkbox(['onChange'=>'redrawPreview();']);?>
				<div id='subject'>
					<?= $form->field($model, 'subject')->textInput(['onChange'=>'redrawPreview();','onKeyUp'=>'redrawPreview();']);?>
				</div>
				<?= $form->field($model, 'body')->textArea(['onChange'=>'redrawPreview();','onKeyUp'=>'redrawPreview();']);?>
				<div class="form-group">     
					<?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-primary']) ?>
				</div>

			<?php ActiveForm::end(); ?>

		</div>
		<div id="preview-label" style="display:<?=$model->language_id && $model->message_type_id?'inline':'none' ?>;" class="col-lg-6">	
			<h1>
				<?= Html::encode( Yii::t('app', 'Preview')) ?> 
			</h1>	
			<div id='preview' class="col-lg-6" style="background-color: #d2f5ff;min-height: 200px;width:100%;border-style: ridge;"></div>
		</div>		
	</div>	
	<?php } ?> 
</div>
<script>
function redrawPreview(){
	$("#preview").html('');

	if($('#messagetypeform-message_system').val()=='Email'){
		$( "#show_accept_button" ).show();
		$( "#subject" ).show();
		$( "#link_text" ).show();
		$("#preview").append("<label style='min-width:100%;' class='col-lg-6'>" + "<?= Yii::t('app', 'To')?>" + "</label>");
		$("#preview").append(
				"<div style='background-color: #d2f5ff;width:100%;border-style: solid;border-color: lightblue;margin:5px' class='col-lg-6'></div>");
		$("#preview").append("<label style='min-width:100%;' class='col-lg-6'>" + "<?= Yii::t('app', 'Subject')?>" + "</label>");

		if($('#messagetypeform-use_auto_subject').is(":checked")){
			$( "#messagetypeform-subject" ).prop( "disabled", true );
			$("#preview").append(
				"<div style='background-color: #d2f5ff;width:100%;border-style: solid;border-color: lightblue;margin:5px' class='col-lg-6'>" + '<?=Yii::t('app', 'Use an automatically created subject')?>' + "</div>");
		}
		else{
			$( "#messagetypeform-subject" ).prop( "disabled", false );
			$("#preview").append(
				"<div style='background-color: #d2f5ff;width:100%;border-style: solid;border-color: lightblue;margin:5px' class='col-lg-6'>" + $('#messagetypeform-subject').val() + "</div>");
		}
		$("#preview").append("<label style='min-width:100%;' class='col-lg-6'>" + "<?= Yii::t('app', 'Message')?>" + "</label>");
		if($('#messagetypeform-allow_custom_message').is(":checked")){
			$("#preview").append("<div  style='min-width:100%;' class='col-lg-6' id='custom-message-preview'><?=Yii::t('app', 'Allow Custom Message')?></div>");
			$("#preview").append("<hr style='color:lightblue;background-color:lightblue;height:2px;margin:3px;'>");
		}

		$("#preview").append("<p  style='width:100%;' class='col-lg-6'>" + $('#messagetypeform-body').val() + '</p>');
		if($('#messagetypeform-show_accept_button').is(":checked")){
			$( "#messagetypeform-accept_button_text" ).prop( "disabled", false );
			$("#preview").append("<div style='background-color: lightgreen;border-style: solid;border-color: lightblue;padding:10px;margin:5px;text-align:center;max-width:40%;' class='col-lg-5' >" + $('#messagetypeform-accept_button_text').val() + "</div>");
		}else{
			$( "#messagetypeform-accept_button_text" ).prop( "disabled", true );
		}
		if($('#messagetypeform-show_reject_button').is(":checked")){
			$( "#messagetypeform-reject_button_text" ).prop( "disabled", false );
			$("#preview").append("<div style='background-color: #DDB0A0;border-style: solid;border-color: lightblue;padding:10px;margin:5px;text-align:center;max-width:40%;'  class='col-lg-5'>" + $('#messagetypeform-reject_button_text').val() + "</div>");
		}else{
			$( "#messagetypeform-reject_button_text" ).prop( "disabled", true );
		}
		if($('#messagetypeform-show_link_to_object').is(":checked")){
			$( "#messagetypeform-link_text" ).prop( "disabled", false );
			$("#preview").append("<div style='background-color: #d2f5ff;color:blue;text-decoration:underline;margin:5px' class='col-lg-6'>" + $('#messagetypeform-link_text').val() + "</div>");
		}else{
			$( "#messagetypeform-link_text" ).prop( "disabled", true );
		}
	}else{
		$( "#show_accept_button" ).hide();
		$( "#subject" ).hide();
		$( "#link_text" ).hide();
		$("#preview").append("<p  style='width:100%;' class='col-lg-6'>" + $('#messagetypeform-body').val() + '</p>');
		if($('#messagetypeform-allow_custom_message').is(":checked")){
			$("#preview").append("<div  style='min-width:100%;' class='col-lg-6' id='custom-message-preview'><?=Yii::t('app', 'Allow Custom Message')?></div>");
		}
		if($('#messagetypeform-use_auto_subject').is(":checked")){
			$("#preview").append(
				"<div style='background-color: #d2f5ff;width:100%;margin:5px' class='col-lg-6'>" + '<?=Yii::t('app', 'Use an automatically created subject')?>' + "</div>");
		}
		
		if($('#messagetypeform-show_link_to_object').is(":checked")){
			$linkHost = '<?=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . Yii::$app->request->baseUrl?>'; 
			$("#preview").append("<div style='background-color: #d2f5ff;color:blue;text-decoration:underline;margin:5px' class='col-lg-6'>" + $linkHost + "/event/activities?id=19</div>");
		}else{
			$( "#messagetypeform-link_text" ).prop( "disabled", true );
		}		
	}
	
}

	<?php if($model->language_id != ''){ ?>  
$( document ).ready(function() {
	redrawPreview()
});
	<?php } ?> 
</script>

