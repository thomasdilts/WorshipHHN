<?php
namespace app\controllers;

use app\models\User;
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
class DocController extends Controller
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
                'only' => ['doc'],
                'rules' => [
                    [
                        'actions' => ['doc'],
                        'allow' => true,
                        'roles' => ['?',],
                    ],
                    [
                        'actions' => ['doc'],
                        'allow' => true,
                        'roles' => ['?','TeamManager','ChurchAdmin','theCreator','EventManager','Member'],
                    ],
                    [
                        'actions' => ['doc'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['screenshot'],
                        'allow' => true,
                        'roles' => ['?',],
                    ],
                    [
                        'actions' => ['screenshot'],
                        'allow' => true,
                        'roles' => ['?','TeamManager','ChurchAdmin','theCreator','EventManager','Member'],
                    ],
                    [
                        'actions' => ['screenshot'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
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
    public function actionDoc($page,$returnName,$returnUrl)
    {
		Yii::info('actionDoc page='.$page,'DocController');
        return $this->render($page, ['returnName'=>$returnName,'returnUrl'=>$returnUrl]);
    }
	
	public function actionScreenshot($image,$returnName,$returnUrl)
    {
		Yii::info('actionScreenshot image='.$image,'DocController');
        return $this->render('screenshotviewer', ['image'=>$image,'returnName'=>$returnName,'returnUrl'=>$returnUrl]);
    }
}
