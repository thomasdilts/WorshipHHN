<?php
namespace app\models;

use yii\base\Model;
use Yii;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $reCaptcha;
	public $language_iso_name;

    /**
     * Returns the validation rules for attributes.
     *
     * @return array
     */
    public function rules()
    {
		if(Yii::$app->has('reCaptcha3') && strlen(Yii::$app->reCaptcha3->site_key) && strlen(Yii::$app->reCaptcha3->secret_key)){
			return [
				[['name', 'email', 'subject', 'body'], 'required'],
				['email', 'email'],
				[['reCaptcha'], \kekaadrenalin\recaptcha3\ReCaptchaValidator::className(), 'acceptance_score' => 0.5]
			];
		}else{
			return [
				[['name', 'email', 'subject', 'body'], 'required'],
				['email', 'email']
			];
		}
    }

    /**
     * Returns the attribute labels.
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'name'=> Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'Email'),
            'subject' => Yii::t('app', 'Subject'),
            'body' => Yii::t('app', 'Text'),
            'reCaptcha' => Yii::t('app', 'Verification Code'),
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param  string $email The target email address.
     * @return bool          Whether the email was sent.
     */
    public function sendEmail($email)
    {
		$recapthaValue=0;
		if(array_key_exists("lastCaptchaScore", $GLOBALS)){
			// this global must be put into the file kekaadrenalin\recaptcha3\ReCaptcha.php function validateValue() row 69 by you.
			// Otherwise the value will always be zero.
			// This is not an important function. Only a "nice to know" sort of thing.
			$recapthaValue=$GLOBALS["lastCaptchaScore"];
		}
        return Yii::$app->mailer->compose()
                                ->setTo($email)
                                ->setFrom($email)
                                ->setSubject($this->subject)
                                ->setTextBody('FROM: '.$this->name."\r\nEMAIL: ".$this->email. "\r\nreCaptcha Score:".$recapthaValue. "\r\nIP:".Yii::$app->request->getRemoteIP(). "\r\nBODY:\r\n".$this->body)
                                ->send();
    }
}
