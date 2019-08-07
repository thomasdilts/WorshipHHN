<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\web;

use Yii;
use yii\web\Application;
use yii\helpers\Url;
use app\models\Language;

/**
 * Application is the base class for all web application classes.
 *
 * For more details and usage information on Application, see the [guide article on applications](guide:structure-applications).
 *
 * @property ErrorHandler $errorHandler The error handler application component. This property is read-only.
 * @property string $homeUrl The homepage URL.
 * @property Request $request The request component. This property is read-only.
 * @property Response $response The response component. This property is read-only.
 * @property Session $session The session component. This property is read-only.
 * @property User $user The user component. This property is read-only.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Application extends \yii\web\Application
{
    public function __construct($config) {
        parent::__construct($config);
    }
    public function beforeAction($action)
    {

        if (!parent::beforeAction($action)) {
            return false;
        }

        // your custom code here
        if(Yii::$app && Yii::$app->user && Yii::$app->user->identity){
            $language=Language::findOne(Yii::$app->user->identity->language_id);
            Yii::$app->language = $language->iso_name;
        }else{
            Yii::$app->language = 'sv-SE';
        }
        return true; // or false to not run the action
    }
}
