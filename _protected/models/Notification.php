<?php

namespace app\models;
use yii\web\ServerErrorHttpException;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "team_user_notify".
 *
 * @property int $id
 * @property string $status
 * @property int $event_id
  * @property int $activity_id
 * @property int $user_id
 * @property string $notify_key
 * @property string $notified_date
 * @property string $notify_replied_date
 * @property string $reminded_date
 *
 * @property Activity $activity
 * @property TeamUser $teamUser
 */
class Notification extends \yii\db\ActiveRecord
{
    public $custom_message;
	public $send_from_address;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notification';
    }

    public function scenarios() {
        $scenarios = parent::scenarios(); // This will cover you
        $scenarios['create'] = ['message_template_id', 'custom_message','send_from_address'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'string'],
            [['activity_id','event_id'], 'required'],
            [['activity_id', 'event_id', 'user_id', 'team_id', 'message_template_id'], 'integer'],
            [['notified_date', 'notify_replied_date'], 'safe'],
            [['notify_key'], 'string', 'max' => 100],
            [['message_name'], 'string', 'max' => 200],
            [['message_html'], 'string'],
            [['activity_id'], 'exist', 'skipOnError' => true, 'targetClass' => Activity::className(), 'targetAttribute' => ['activity_id' => 'id']],
            [['event_id'], 'exist', 'skipOnError' => true, 'targetClass' => Event::className(), 'targetAttribute' => ['event_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['team_id'], 'exist', 'skipOnError' => true, 'targetClass' => Team::className(), 'targetAttribute' => ['team_id' => 'id']],
            [['message_template_id'], 'exist', 'skipOnError' => true, 'targetClass' => MessageTemplate::className(), 'targetAttribute' => ['message_template_id' => 'id']],
        ];
    }
	public function __toString()
    {
        try 
        {
            return (string) 'id='.$this->id.'; status='.$this->status.'; notified_date='.$this->notified_date.'; message_name='
				.$this->message_name.'; activity_id='.$this->activity_id.'; event_id='
				.$this->event_id.'; user_id='.$this->user_id
				.'sms_id='.$this->sms_id.'; sms_status_id='.$this->sms_status_id.'; sms_status='.$this->sms_status;
        } 
        catch (Exception $exception) 
        {
            return '';
        }
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'status' => Yii::t('app', 'Status'),
            'notified_date' => Yii::t('app', 'Notified Date'),
            'notify_replied_date' => Yii::t('app', 'Replied Date'),
            'message_name' => Yii::t('app', 'Message name'),
            'dates' => Yii::t('app', 'Notified Date / Replied Date'),
            'custom_message' => Yii::t('app', 'Custom Message'),
            'message_template_id' => Yii::t('app', 'Message Templates'),
            'sms_status' => Yii::t('app', 'SMS status'),
			'send_from_address' => Yii::t('app', 'Send SMS replies to me'),			
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivity()
    {
        return $this->hasOne(Activity::className(), ['id' => 'activity_id']);
    }
    public function getTeam()
    {
        return $this->hasOne(Team::className(), ['id' => 'team_id']);
    }
    public function getEvent()
    {
        return $this->hasOne(Event::className(), ['id' => 'event_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }    

    public function sendNotifications($actionid, $userid, $eventid, $model)
    {
        
        $event=Event::findOne($eventid);
        
        if($userid){
            Notification::sendNotificationForOne($actionid,$userid,$event,$model);
        }else{
            //send to everyone.in the event. 
            $search = new EventActivityUserSearch();
            $search->event=$event;
            $allUsers = $search->getArray();
            foreach($allUsers as $user){  
                $anyAlready= Notification::find()->where(['activity_id'=>$user['action_id'],'event_id'=>$eventid,'user_id'=>$user['user_id']])->all();
                if($anyAlready==null || count($anyAlready)==0){
                    Notification::sendNotificationForOne($user['action_id'],$user['user_id'],$event,$model);
                }
            }
        }
    } 
    public function sendNotificationForOne($actionid, $userid, $event, $model)
    {
        $templateTemp=MessageTemplate::findOne($model->message_template_id);
        $user=User::findOne($userid);
        // get the language for the user.
        $template = MessageTemplate::find()->where(['language_id'=>$user->language_id,'message_type_id'=>$templateTemp->message_type_id])->one();
        if(!$template){
            $template=$templateTemp;
        }
		if($template->message_system=='SMS' && !Yii::$app->has('SmsMessaging')){
			Yii::$app->session->setFlash("danger", Yii::t("app", "Failed to send the message."));
			return;
		}
		if($template->message_system=='SMS' && (!$user->mobilephone || strlen($user->mobilephone)==0)){
			Yii::$app->session->setFlash("danger", Yii::t("app", "Cannot send message because the user has no mobilephone number.") . ' ' . $user->display_name);
			return;
		}
		
        $hash=File::random_str(50);
        
        $activityname='';
        $activity=null;
        if($actionid){
            $activity=Activity::findOne($actionid);
            $activityname = $activity->name;
        }
		$linkHost = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 
				"https" : "http") . "://" . $_SERVER['HTTP_HOST'] . Yii::$app->request->baseUrl; 
		$htmlMessage='';
		$smsId='';
		$smsStatusId='';
		$smsStatusText='';
		if($template->message_system=='Email'){
			if($template->use_auto_subject){
				$subject = Html::encode($event->name . ' ' . Yii::$app->formatter->asDate($event->start_date, "Y-MM-dd H:mm") . ' ' . $activityname);
			}
			else{
				$subject = Html::encode($template->subject) ;
			}
			
			if($template->allow_custom_message){
				$htmlMessage.="<div  style='min-width:100%;' >".Notification::HtmlizeString($model->custom_message)."</div>\r\n";
				$htmlMessage.="<hr style='color:lightblue;background-color:lightblue;height:2px;margin:3px;' />\r\n";
			}

			$htmlMessage.=$template->body?"<p  style='width:100%;margin-bottom:30px;' >" . Notification::HtmlizeString($template->body) . "</p>\r\n":'';
			if($template->show_reject_button || $template->show_accept_button){
				$htmlMessage.="<div  style='min-width:100%;' >\r\n";
			}
			if($template->show_accept_button){
				$htmlMessage.="<div style='display:inline-block;margin-bottom:40px;white-space: nowrap'><a href='" . $linkHost . "/site/reply?type=accept&hash=".$hash . "' style='text-decoration: none;background-color:lightgreen;color:black;padding:10px;margin:5px;border-top: 2px solid #CCCCCC;border-right: 2px solid #333333;border-bottom: 2px solid #333333;border-left: 2px solid #CCCCCC;' >" . Html::encode($template->accept_button_text) . "</a></div>\r\n";
			}

			if($template->show_reject_button){
				$htmlMessage.="<div style='display:inline-block;margin-bottom:40px;white-space: nowrap'><a href='" . $linkHost . "/site/reply?type=reject&hash=".$hash ;
				$htmlMessage.="' style='text-decoration: none;background-color:lightpink;color:black;padding:10px;margin:5px;";
				$htmlMessage.="border-top: 2px solid #CCCCCC;border-right: 2px solid #333333;border-bottom: 2px solid #333333;border-left: 2px solid #CCCCCC;' >";
				$htmlMessage.=Html::encode($template->reject_button_text) . "</a></div>\r\n";
			}
			if($template->show_reject_button || $template->show_accept_button){
				$htmlMessage.="</div>\r\n";
			}
			if($template->show_link_to_object){
				$htmlMessage.="<a href='" . $linkHost . '/event/activities?id=' . $event->id  . "' style='background-color: #d2f5ff;color:blue;text-decoration:underline;width:100%'>" . Html::encode($template->link_text) . "</a>";
			}
			Yii::$app->mailer->compose()
				->setTo($user->email)
				->setFrom(Yii::$app->params['senderEmail'])
				->setSubject($subject)
				->setHtmlBody($htmlMessage)
				->send();
			Log::write('Notification', LogWhat::CREATE, 'email='.$user->email.'; subject='.$subject, 'template='.$template->name.'; custom_message='.$model->custom_message);
		}else{
			// SMS
			$htmlMessage=$template->body?$template->body:'';
			if($template->allow_custom_message && $model->custom_message && strlen($model->custom_message)>0){
				$htmlMessage.=strlen($htmlMessage)>0?"\r\n":'';
				$htmlMessage.=$model->custom_message;
			}			
			if($template->use_auto_subject){
				$htmlMessage.=strlen($htmlMessage)>0?"\r\n":'';
				$htmlMessage.= $event->name . ' ' . Yii::$app->formatter->asDate($event->start_date, "Y-MM-dd H:mm") . ' ' . $activityname;
			}
			if($template->show_link_to_object){
				$htmlMessage.=strlen($htmlMessage)>0?"\r\n":'';
				$htmlMessage.= $linkHost. '/event/activities?id=' . $event->id;
			}
			
			$smsResponse = Yii::$app->SmsMessaging->sendSms($htmlMessage, $user->mobilephone, $model->send_from_address?Yii::$app->user->identity->mobilephone:'');
			
			$smsId=$smsResponse['id'];
			$smsStatusId=$smsResponse['statusId'];
			$smsStatusText=$smsResponse['statusText'];
			Log::write('Notification', LogWhat::CREATE, 'SMS='.$user->mobilephone.'; smsId='.$smsId, 'template='.$template->name.'; custom_message='.$model->custom_message);
		}
        $newNotify= new Notification();

        $newNotify->sms_id=$smsId;
        $newNotify->sms_status_id=$smsStatusId;
        $newNotify->sms_status=$smsStatusText;
        $newNotify->status=$template->show_accept_button && $template->message_system!='SMS'?'Not replied yet':'No reply requested';
        $newNotify->activity_id=$actionid;
        $newNotify->event_id=$event->id;
        $newNotify->notify_key=($template->show_reject_button || $template->show_accept_button) && $template->message_system!='SMS'?$hash:null;;
        $newNotify->team_id=$activity?$activity->team_id:null;
        $newNotify->user_id=$userid;
        $newNotify->notified_date=date("Y-m-d H:i:s",time());
        $newNotify->message_name=$template->name;
        $newNotify->message_html=$htmlMessage;
        $newNotify->message_template_id=$template->id;

        $newNotify->save();
    } 
	public function updateSmsNotificationStatus()
    {	
		if($this->sms_id && strlen($this->sms_id)>0){
			$smsResponse = Yii::$app->SmsMessaging->getSmsStatus($this->sms_id, $this->sms_status_id, $this->sms_status);
			if($smsResponse['statusId']!=$this->sms_status_id || $smsResponse['statusText']!=$this->sms_status){
				$this->sms_status_id=$smsResponse['statusId'];
				$this->sms_status=$smsResponse['statusText'];
				$this->save();
			}
		}		
	}
    private function HtmlizeString($toHtmlize){
        $mess=str_replace("\r\n",'<br />',Html::encode($toHtmlize));
        return str_replace("\n",'<br />',$mess);
    }
    public static function notifyEventManger($notification, $subject,$user){
        $event=Event::findOne($notification->event_id);
        $activity=Activity::findOne($notification->activity_id);
        $toNotify = $event->getActivities()->joinWith('activityType')->where(['notify_user_event_errors'=>'1'])->all();
        if($toNotify && count($toNotify)>0){
            foreach($toNotify as $manageractivity){
                $manager=User::findOne($manageractivity->user_id);
                $language=Language::findOne($manager->language_id);
                Yii::$app->language = $language->iso_name;                
                $htmlMessage='';
                $htmlMessage.=$subject.'<br />';
                $htmlMessage.="<span style='font-weight:bold;'>".Yii::t('app', 'Event') .'</span>'. ': '. $event->name. ' ' . Yii::$app->formatter->asDate($event->start_date, "Y-MM-dd H:mm").'<br />';
                $htmlMessage.="<span style='font-weight:bold;'>".Yii::t('app', 'Activity') .'</span>' . ': '. $activity->name.'<br />';
                $htmlMessage.="<span style='font-weight:bold;'>".Yii::t('app', 'User') .'</span>' . ': '. $user->display_name.'<br />';
                Yii::$app->mailer->compose()
                    ->setTo($manager->email)
                    ->setFrom(Yii::$app->params['senderEmail'])
                    ->setSubject($subject)
                    ->setHtmlBody($htmlMessage)
                    ->send();
            }
        }

    }

    public static function rejectInternallyNotification($id){
        $notifications= Notification::find()->where(['activity_id'=>$id])->all();
        if($notifications && count($notifications)>0) {             
            $notify=null;                    
            $statuses = ArrayHelper::getColumn($notifications,'status');
            if(in_array('Accepted',$statuses)){
                $notify=Notification::find()->where(['activity_id'=>$id,'status'=>'Accepted'])->one();
                Yii::$app->session->setFlash('success', Yii::t('app', 'You have successfully rejected this task.'));
            }elseif(in_array('Not replied yet',$statuses)) {
                $notify=Notification::find()->where(['activity_id'=>$id,'status'=>'Not replied yet'])->one();
                Yii::$app->session->setFlash('success', Yii::t('app', 'You have successfully rejected this task.'));
            }elseif(in_array('Rejected',$statuses)) {
                Yii::$app->session->setFlash('error', Yii::t('app', 'This task is already rejected.'));
                return;
            }else{
                $notify=Notification::find()->where(['activity_id'=>$id])->one();
                Yii::$app->session->setFlash('success', Yii::t('app', 'You have successfully rejected this task.'));
            }
            // change the first notification found to being rejected
            $notify->status='Rejected';
            $notify->notify_replied_date=date("Y-m-d H:i:s",time());
            $notify->save();
			Log::write('Notification', LogWhat::TASK_REJECT, 'rejectInternallyNotification', (string)$notify);
            Notification::notifyEventManger($notify, 'An activity in your event has been rejected.',Yii::$app->user->identity);
            return; 
        }
        // got to create the notification
        $activity=Activity::findOne($id);
        $newNotify= new Notification();

        $newNotify->status='Rejected';
        $newNotify->activity_id=$id;
        $newNotify->event_id=$activity->event_id;
        $newNotify->team_id=$activity?$activity->team_id:null;
        $newNotify->user_id=$activity->user_id?$activity->user_id:Yii::$app->user->identity->id;
        $newNotify->notified_date=date("Y-m-d H:i:s",time());
        $newNotify->notify_replied_date=date("Y-m-d H:i:s",time());
        $newNotify->message_name=Yii::t('app', 'Rejected internally.');
        $newNotify->message_html=Yii::t('app', 'Rejected internally.');
        $newNotify->message_template_id=MessageTemplate::find()->one()->id;

        $newNotify->save();
		Log::write('Notification', LogWhat::TASK_REJECT, 'rejectInternallyNotification', (string)$newNotify);
        Notification::notifyEventManger($newNotify, 'An activity in your event has been rejected.',Yii::$app->user->identity);
        return;
    }

    public static function acceptInternallyNotification($id){
        $notifications= Notification::find()->where(['activity_id'=>$id])->all();
        if($notifications && count($notifications)>0) {             
            $notify=null;                    
            $statuses = ArrayHelper::getColumn($notifications,'status');
            if(in_array('Accepted',$statuses)){
                Yii::$app->session->setFlash('error', Yii::t('app', 'This task is already accepted.'));
                return;
            }elseif(in_array('Not replied yet',$statuses)) {
                $notify=Notification::find()->where(['activity_id'=>$id,'status'=>'Not replied yet'])->one();
                Yii::$app->session->setFlash('success', Yii::t('app', 'You have successfully accepted this task.'));
            }elseif(in_array('Rejected',$statuses)) {
                $notify=Notification::find()->where(['activity_id'=>$id,'status'=>'Rejected'])->one();
                Yii::$app->session->setFlash('success', Yii::t('app', 'You have successfully accepted this task.'));
                Notification::notifyEventManger($notify, 'An activity in your event has been changed from rejected to accepted.',Yii::$app->user->identity);
            }else{
                $notify=Notification::find()->where(['activity_id'=>$id])->one();
                Yii::$app->session->setFlash('success', Yii::t('app', 'You have successfully accepted this task.'));
            }
            
            $notify->status='Accepted';
            $notify->notify_replied_date=date("Y-m-d H:i:s",time());
            $notify->save();
			Log::write('Notification', LogWhat::TASK_ACCEPT, 'acceptInternallyNotification', (string)$notify);
            return; 
        }
        // got to create the notification
        $activity=Activity::findOne($id);
        $newNotify= new Notification();

        $newNotify->status='Accepted';
        $newNotify->activity_id=$id;
        $newNotify->event_id=$activity->event_id;
        $newNotify->team_id=$activity?$activity->team_id:null;
        $newNotify->user_id=$activity->user_id?$activity->user_id:Yii::$app->user->identity->id;
        $newNotify->notified_date=date("Y-m-d H:i:s",time());
        $newNotify->notify_replied_date=date("Y-m-d H:i:s",time());
        $newNotify->message_name=Yii::t('app', 'Accepted internally.');
        $newNotify->message_html=Yii::t('app', 'Accepted internally.');
        $newNotify->message_template_id=MessageTemplate::find()->one()->id;

        $newNotify->save();
		Log::write('Notification', LogWhat::TASK_ACCEPT, 'acceptInternallyNotification', (string)$newNotify);
        return;
    }    
}
