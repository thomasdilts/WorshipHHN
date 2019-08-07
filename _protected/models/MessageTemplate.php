<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "message_template".
 *
 * @property int $id
 * @property int $church_id
 * @property string $language_id
 * @property string $name
 * @property int $show_accept_button
 * @property int $show_reject_button
 * @property int $show_link_to_object
 * @property int $allow_custom_message
 * @property string $accept_button_text
 * @property string $reject_button_text
 * @property string $link_text
 * @property string $subject
 * @property string $body
 *
 * @property Church $church
 * @property Language $language
 */
class MessageTemplate extends \yii\db\ActiveRecord
{
    public $languagename;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'message_template';
    }
    
    public function scenarios() {
        $scenarios = parent::scenarios(); // This will cover you
        $scenarios['create'] = ['church_id', 'language_id', 'message_type_id','name', 'show_accept_button', 'use_auto_subject', 'show_reject_button', 'show_link_to_object', 'allow_custom_message', 'accept_button_text', 'reject_button_text', 'link_text', 'subject','body'];
        return $scenarios;
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['church_id', 'message_type_id','language_id', 'name', 'show_accept_button','use_auto_subject', 'show_reject_button', 'show_link_to_object', 'allow_custom_message','body',], 'required'],
            [['church_id', 'show_accept_button', 'show_reject_button', 'show_link_to_object', 'allow_custom_message','language_id','message_type_id'], 'integer'],
            [['body'], 'string'],
            [['name'], 'string', 'max' => 100],
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
            'name' => Yii::t('app', 'Name'),
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChurch()
    {
        return $this->hasOne(Church::className(), ['id' => 'church_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }
    public function getMessageType()
    {
        return $this->hasOne(MessageType::className(), ['id' => 'message_type_id']);
    }
    public static function getAllMessageTemplates($church_id)
    {
        return MessageTemplate::find()->where(['message_template.church_id'=>$church_id]);
    }

}
