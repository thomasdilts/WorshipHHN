<?php
namespace app\models;

use app\rbac\helpers\RbacHelper;
use kartik\password\StrengthValidator;
use yii\base\Model;
use Yii;

/**
 * Model representing Signup Form.
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $status;
    public $church_id;
    public $display_name;
	public $language_iso_name;
	
	public function scenarios() {
		$scenarios = parent::scenarios(); // This will cover you
		$scenarios['create'] = ['username', 'password', 'email','status','created_at','updated_at','item_name','church_id','display_name','admin','language_id','image','hide_user_icons'];
		return $scenarios;
	}

    /**
     * Returns the validation rules for attributes.
     *
     * @return array
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['username', 'match',  'not' => true,
                // we do not want to allow users to pick one of spam/bad usernames 
                'pattern' => '/\b('.Yii::$app->params['user.spamNames'].')\b/i',
                'message' => Yii::t('app', 'It\'s impossible to have that username.')],            
            ['username', 'unique', 'targetClass' => '\app\models\User', 
                'message' => Yii::t('app', 'This username has already been taken.')],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 
                'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['church_id', 'required'],
            ['display_name', 'string', 'min' => 4, 'max' => 100],
			['display_name', 'filter', 'filter' => 'trim'],
            ['display_name', 'required'],
            // use passwordStrengthRule() method to determine password strength
            $this->passwordStrengthRule(),

            // on default scenario, user status is set to active
            ['status', 'default', 'value' => User::STATUS_ACTIVE, 'on' => 'default'],
            // status is set to not active on rna (registration needs activation) scenario
            ['status', 'default', 'value' => User::STATUS_INACTIVE, 'on' => 'rna'],
            // status has to be integer value in the given range. Check User model.
            ['status', 'in', 'range' => [User::STATUS_INACTIVE, User::STATUS_ACTIVE]]
        ];
    }

    /**
     * Set password rule based on our setting value ( Force Strong Password ).
     *
     * @return array Password strength rule
     */
    private function passwordStrengthRule()
    {
        // get setting value for 'Force Strong Password'
        $fsp = Yii::$app->params['fsp'];

        // password strength rule is determined by StrengthValidator 
        // presets are located in: vendor/kartik-v/yii2-password/presets.php
        $strong = [['password'], StrengthValidator::className(), 'preset'=>'normal'];

        // use normal yii rule
        $normal = ['password', 'string', 'min' => 6];

        // if 'Force Strong Password' is set to 'true' use $strong rule, else use $normal rule
        return ($fsp) ? $strong : $normal;
    }    

    /**
     * Returns the attribute labels.
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'email' => Yii::t('app', 'Email'),
            'display_name' => Yii::t('app', 'Display name'),
            'church_id' => Yii::t('app', 'Church'),
        ];
    }

    /**
     * Signs up the user.
     * If scenario is set to "rna" (registration needs activation), this means
     * that user need to activate his account using email confirmation method.
     *
     * @return User|null The saved model or null if saving fails.
     */
    public function signup()
    {
        //$user = new User();
		$user = new User(['scenario' => 'create']);
        $user->username = $this->username;
        $user->email = $this->email;
		$user->password=$this->password;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->status = $this->status;
		$user->church_id = $this->church_id;
		$user->display_name = $this->display_name;
		$user->hide_user_icons=0;
		$language=Language::find()->where(['iso_name'=>Yii::$app->language])->one();
		$user->language_id=$language->id;
		//Yii::info('user validate='.$user->validate(). ' ' . $this->password . ' ' . serialize($user->errors),'signup');

        // if scenario is "rna" ( Registration Needs Activation ) we will generate account activation token
        if ($this->scenario === 'rna') {
            $user->generateAccountActivationToken();
        }

        // if user is saved and role is assigned return user object
        return $user->save() && RbacHelper::assignRole($user->getId()) ? $user : null;
    }

    /**
     * Sends email to registered user with account activation link.
     *
     * @param  object $user Registered user.
     * @return bool         Whether the message has been sent successfully.
     */
    public function sendAccountActivationEmail($user)
    {
        return Yii::$app->mailer->compose('accountActivationToken', ['user' => $user])
                                ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->name . ' robot'])
                                ->setTo($this->email)
                                ->setSubject(Yii::t('app', 'Account activation for :') . Yii::$app->name)
                                ->send();
    }
}
