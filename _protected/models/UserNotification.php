<?php

namespace app\models;
use yii\web\ServerErrorHttpException;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "user_notification".
 *
 * @property int $id
 * @property int $team_id
 * @property int $user_id
 * @property string $notified_date
 */
class UserNotification extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_notification';
    }

    public function scenarios() {
        $scenarios = parent::scenarios(); // This will cover you
        $scenarios['create'] = ['message_html','user_to_id'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sms_status'], 'string', 'max' => 400],
            [['sms_status_id','sms_status_id'], 'string', 'max' => 200],
            [['user_from_id','user_to_id'], 'required'],
            [['user_from_id', 'user_to_id', 'team_id'], 'integer'],
            [['notified_date'], 'safe'],
            [['message_html'], 'string'],
            [['user_from_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_from_id' => 'id']],
            [['user_to_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_to_id' => 'id']],
            [['team_id'], 'exist', 'skipOnError' => true, 'targetClass' => Team::className(), 'targetAttribute' => ['team_id' => 'id']],
        ];
    }
	public function __toString()
    {
        try 
        {
            return (string) 'id='.$this->id.'; notified_date='.$this->notified_date.'; message_html='.$this->message_html.
				'; user_to_id='.$this->user_to_id.'; user_from_id='.$this->user_from_id.'; team_id='.$this->team_id
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
            'notified_date' => Yii::t('app', 'Notified Date'),
            'to' => Yii::t('app', 'To'),
            'sms_status' => Yii::t('app', 'SMS status'),
			'from' => Yii::t('app', 'From'),	
			'message_html' => Yii::t('app', 'Custom Message'),			
        ];
    }

    public function getTeam()
    {
        return $this->hasOne(Team::className(), ['id' => 'team_id']);
    }
	public function getUserFrom() {

        return $this->hasOne(User::className(), ['id' => 'user_from_id']);

    }
	public function getUserTo() {

        return $this->hasOne(User::className(), ['id' => 'user_to_id']);

    }
    public function sendSMSForMany($userIds, $team_id, $message)
    {
		$user_ids=explode(".",$userIds);
		foreach($user_ids as $userId){
			UserNotification::sendSMSForOne($userId, $team_id, $message);
		}
	}
    public function sendSMSForOne($user_to_id, $team_id, $message)
    {
		$smsId='';
		$smsStatusId='';
		$smsStatusText='';
		// SMS
		$userTo = User::findOne($user_to_id);
		if(!$userTo->mobilephone || strlen($userTo->mobilephone)<4){
			Yii::$app->session->setFlash('danger', Yii::t('app', 'Failed to create' ) . '. ' .$userTo->display_name);
			return;
		}
		
		$smsResponse = Yii::$app->SmsMessaging->sendSms($message, $userTo->mobilephone, Yii::$app->user->identity->mobilephone);
		
		$smsId=(string)$smsResponse['id'];
		$smsStatusId=(string)$smsResponse['statusId'];
		$smsStatusText=(string)$smsResponse['statusText'];
		Log::write('UserNotification', LogWhat::CREATE, 'SMS='.$userTo->mobilephone.'; smsId='.$smsId, 'display_name='.$userTo->display_name.'; custom_message='.$message);
		
        $newNotify= new UserNotification();

        $newNotify->sms_id=$smsId;
        $newNotify->sms_status_id=$smsStatusId;
        $newNotify->sms_status=$smsStatusText;
        $newNotify->team_id=$team_id;
        $newNotify->user_from_id=Yii::$app->user->identity->id;
        $newNotify->user_to_id=$user_to_id;
        $newNotify->notified_date=date("Y-m-d H:i:s",time());
        $newNotify->message_html=$message;

        $newNotify->save();
    } 
	public function updateSmsNotificationStatus()
    {	
		if($this->sms_id && strlen($this->sms_id)>0){
			$smsResponse = Yii::$app->SmsMessaging->getSmsStatus($this->sms_id, $this->sms_status_id, $this->sms_status);
			if((string)$smsResponse['statusId']!=$this->sms_status_id || (string)$smsResponse['statusText']!=$this->sms_status){
				$this->sms_status_id=(string)$smsResponse['statusId'];
				$this->sms_status=(string)$smsResponse['statusText'];
				$this->save();
			}
		}		
	}
	
}
