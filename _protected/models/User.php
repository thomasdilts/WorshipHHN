<?php
namespace app\models;

use app\rbac\models\Role;
use kartik\password\StrengthValidator;
use yii\behaviors\TimestampBehavior;
use Yii;

/**
 * This is the user model class extending UserIdentity.
 * Here you can implement your custom user solutions.
 * 
 * @property Role[] $role
 * @property Article[] $articles
 */
class User extends UserIdentity
{
    public $imageFiles;
    // the list of status values that can be stored in user table
    const STATUS_ACTIVE   = 10;
    const STATUS_INACTIVE = 1;
    const STATUS_DELETED  = 0;   
    public static function tableName()
    {
        return 'user';
    }
    /**
     * List of names for each status.
     * @var array
     */
    public $statusList = [
        self::STATUS_ACTIVE   => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
        self::STATUS_DELETED  => 'Deleted'
    ];

    /**
     * We made this property so we do not pull hashed password from db when updating
     * @var string
     */
    public $password;

    /**
     * @var \app\rbac\models\Role
     */
    public $item_name;
	
	public function scenarios() {
		$scenarios = parent::scenarios(); // This will cover you
		$scenarios['create'] = ['username','mobilephone', 'password', 'email','status','created_at','updated_at','item_name','church_id','display_name','admin','language_id','image','hide_user_icons'];
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
            ['username', 'unique', 
                'message' => Yii::t('app', 'This username has already been taken.')],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['mobilephone', 'string', 'max' => 50],
            [['church_id', 'email'], 'unique', 'targetAttribute' => ['church_id', 'email'],
                'message' => Yii::t('app', 'This email address has already been taken.')],
				

            // password field is required on 'create' scenario
            ['password', 'required', 'on' => 'create'],
            // use passwordStrengthRule() method to determine password strength
            $this->passwordStrengthRule(),

            ['hide_user_icons', 'required'],
            ['status', 'required'],
            [['church_id', 'language_id','display_name'], 'required'],
            ['display_name', 'string', 'min' => 4, 'max' => 100],
            [['language_id','hide_user_icons'], 'integer'],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['language_id' => 'id']],
            ['item_name', 'string', 'min' => 3, 'max' => 64]
        ];
    }

    /**
     * Set password rule based on our setting value (Force Strong Password).
     *
     * @return array Password strength rule.
     */
    private function passwordStrengthRule()
    {
        // get setting value for 'Force Strong Password'
        $fsp = Yii::$app->params['fsp'];

        // password strength rule is determined by StrengthValidator 
        // presets are located in: vendor/kartik-v/yii2-password/presets.php
        $strong = [['password'], StrengthValidator::className(), 'preset'=>'normal'];

        // normal yii rule
        $normal = ['password', 'string', 'min' => 6];

        // if 'Force Strong Password' is set to 'true' use $strong rule, else use $normal rule
        return ($fsp) ? $strong : $normal;
    }

    /**
     * Returns a list of behaviors that this component should behave as.
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
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
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'item_name' => Yii::t('app', 'Role'),
            'church_id' => Yii::t('app', 'Church'),
            'display_name' => Yii::t('app', 'Display name'),
            'admin' => Yii::t('app', 'Always Notify'),
            'language_id' => Yii::t('app', 'Language'), 
            'image' => Yii::t('app', 'Image'), 
            'hide_user_icons' => Yii::t('app', 'Hide user icons'), 
            'imageFiles' => Yii::t('app', 'Files'), 
            'mobilephone' => Yii::t('app', 'Mobilephone number'), 
        ];
    }
	public function __toString()
    {
        try 
        {
			$auth = Yii::$app->authManager;
			$role='';
			// get user role if he has one
			if ($roles = $auth->getRolesByUser($this->id)) {
				// it's enough for us the get first assigned role name
				$role = array_keys($roles)[0];
			}
            return (string) 'id='.$this->id.'; username='.$this->username.'; email='.$this->email.'; mobilephone='.$this->mobilephone
				.'; status='.$this->statusList[$this->status]
				.'; role='.$role.'; display_name='.$this->display_name.'; language_id='.$this->language_id
				.'; hide_user_icons='.$this->hide_user_icons;
        } 
        catch (Exception $exception) 
        {
            return '';
        }
    }
    /**
     * Relation with Role model.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        // User has_one Role via Role.user_id -> id
        return $this->hasOne(Role::className(), ['user_id' => 'id']);
    }

//------------------------------------------------------------------------------------------------//
// USER FINDERS
//------------------------------------------------------------------------------------------------//

    /**
     * Finds user by username.
     *
     * @param  string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }  
    
    /**
     * Finds user by email.
     *
     * @param  string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    } 

    /**
     * Finds user by password reset token.
     *
     * @param  string $token Password reset token.
     * @return null|static
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => User::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by account activation token.
     *
     * @param  string $token Account activation token.
     * @return static|null
     */
    public static function findByAccountActivationToken($token)
    {
        return static::findOne([
            'account_activation_token' => $token,
            'status' => User::STATUS_INACTIVE,
        ]);
    }
  
//------------------------------------------------------------------------------------------------//
// HELPERS
//------------------------------------------------------------------------------------------------//

    /**
     * Returns the user status in nice format.
     *
     * @param  integer $status Status integer value.
     * @return string          Nicely formatted status.
     */
    public function getStatusName($status)
    {
        return $this->statusList[$status];
    }

    /**
     * Returns the role name.
     * If user has any custom role associated with him we will return it's name, 
     * else we return 'member' to indicate that user is just a member of the site with no special roles.
     *
     * @return string
     */
    public function getRoleName()
    {
        // if user has some role assigned, return it's name
        if ($this->role) {
            return $this->role->item_name;
        }
        
        // user does not have role assigned, but if he is authenticated '@'
        return '@uthenticated';
    }

    /**
     * Generates new password reset token.
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }
    
    /**
     * Removes password reset token.
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Finds out if password reset token is valid.
     * 
     * @param  string $token Password reset token.
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * Generates new account activation token.
     */
    public function generateAccountActivationToken()
    {
        $this->account_activation_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes account activation token.
     */
    public function removeAccountActivationToken()
    {
        $this->account_activation_token = null;
    }
	
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }
	    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeamUser()
    {
        return $this->hasMany(TeamUser::className(), ['user_id' => 'id']);
    }
	public function getTeams()
	{
		return $this->hasMany(Team::className(), ['id' => 'team_id'])->viaTable("team_user", ['user_id' => 'id']);
	}
    public function IsUserBlocked($testDate)
    {
        $formatDate=Yii::$app->formatter->asDate($testDate, "Y-MM-dd H:mm");
        $blockedDates = $this->hasMany(UserBlocked::className(), ['user_id' => 'id'])
            ->andFilterWhere(['<=','start_date', $formatDate])
            ->andFilterWhere(['>=','end_date', $formatDate])->all();
        return $blockedDates != null && count($blockedDates)>0;
    }
    public function getThumbnail($id){
		$fileVault = substr(Yii::$app->params['fileVaultPath'],strlen(dirname(__DIR__,2)));
		Yii::info('$fileVault='.$fileVault,'getThumbnail');
        if(Yii::$app->user->identity->hide_user_icons){
            return '';
        }
        $file=File::findOne(['model'=>'user','itemId'=>$id]);
        if($file){
            return "<img src='". Yii::$app->request->baseUrl. $fileVault. DIRECTORY_SEPARATOR .$file->hash ."' class='profilephotothumbnail'>";
        }
        else{
            return "";
        }
    }
    public function getThumbnailMedium($id){
		$fileVault = substr(Yii::$app->params['fileVaultPath'],strlen(dirname(__DIR__,2)));
		Yii::info('$fileVault='.$fileVault,'getThumbnailMedium');
        if(Yii::$app->user->identity->hide_user_icons){
            return '';
        }
        $file=File::findOne(['model'=>'user','itemId'=>$id]);
        if($file){
            return "<img src='". Yii::$app->request->baseUrl. $fileVault. DIRECTORY_SEPARATOR .$file->hash ."' class='profilephotothumbnailmedium'>";
        }
        else{
            return "";
        }
        
    }
    public function getImage($id){
		$fileVault = substr(Yii::$app->params['fileVaultPath'],strlen(dirname(__DIR__,2)));
		Yii::info('$fileVault='.$fileVault,'getImage');
        $file=File::findOne(['model'=>'user','itemId'=>$id]);
        if($file){
            return "<img src='". Yii::$app->request->baseUrl. $fileVault. DIRECTORY_SEPARATOR .$file->hash ."' class='profilephotofullsize'>";
        }
        else{
            return "";
        }
        
    }

}
