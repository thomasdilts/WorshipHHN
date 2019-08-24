<?php

namespace app\controllers;

use app\models\Log;
use app\models\LogWhat;
use app\models\MessageType;
use app\models\MessageTypeForm;
use app\models\MessageTemplate;
use app\models\Language;
use app\models\MessageTemplateSearch;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii;

class MessageTemplateController extends AppController
{
	
    public function actionIndex($typeid='', $langid='')
    {
		$model = new MessageTypeForm();
		$model->church_id=Yii::$app->user->identity->church_id;
		
        if ($model->load(Yii::$app->request->post())) {
			// posting here.. What to do???
            //return ;//$this->render('signup', ['model' => $model]);  
			//simple redirect
			return $this->redirect(['index','typeid'=>$model->message_type_id,'langid'=>$model->language_id]);
        }		
		
		if(strlen($typeid)==0){
			//get first type, if none, send blank form
			$type=MessageType::find()->where(['church_id'=>$model->church_id])->orderBy(['name' => SORT_ASC])->one();
			if($type){
				$model->message_type_id=$type->id;
				$model->type_name=$type->name;
			}else{
				return $this->render('index', [
					'model' => $model]);
			}
		}
		else{
			//select the typeid
			$type=MessageType::findOne($typeid);
			$model->message_type_id=$type->id;
			$model->type_name=$type->name;
		}
		
		if(strlen($langid)==0){
			//get first existing language for that type, if none, send blank form
			$messTemp=MessageTemplate::find()->where(['message_type_id'=>$model->message_type_id])->orderBy(['name' => SORT_ASC])->one();
			if($messTemp){
				$model->language_id=$messTemp->language_id;
				$model->message_id=$messTemp->id;
				$model->message_name=$messTemp->name;
				$model->show_accept_button=$messTemp->show_accept_button;
				$model->show_reject_button=$messTemp->show_reject_button;
				$model->show_link_to_object=$messTemp->show_link_to_object;
				$model->allow_custom_message=$messTemp->allow_custom_message;
				$model->accept_button_text=$messTemp->accept_button_text;
				$model->reject_button_text=$messTemp->reject_button_text;
				$model->link_text=$messTemp->link_text;
				$model->subject=$messTemp->subject;
				$model->use_auto_subject=$messTemp->use_auto_subject;
				$model->body=$messTemp->body;
			}else{
				return $this->render('index', [
					'model' => $model]);
			}
		}else{
			//select the langid for this type
			$messTemp=MessageTemplate::find()->where(['message_type_id'=>$model->message_type_id,'language_id'=>$langid])->one();
			if(!$messTemp){
				$messTemp=MessageTemplate::find()->where(['message_type_id'=>$model->message_type_id])->one();
				if(!$messTemp){
					$model->language_id='';
					
					$this->render('index', [
						'model' => $model]);
				}
			}

			$model->language_id=$messTemp->language_id;
			$model->message_id=$messTemp->id;
			$model->message_name=$messTemp->name;
			$model->show_accept_button=$messTemp->show_accept_button;
			$model->show_reject_button=$messTemp->show_reject_button;
			$model->show_link_to_object=$messTemp->show_link_to_object;
			$model->allow_custom_message=$messTemp->allow_custom_message;
			$model->accept_button_text=$messTemp->accept_button_text;
			$model->reject_button_text=$messTemp->reject_button_text;
			$model->link_text=$messTemp->link_text;
			$model->subject=$messTemp->subject;
			$model->use_auto_subject=$messTemp->use_auto_subject;
			$model->body=$messTemp->body;
			
		}			

		return $this->render('index', [
			'model' => $model]);
    }
    public function actionCreatetype()
    {
		$model = new MessageTypeForm(['scenario' => 'create']);
		$model->church_id=Yii::$app->user->identity->church_id;
			
		$model->load(Yii::$app->request->post());
		if(strlen($model->type_name_create)==0){
			Yii::$app->session->setFlash("danger", Yii::t('app', 'Failed to create'). ': ' . Yii::t('app', 'Message Type') . ' ' . Yii::t('app', 'Name'));
			return $this->redirect(['index', 'typeid' => $model->message_type_id,'langid' => $model->language_id]);
		}
		$newType=new MessageType();
		$newType->name=$model->type_name_create;
		$newType->church_id=Yii::$app->user->identity->church_id;
		if(!$newType->save()){
			Yii::$app->session->setFlash("danger",Yii::t('app', 'Failed to create'). ': ' . Yii::t('app', 'Message Type') . ' ' . Yii::t('app', 'Name'));
			return $this->redirect(['index', 'typeid' => $model->message_type_id,'langid' => $model->language_id]);
		}	
		Log::write('MessageType', LogWhat::CREATE, null, (string)$newType);
		Yii::$app->session->setFlash("success", Yii::t("app", "Successful create"));
		return $this->redirect(['index', 'typeid' => $newType->id]);
	}
    public function actionCreatemessage()
    {
		$model = new MessageTypeForm(['scenario' => 'create']);
		$model->church_id=Yii::$app->user->identity->church_id;
			
		$model->load(Yii::$app->request->post());
		if(!$model->language_id_create || strlen($model->language_id_create)==0){
			Yii::$app->session->setFlash("danger",Yii::t('app', 'Failed to create'). ': ' . Yii::t('app', 'Message Template'));
			return $this->redirect(['index', 'typeid' => $model->message_type_id,'langid' => $model->language_id]);
		}
		$newTemplate=new MessageTemplate();
		$newTemplate->message_type_id=$model->message_type_id;
		$newTemplate->church_id=Yii::$app->user->identity->church_id;
		$newTemplate->name= MessageType::findOne($model->message_type_id)->name;
		$newTemplate->language_id= $model->language_id_create;
		$newTemplate->show_accept_button= 0;
		$newTemplate->use_auto_subject= 0;
		$newTemplate->show_reject_button= 0;
		$newTemplate->show_link_to_object= 0;
		$newTemplate->allow_custom_message= 0;
		$newTemplate->body= Yii::t('app', 'Body');
		$newTemplate->accept_button_text= '';
		$newTemplate->reject_button_text= '';
		$newTemplate->link_text= '';
		$newTemplate->subject= '';
		
		if(!$newTemplate->save()){
			Yii::$app->session->setFlash("danger",Yii::t('app', 'Failed to create'). ': ' . Yii::t('app', 'Message Template'));
			return $this->redirect(['index', 'typeid' => $model->message_type_id,'langid' => $model->language_id]);
		}	
		Log::write('MessageTemplate', LogWhat::CREATE, null, (string)$newTemplate);
		Yii::$app->session->setFlash("success", Yii::t("app", "Successful create"));
		return $this->redirect(['index', 'typeid' => $newTemplate->message_type_id,'langid' => $newTemplate->language_id]);
	}
    public function actionDeletetype($typeid, $langid)
    {
		try {
			$model=MessageType::findOne($typeid);
			if (!$model->delete()) {
				throw new ServerErrorHttpException(Yii::t('app', 'Failed to delete'));
			}
			$typeid=''; 
			$langid='';
		} catch (\yii\db\IntegrityException|Exception|Throwable  $e) {
			Yii::$app->session->setFlash('danger', Yii::t('app', 'Failed to delete. Object has dependencies that must be removed first.'). $e->getMessage());
		}       
		Log::write('MessageType', LogWhat::DELETE, (string)$model, null);
        Yii::$app->session->setFlash('success', Yii::t('app', 'Successful delete'));

		return $this->redirect(['index', 'typeid' => $typeid,'langid' => $langid]);
	}

    public function actionDeletemessage($typeid, $langid, $messageid)
    {
		try {
			$model=MessageTemplate::findOne($messageid);
			if (!$model->delete()) {
				throw new ServerErrorHttpException(Yii::t('app', 'Failed to delete'));
			}
			$langid='';
		} catch (\yii\db\IntegrityException|Exception|Throwable  $e) {
			Yii::$app->session->setFlash('danger', Yii::t('app', 'Failed to delete. Object has dependencies that must be removed first.'). $e->getMessage());
		}    		
		Log::write('MessageTemplate', LogWhat::DELETE, (string)$model, null);
        Yii::$app->session->setFlash('success', Yii::t('app', 'Successful delete'));
		$this->redirect(['index', 'typeid' => $typeid,'langid' => $langid]);
	}

    public function actionUpdate($typeid, $langid)
    {
        $model = new MessageTypeForm(['scenario' => 'create']);
		$model->load(Yii::$app->request->post());	

		$updateTemplate=MessageTemplate::findOne($model->message_id);
		$updateTemplateOld=clone $updateTemplate;
		$updateTemplate->name= $model->message_name;
		$updateTemplate->show_accept_button= $model->show_accept_button;
		$updateTemplate->use_auto_subject= $model->use_auto_subject;
		$updateTemplate->show_reject_button= $model->show_reject_button;
		$updateTemplate->show_link_to_object= $model->show_link_to_object;
		$updateTemplate->allow_custom_message= $model->allow_custom_message;
		$updateTemplate->body= $model->body;
		$updateTemplate->accept_button_text= $model->accept_button_text?$model->accept_button_text:'';
		$updateTemplate->reject_button_text= $model->reject_button_text?$model->reject_button_text:'';
		$updateTemplate->link_text= $model->link_text?$model->link_text:'';
		$updateTemplate->subject= $model->subject?$model->subject:'';

        if ($updateTemplate->save()) {
			Log::write('MessageTemplate', LogWhat::UPDATE, (string)$updateTemplateOld, (string)$updateTemplate);
            Yii::$app->session->setFlash("success", Yii::t("app", "Successful update"));
        } else {
			Yii::$app->session->setFlash("danger", Yii::t("app", "Failed to update") . "; ". serialize($updateTemplate->errors));
        }		
        return $this->redirect(['index','typeid'=>$model->message_type_id,'langid'=>$model->language_id]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param  integer $id The user id.
     * @return User The loaded model.
     *
     * @throws NotFoundHttpException if the model cannot be found.
     */
    protected function findModel($id)
    {
        $model = MessageTemplate::findOne($id);

        if (is_null($model)) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        } 

        return $model;
    }
}
