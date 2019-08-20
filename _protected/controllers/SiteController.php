<?php
namespace app\controllers;

use app\models\DocForm;
use app\models\User;
use app\models\Church;
use app\models\Language;
use app\models\Activity;
use app\models\Event;
use app\models\Notification;
use app\models\LoginForm;
use app\models\AccountActivation;
use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;
use app\models\SignupForm;
use app\models\ContactForm;
use yii\helpers\Html;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Yii;

/**
 * Site controller.
 * It is responsible for displaying static pages, logging users in and out,
 * sign up and account activation, and password reset.
 */
class SiteController extends Controller
{
    public function beforeAction($action)
    {
        // your custom code here, if you want the code to run before action filters,
        // which are triggered on the [[EVENT_BEFORE_ACTION]] event, e.g. PageCache or AccessControl

        if (!parent::beforeAction($action)) {
            return false;
        }

        // other custom code here
        if(Yii::$app && Yii::$app->user && Yii::$app->user->identity){
            $language=Language::findOne(Yii::$app->user->identity->language_id);
            Yii::$app->language = $language->iso_name;
        }
        return true; // or false to not run the action
    }
    /**
     * Returns a list of behaviors that this component should behave as.
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup', 'reply', 'forum'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?',],
                    ],
                    [
                        'actions' => ['reply'],
                        'allow' => true,
                        'roles' => ['?','TeamManager','ChurchAdmin','theCreator','EventManager','Member'],
                    ],
                    [
                        'actions' => ['forum'],
                        'allow' => true,
                        'roles' => ['?','TeamManager','ChurchAdmin','theCreator','EventManager','Member'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Declares external actions for the controller.
     *
     * @return array
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

//------------------------------------------------------------------------------------------------//
// STATIC PAGES
//------------------------------------------------------------------------------------------------//

    /**
     * Displays the index (home) page.
     * Use it in case your home page contains static content.
     *
     * @return string
     */
    public function actionHome($lang='')
    {
		$model = new DocForm();
		if (!$model->load(Yii::$app->request->post())) {
			if (Yii::$app->user->isGuest) {
				$model->language_iso_name=strlen($lang)>1?$lang:Yii::$app->language;
				if (strlen($lang)>1) {
					$model->language_iso_name=strlen($lang)>1?$lang:Yii::$app->language;
					Yii::$app->language = $model->language_iso_name;
				}
			}
			else{
				$language=Language::findOne(Yii::$app->user->identity->language_id);
				$model->language_iso_name=$language->iso_name;				
			}			
			
            return $this->render('home', ['model'=>$model ]);
        }
		Yii::$app->language = $model->language_iso_name;
		
		//we need to do a one time recursion here to put the lang on the url
		return $this->redirect(['home','lang'=>$model->language_iso_name]);
    }

    /**
     * Displays the about static page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
    public function actionForum()
    {
        return $this->render('forum');
    }
    /**
     * Displays the contact static page and sends the contact email.
     *
     * @return string|\yii\web\Response
     */
    public function actionContact($lang='')
    {
        $model = new ContactForm();
		if (strlen($lang)>1) {
			$model->language_iso_name=strlen($lang)>1?$lang:Yii::$app->language;
			Yii::$app->language = $model->language_iso_name;
		}
        if (!$model->load(Yii::$app->request->post()) || !$model->validate()) {
            return $this->render('contact', ['model' => $model]);
        }

        if (!$model->sendEmail(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('error', Yii::t('app', 'There was some error while sending email.'));
            return $this->refresh();
        }

        Yii::$app->session->setFlash('success', Yii::t('app', 
            'Thank you for contacting us. We will respond to you as soon as possible.'));
        
        return $this->refresh();
    }

//------------------------------------------------------------------------------------------------//
// LOG IN / LOG OUT / PASSWORD RESET
//------------------------------------------------------------------------------------------------//

    /**
     * Logs in the user if his account is activated,
     * if not, displays appropriate message.
     *
     * @return string|\yii\web\Response
     */
    public function actionLogin($lang='')
    {
        // user is logged in, he doesn't need to login
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        // get setting value for 'Login With Email'
        $lwe = Yii::$app->params['lwe'];

        // if 'lwe' value is 'true' we instantiate LoginForm in 'lwe' scenario
        $model = $lwe ? new LoginForm(['scenario' => 'lwe']) : new LoginForm();

        // monitor login status
        $successfulLogin = true;
		if (strlen($lang)>1) {
			$model->language_iso_name=strlen($lang)>1?$lang:Yii::$app->language;
			Yii::$app->language = $model->language_iso_name;
		}
        // posting data or login has failed
        if (!$model->load(Yii::$app->request->post()) || !$model->login()) {
            $successfulLogin = false;
        }

        // if user's account is not activated, he will have to activate it first
        if ($model->status === User::STATUS_INACTIVE && $successfulLogin === false) {
            Yii::$app->session->setFlash('error', Yii::t('app', 
                'You have to activate your account first. Please check your email.'));
            return $this->refresh();
        } 

        // if user is not denied because he is not active, then his credentials are not good
        if ($successfulLogin === false) {
            return $this->render('login', ['model' => $model]);
        }

        // login was successful, let user go wherever he previously wanted
        return $this->goBack();
    }

    /**
     * Logs out the user.
     *
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

/*----------------*
 * PASSWORD RESET *
 *----------------*/

    /**
     * Sends email that contains link for password reset action.
     *
     * @return string|\yii\web\Response
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();

        if (!$model->load(Yii::$app->request->post()) || !$model->validate()) {
            return $this->render('requestPasswordResetToken', ['model' => $model]);
        }

        if (!$model->sendEmail()) {
            Yii::$app->session->setFlash('error', Yii::t('app', 
                'Sorry, we are unable to reset password for email provided.'));
            return $this->refresh();
        }

        Yii::$app->session->setFlash('success', Yii::t('app', 'Check your email for further instructions.'));

        return $this->goHome();
    }

    /**
     * Resets password.
     *
     * @param  string $token Password reset token.
     * @return string|\yii\web\Response
     *
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if (!$model->load(Yii::$app->request->post()) || !$model->validate() || !$model->resetPassword()) {
            return $this->render('resetPassword', ['model' => $model]);
        }

        Yii::$app->session->setFlash('success', Yii::t('app', 'New password was saved.'));

        return $this->goHome();      
    }    


    public function actionReply($type, $hash)
    {  
        if(!$type || ($type!='accept' && $type!='reject')){
            return $this->render('reply', [
                'title' => Yii::t('app', 'Error'),
                'message' => Yii::t('app', 'You have accessed this page incorrectly'),
                'status' => '']); 
        }
        $message=Notification::findOne(['notify_key'=>$hash]);
        if(!$message){
            return $this->render('reply', [
                'title' => Yii::t('app', 'Error'),
                'message' => Yii::t('app', 'You have accessed this page incorrectly'),
                'status' => '']);  
        }

        $newMessageStatus = $type=='accept'?'Accepted':'Rejected';
        $oldMessageStatus = $message->status;
        $user=User::findOne($message->user_id);
        $language=Language::findOne($user->language_id);
        Yii::$app->language = $language->iso_name;

        if($newMessageStatus==$oldMessageStatus){
            return $this->render('reply', [
                'title' => Yii::t('app', 'Repeated reply'),
                'message' => Yii::t('app', 'You have already replied to this request. Thanks anyway. Bye!'), 
                'status' => Yii::t('app', $newMessageStatus)]);  
        }


        If($oldMessageStatus=='Not replied yet' || $newMessageStatus!=$oldMessageStatus){

            if($newMessageStatus=='Rejected'){
                // need to notify of rejection
                Notification::notifyEventManger($message, 'An activity in your event has been rejected.',$user);

            }else if($oldMessageStatus=='Rejected'){
                //must notify that they changed from rejected to accepted.
                Notification::notifyEventManger($message, 'An activity in your event has been changed from rejected to accepted.',$user);
            }
        }

        $message->status=$newMessageStatus;
        $message->notify_replied_date=date("Y-m-d H:i:s",time());
        $message->save();
        
        If($oldMessageStatus!='Not replied yet'){
            return $this->render('reply', [
                'title' => Yii::t('app', 'Repeated reply'),
                'message' => Yii::t('app', 'You have now changed the status of this request. Thank you. Bye!'),
                'status' => Yii::t('app', $newMessageStatus)]); 
        }
        return $this->render('reply', [
            'title' => Yii::t('app', 'Your reply is registered'),
            'message' => Yii::t('app', 'Thank you for replying to this request'),  
            'status' => Yii::t('app', $newMessageStatus)]);  

    }

//------------------------------------------------------------------------------------------------//
// SIGN UP / ACCOUNT ACTIVATION
//------------------------------------------------------------------------------------------------//

    /**
     * Signs up the user.
     * If user need to activate his account via email, we will display him
     * message with instructions and send him account activation email with link containing account activation token. 
     * If activation is not necessary, we will log him in right after sign up process is complete.
     * NOTE: You can decide whether or not activation is necessary, @see config/params.php
     *
     * @return string|\yii\web\Response
     */
    public function actionSignup($lang='')
    {  
        // get setting value for 'Registration Needs Activation'
        $rna = Yii::$app->params['rna'];

        // if 'rna' value is 'true', we instantiate SignupForm in 'rna' scenario
        $model = $rna ? new SignupForm(['scenario' => 'rna']) : new SignupForm();
		if (strlen($lang)>1) {
			$model->language_iso_name=strlen($lang)>1?$lang:Yii::$app->language;
			Yii::$app->language = $model->language_iso_name;
		}
        // if validation didn't pass, reload the form to show errors
        if (!$model->load(Yii::$app->request->post()) || !$model->validate()) {
            return $this->render('signup', ['model' => $model]);  
        }

        // try to save user data in database, if successful, the user object will be returned
        $user = $model->signup();

        if (!$user) {
            // display error message to user
            Yii::$app->session->setFlash('error', Yii::t('app', 'We couldn\'t sign you up, please contact us.'));
            return $this->refresh();
        }

        // user is saved but activation is needed, use signupWithActivation()
        if ($user->status === User::STATUS_INACTIVE) {
            $this->signupWithActivation($model, $user);
            return $this->refresh();
        }

        // now we will try to log user in
        // if login fails we will display error message, else just redirect to home page
    
        if (!Yii::$app->user->login($user)) {
            // display error message to user
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Please try to log in.'));

            // log this error, so we can debug possible problem easier.
            Yii::error('Login after sign up failed! User '.Html::encode($user->username).' could not log in.');
        }
                      
        return $this->goHome();
    }

    /**
     * Tries to send account activation email.
     *
     * @param $model
     * @param $user
     */
    private function signupWithActivation($model, $user)
    {
        // sending email has failed
        if (!$model->sendAccountActivationEmail($user)) {
            // display error message to user
            Yii::$app->session->setFlash('error', Yii::t('app', 
                'We couldn\'t send you account activation email, please contact us.'));

            // log this error, so we can debug possible problem easier.
            Yii::error('Signup failed! User '.Html::encode($user->username).' could not sign up. 
                Possible causes: verification email could not be sent.');
        }

        // everything is OK
        Yii::$app->session->setFlash('success', Yii::t('app', 'Hello').' '.Html::encode($user->username). '. ' .
            Yii::t('app', 'To be able to log in, you need to confirm your registration. Please check your email, we have sent you a message.'));
    }

/*--------------------*
 * ACCOUNT ACTIVATION *
 *--------------------*/

    /**
     * Activates the user account so he can log in into system.
     *
     * @param  string $token
     * @return \yii\web\Response
     *
     * @throws BadRequestHttpException
     */
    public function actionActivateAccount($token)
    {
        try {
            $user = new AccountActivation($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if (!$user->activateAccount()) {
            Yii::$app->session->setFlash('error', Html::encode($user->username). Yii::t('app', 
                'Your account could not be activated, please contact us!'));
            return $this->goHome();
        }

        Yii::$app->session->setFlash('success', Yii::t('app', 'Success!').' '. Html::encode($user->username) . '. ' .
            Yii::t('app', 'Thank you for joining us!'). ' ' . Yii::t('app', 'An email is now sent to the system administrator. They will notify you when you can log in.'));
		foreach(Church::getChurchAdminEmail($user->getChurchId()) as $admin){
			Yii::$app->mailer->compose()
				->setTo($admin)
				->setFrom(Yii::$app->params['senderEmail'])
				->setSubject('WorshipHHN' . ': ' . Yii::t('app', 'A user has requested access to your church planner'))
				->setHtmlBody(Yii::t('app', 'A user has requested access to your church planner') . '<br/><br/><br/>' 
					. $user->getDisplayName() . '<br/>' . $user->getEmail() . '<br/><br/>' . 
					Yii::t('app', 'Assign the user a role and then notify them that they can log in or not.'))
				->send();
		}
        return $this->goHome();
    }
}
