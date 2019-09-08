<?php
namespace app\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii;
use app\models\Language;

/**
 * AppController extends Controller and implements the behaviors() method
 * where you can specify the access control ( AC filter + RBAC ) for your controllers and their actions.
 */
class AppController extends Controller
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
     * Here we use RBAC in combination with AccessControl filter.
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'controllers' => ['church'],
                        'actions' => ['index', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['theCreator'],
                    ],
                    [
                        'controllers' => ['church'],
                        'actions' =>  ['update'],
                        'allow' => true,
                        'roles' => ['ChurchAdmin'],
                    ],
                    [
                        'controllers' => ['team-type','language','log'],
                        'actions' => ['index', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['ChurchAdmin','theCreator'],
                    ],					
                    [
                        'controllers' => ['user','team-type','activity-type','event-template','message-template','message-type'],
                        'actions' => ['index', 'create','deletemessage','deletetype','createtype','createmessage', 'update', 'delete', 'view', 'addtotemplate','activities', 'removefromtemplate','fileuploadadmin','filedeleteadmin',],
                        'allow' => true,
                        'roles' => ['ChurchAdmin','theCreator'],
					],
                    [
                        'controllers' => ['event'],
                        'actions' => ['downtime','uptime','moveup','movedown','deleteactivityfile','exportalltasksbyevent','alltasksbyevent','fileactivitydownload','alltasks','index', 'create', 'update', 'delete','removefromevent','addtoevent','activities','files', 'filedownload', 'deletefile','editactivity','selectsong', 'copy', 'notifications', 'exportexcel', 'exportpdf', 'notify', 'seenotify', 'deletenotify'],
                        'allow' => true,
                        'roles' => ['EventManager','ChurchAdmin','theCreator'],
					],
                    [
                        'controllers' => ['event'],
                        'actions' => ['downtime','uptime','moveup','movedown','deleteactivityfile','fileactivitydownload','exportalltasksbyevent','alltasksbyevent','alltasks','index', 'removefromevent','addtoevent','activities','files', 'filedownload', 'deletefile','editactivity','selectsong', 'notifications', 'exportexcel', 'exportpdf', 'seenotify'],
                        'allow' => true,
                        'roles' => ['TeamManager','EventEditor'],
                    ],
                    [
                        'controllers' => ['event'],
                        'actions' => ['exportalltasksbyevent','alltasksbyevent','fileactivitydownload','filesup','alltasks','index', 'activities','files', 'filedownload', 'deletefile', 'notifications', 'exportexcel', 'exportpdf', 'seenotify'],
                        'allow' => true,
                        'roles' => ['Member'],
                    ],
                    [
                        'controllers' => ['team'],
                        'actions' => ['index', 'update', 'view', 'players', 'addtoteam', 'removefromteam','playersadmin','files', 'filedownload', 'deletefile', 'unavailability', 'unavailabilitycreate', 'unavailabilitydelete', 'unavailabilityupdate', 'tasks', 'taskreject','taskaccept', 'taskexportpdf', 'taskexportexcel', 'taskexportics'],
                        'allow' => true,
                        'roles' => ['TeamManager','ChurchAdmin','theCreator','EventManager'],
					],
                    [
                        'controllers' => ['team'],
                        'actions' => ['create', 'delete'],
                        'allow' => true,
                        'roles' => ['ChurchAdmin','theCreator'],
					],					
                    [
                        'controllers' => ['team','user-blocked'],
                        'actions' => ['index', 'filedownload','files', 'players', 'deletefile', 'unavailability','tasks', 'taskexportpdf', 'taskexportexcel', 'taskexportics'],
                        'allow' => true,
                        'roles' => ['Member','EventEditor'],
					],	
                    [
                        'controllers' => ['song'],
                        'actions' => ['index', 'create', 'delete', 'update','songimportopenlp', 'songimportcsv', 'songexportcsv' ],
                        'allow' => true,
                        'roles' => ['TeamManager','ChurchAdmin','theCreator','EventManager','EventEditor',],
					],					
                    [
                        'controllers' => ['user-blocked'],
                        'actions' => ['index', 'create','update','delete'],
                        'allow' => true,
                        'roles' => ['TeamManager','ChurchAdmin','theCreator','EventManager','Member','EventEditor'],
                    ],  
                    [
                        'controllers' => ['user-blocked'],
                        'actions' => ['index', 'create','update','delete'],
                        'allow' => true,
                        'roles' => ['TeamManager','ChurchAdmin','theCreator','EventManager','Member','EventEditor'],
                    ],  
                    [
                        'controllers' => ['user'],
                        'actions' => ['viewme','fileupload','filedelete','updateme','tasks','taskreject','taskaccept', 'taskexportpdf', 'taskexportexcel', 'taskexportics'],
                        'allow' => true,
                        'roles' => ['TeamManager','ChurchAdmin','theCreator','EventManager','Member','EventEditor'],
                    ],  
                ], // rules

            ], // access
/*
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ], // verbs
			*/

        ]; // return

    } // behaviors

} // AppController
