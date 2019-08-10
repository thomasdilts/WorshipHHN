<?php
namespace app\models;

use app\rbac\helpers\RbacHelper;
use kartik\password\StrengthValidator;
use yii\base\Model;
use Yii;

/**
 * Model representing Signup Form.
 */
class MessageTypeForm extends Model
{
    public $language_id;
    public $church_id;
    public $message_type_id;
    public $type_name;
    public $message_name;
    public $show_accept_button;
    public $show_reject_button;
    public $show_link_to_object;
    public $allow_custom_message;
	public $accept_button_text;
	public $reject_button_text;
	public $link_text;
	public $use_auto_subject;
	public $subject;
	public $body;
    public $type_name_create;
    public $language_id_create;
	public $message_id;
	
	
	public function scenarios() {
		$scenarios = parent::scenarios(); // This will cover you
		$scenarios['create'] = ['use_auto_subject','message_id','type_name_create','language_id_create','body', 'subject', 'link_text','reject_button_text','accept_button_text','allow_custom_message','show_link_to_object','church_id','show_reject_button','show_accept_button','language_id','message_name','type_name','message_type_id'];
		return $scenarios;
	}

    public function rules()
    {
        return [
            [['body', ], 'safe'],
            [['accept_button_text', 'reject_button_text', 'link_text', 'subject'], 'string', 'max' => 200],
            [['church_id'], 'exist', 'skipOnError' => true, 'targetClass' => Church::className(), 'targetAttribute' => ['church_id' => 'id']],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['language_id' => 'id']],
            [['message_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => MessageType::className(), 'targetAttribute' => ['message_type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'language_id' => Yii::t('app', 'Language'),
            'message_type_id' => Yii::t('app', 'Message Type'),
            'type_name' => Yii::t('app', 'Message Type') . ' ' . Yii::t('app', 'Name'),
            'message_name' => Yii::t('app', 'Message Template') . ' ' . Yii::t('app', 'Name'),
            'show_accept_button' => Yii::t('app', 'Show Accept Button'),
            'show_reject_button' => Yii::t('app', 'Show Reject Button'),
            'show_link_to_object' => Yii::t('app', 'Show Link To Object'),
            'allow_custom_message' => Yii::t('app', 'Allow Custom Message'),
            'accept_button_text' => Yii::t('app', 'Accept Button Text'),
            'reject_button_text' => Yii::t('app', 'Reject Button Text'),
            'use_auto_subject' => Yii::t('app', 'Use an automatically created subject'),
            'link_text' => Yii::t('app', 'Link Text'),
            'subject' => Yii::t('app', 'Subject'),
            'body' => Yii::t('app', 'Body'),
            'type_name_create' => Yii::t('app', 'Message Type') . ' ' . Yii::t('app', 'Name'),
            'language_id_create' => Yii::t('app', 'Language'),
        ];
    }

}
