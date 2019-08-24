<?php

namespace app\controllers;

use app\models\Log;
use app\models\LogSearch;
use app\models\Church;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii;

class LogController extends AppController
{
	/**
     * How many Logs we want to display per page.
     * @var int
     */
    protected $_pageSize = 100;

    public function actionIndex()
    {
        $searchModel = new LogSearch();
		$church= Church::findOne(Yii::$app
            ->user
            ->identity
            ->church_id);	
		
		$searchModel->filter_start_date = LogSearch::date_convert(gmdate('Y-m-d H:i:s', strtotime('-1 week')),'UTC' , 'Y-m-d H:i:s',$church->time_zone , 'Y-m-d H:i:s');
		$searchModel->filter_end_date = LogSearch::date_convert(gmdate('Y-m-d H:i:s', strtotime('+1 day')),'UTC' , 'Y-m-d H:i:s',$church->time_zone , 'Y-m-d H:i:s');
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $this->_pageSize);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}

