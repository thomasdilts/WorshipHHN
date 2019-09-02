<?php

namespace app\controllers;

use app\models\AllEventsExportFile;
use app\models\Log;
use app\models\LogWhat;
use app\models\User;
use app\models\File;
use app\models\Event;
use app\models\Team;
use app\models\MessageTemplate;
use app\models\EventExportFile;
use app\models\EventSearch;
use app\models\EventActivityUserSearch;
use app\models\EventActivitySearch;
use app\models\NotificationSearch;
use app\models\Notification;
use app\models\MessageTemplateSearch;

use app\models\SongSearch;
use app\models\EventTemplate;
use app\models\Activity;
use app\models\ActivityType;
use app\models\ActivitySearch;
use app\models\ActivityTypeSearch;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use Yii;

class EventController extends AppController
{
	/**
     * How many EventS we want to display per page.
     * @var int
     */
    protected $_pageSize = 30;

	public function actionExportexcel($id)
    {
    	$model = EventExportFile::findOne($id);
    	return $model->exportExcel();
	}	
	
	public function actionExportpdf($id)
    {
    	
    	$model = EventExportFile::findOne($id);
    	return $model->exportPdf();
	}	
	public function actionFilesup($id)
    {
    	Yii::info('incomming '.serialize($_FILES), 'actionFilesup');
    	$model = $this->findModel($id);
    	$imageFiles=$_FILES['imageFiles'];
    	if($imageFiles){
    		File::addFilesByAjax($model);
    	}
    	Yii::info('incomming '.serialize($imageFiles), 'actionFilesup');
        /*
        $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
    	Yii::info('imageFiles '.serialize($model->imageFiles), 'actionFilesup');
        if ($model->load(Yii::$app->request->post())) {
        	Yii::info('Got a post '.serialize($model->imageFiles), 'actionFilesup');
			File::addFiles($model);
        }	 */
        return '{}';
    }	
	public function actionFiles($id)
    {
    	$model = $this->findModel($id);

    	Yii::info('incomming '.$id. ' '.serialize($_FILES), 'actionFiles');
        
        if ($model->load(Yii::$app->request->post())) {
        	Yii::info('Got a post '.serialize($model->imageFiles), 'actionFiles');
			File::addFiles($model);
        }	
		return File::getFileSearch($model,$this->_pageSize,$this);	
    }
	public function actionFiledownload($id,$fileownerid)
    {
		return File::getFileDownload($id,$fileownerid,$this);		
	}	
	public function actionDeletefile($id,$fileownerid)
    {
		return File::deleteFile($id,$fileownerid,$this);	
	}		
    public function actionSelectsong($id,$activityid,$eventid)
    {
		$modelActivity = Activity::findOne($activityid);
		
		$modelActivity->song_id=$id;
		$modelActivity->save();

		return $this->redirect(['editactivity','id'=>$activityid,'eventid'=>$eventid,'returnurl'=>'activities%3Fid%3D'.$eventid]);
	}
	
	public function actionFileactivitydownload($id,$fileownerid, $eventid)
    {
		return File::getFileDownload($id,$fileownerid,$this);		
	}	
	public function actionDeleteactivityfile($id,$fileownerid, $eventid)
    {
		File::deleteFile($id,$fileownerid,$this);
		return $this->redirect(['editactivity','id'=>$fileownerid,'eventid'=>$eventid,'returnurl'=>'activities%3Fid%3D'.$eventid]);
	}	
	
    public function actionEditactivity($id,$eventid,$returnurl)
    {
        $modelEvent = $this->findModel($eventid);
		$modelActivity = Activity::findOne($id);
		$modelActivityOld= clone $modelActivity;
		$modelActivityType=ActivityType::findOne($modelActivity->activity_type_id);
		
        $searchModel = new SongSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 5);
		
		$arrayViewModel=File::getSearchArray($modelActivity, 11, 'fileSearchModel','fileDataProvider');
		$arrayViewModel['model']=$modelActivity;
		$arrayViewModel['modelEvent']=$modelEvent;
		$arrayViewModel['modelActivityType']=$modelActivityType;
		$arrayViewModel['searchModel']=$searchModel;
		$arrayViewModel['dataProvider']=$dataProvider;
		$arrayViewModel['returnurl']=$returnurl;

        if (!$modelActivity->load(Yii::$app->request->post())) {
            return $this->render('editactivity', $arrayViewModel);
        }		
        if ($modelActivity->save()) {
			Log::write('Activity', LogWhat::UPDATE, (string)$modelActivityOld, (string)$modelActivity);
            Yii::$app->session->setFlash("success", Yii::t("app", "Successful update"));
			File::addFiles($modelActivity);
			return $this->redirect([urldecode($returnurl)]);			
        } else {
			Yii::$app->session->setFlash("danger", Yii::t("app", "Failed to update"));
            return $this->render('editactivity', $arrayViewModel);
        }		
	}

	public function actionCopy($id)
    {
        return $this->redirect(['create', 'copyFromEventId'=>$id]);
	}
    public function actionCreate($copyFromEventId=null)
    {
        $model = new Event(['scenario' => 'create']);
		$model->church_id=Yii::$app->user->identity->church_id;
        if (!$model->load(Yii::$app->request->post())) {
			if($copyFromEventId){
				$modelToCopy = $this->findModel($copyFromEventId);

				$model = new Event(['scenario' => 'create']);
				$model->church_id=Yii::$app->user->identity->church_id;
				$model->description=$modelToCopy->description;
				$model->start_date=$modelToCopy->start_date;
				$model->end_date=$modelToCopy->end_date;
				$model->name=$modelToCopy->name;
				$model->copyFromEventId=$copyFromEventId;
				$model->copyAllPersonsTeams=0;
				$model->copyAllSongs=0;			
			}
            return $this->render('create', ['model'=>$model]);
        }
			
        if (!$model->save()) {
			Yii::$app->session->setFlash("danger", Yii::t("app", "Failed to create"));
            return $this->render('create', ['model'=>$model]);
        }
	
		if($copyFromEventId){
			$query = Activity::getAllActivities($copyFromEventId)->all();
			foreach($query as $activity){
				$newActivity = new Activity(['scenario' => 'create']);
				$newActivity->activity_type_id=$activity->activity_type_id;
				$newActivity->event_id=$model->id;		
				$newActivity->start_time=$activity->start_time;
				$newActivity->end_time=$activity->end_time;
				$newActivity->global_order=$activity->global_order;
				$newActivity->name=$activity->name;
				if($model->copyAllPersonsTeams){
					$newActivity->user_id=$activity->user_id;
					$newActivity->team_id=$activity->team_id;
				}
				if($model->copyAllSongs){
					$newActivity->song_id=$activity->song_id;
				}
				$newActivity->save();
			}			
		}
		
		Log::write('Event', LogWhat::CREATE, null, (string)$model);
		Yii::$app->session->setFlash('success', Yii::t('app', 'Successful create'));
        return $this->redirect('index');
    }
	
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$modelOld=clone $model;
        if (!$model->load(Yii::$app->request->post())) {
            return $this->render('update', ['model'=>$model]);
        }		
        if ($model->save()) {
			Log::write('Event', LogWhat::UPDATE, (string)$modelOld, (string)$model);
            Yii::$app->session->setFlash("success", Yii::t("app", "Successful update"));
            return $this->redirect(['index']);
        } else {
			Yii::$app->session->setFlash("danger", Yii::t("app", "Failed to update"));
            return $this->render('update', ['model'=>$model]);
        }		
    }
	
	private function getActivitiesToShow($model)
	{

        $searchModel = new ActivitySearch();
		$searchModel->event = $model;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $this->_pageSize);			
        $searchTypesModel = new ActivityTypeSearch();
        $dataTypesProvider = $searchTypesModel->search(Yii::$app->request->queryParams, $this->_pageSize);		
        return [
			'model' => $model, 
			'church_id' => Yii::$app->user->identity->church_id,
            'dataMembersProvider' =>$dataProvider,
            'searchTypesModel' => $searchTypesModel,
            'dataTypesProvider' => $dataTypesProvider,
			];			
	}

	public function actionDeletenotify($id, $eventid)
    {
    	try {
			$model=Notification::findOne($id);
			if (!$model->delete()) {
				throw new ServerErrorHttpException(Yii::t('app', 'Failed to delete'));
			}
		} catch (\yii\db\IntegrityException|Exception|Throwable  $e) {
			Yii::$app->session->setFlash('danger', Yii::t('app', 'Failed to delete. Object has dependencies that must be removed first.'). $e->getMessage());
			return $this->redirect(['notifications','id'=>$eventid]);
		}       
		Log::write('Notification', LogWhat::DELETE, (string)$model, null);
        Yii::$app->session->setFlash('success', Yii::t('app', 'Successful delete'));

    	return $this->redirect(['notifications','id'=>$eventid]);
	}
	public function actionSeenotify($id, $eventid)
    {
    	$model=Notification::findOne($id);
    	$activity=Activity::findOne($model->activity_id);
    	$event=Event::findOne($eventid);
    	$user=User::findOne($model->user_id);
    	$template=MessageTemplate::findOne($model->message_template_id);
    	$teamname= $model->team_id?Team::findOne($model->team_id)->name:'';
    	return $this->render('seenotify', ['model'=>$model, 'activity'=>$activity, 'event'=>$event, 'user'=>$user, 'teamname'=>$teamname, 'template'=>$template]);	
	}
	public function actionNotify($actionid, $userid, $eventid)
    {
    	$model = new Notification(['scenario' => 'create']);
        if ($model->load(Yii::$app->request->post())) {
        	Notification::sendNotifications($actionid, $userid, $eventid, $model);
            return $this->redirect(['notifications','id'=>$eventid]);
        }	

		return $this->render('notify', EventActivityUserSearch::getAllNotifyData($actionid, $userid, $eventid, $model));	    	
    }

	public function actionNotifications($id)
    {
		$model=Event::findOne(['id'=>$id]);

		$searchPersonsModel = new EventActivityUserSearch();
		$searchPersonsModel->event = $model;
        $dataPersonsProvider = $searchPersonsModel->search(Yii::$app->request->queryParams, $this->_pageSize);			
        $searchNotificationModel = new NotificationSearch();
        $searchNotificationModel->event = $model;
        $dataNotificationProvider = $searchNotificationModel->search(Yii::$app->request->queryParams, $this->_pageSize);		
		if (Yii::$app->request->post()) {
			//this is a request to refresh SMS notifications.
			foreach($dataNotificationProvider->query->all() as $notify){
				$notify->updateSmsNotificationStatus();
			}
			
        }			
        return $this->render('notifications', [
        	'userArray'=> $searchPersonsModel->getArray(),
			'model' => $model, 
			'church_id' => Yii::$app->user->identity->church_id,
            'searchPersonsModel' =>$searchPersonsModel,
            'dataPersonsProvider' =>$dataPersonsProvider,
            'searchNotificationModel' => $searchNotificationModel,
            'dataNotificationProvider' => $dataNotificationProvider,
			]);	
	}
	public function actionActivities($id)
    {
		$model=Event::findOne(['id'=>$id]);
		
        return $this->render('activities', $this->getActivitiesToShow($model));	
	}
	public function actionRemovefromevent($id,$eventid)
    {
		$model=Activity::findOne(['id'=>$id]);
		if (!$model->delete()) {
			Yii::$app->session->setFlash("danger", Yii::t("app", "Failed to delete"));
        }else{
			Log::write('Activity', LogWhat::DELETE, (string)$model, null);
			Yii::$app->session->setFlash('success', Yii::t('app', 'Successful delete'));
		}
		$model=Event::findOne(['id'=>$eventid]);
		
        return $this->redirect(['activities','id'=>$eventid]);	
	}

	public function actionAddtoevent($id,$eventid)
    {	
		$activityType=ActivityType::findOne(['id'=>$id]);
        $eventActivity = new Activity(['scenario' => 'create']);
		$eventActivity->activity_type_id=$id;
		$eventActivity->event_id=$eventid;
		
		$eventActivity->start_time=$activityType->default_start_time;
		$eventActivity->end_time=$activityType->default_end_time;
		$eventActivity->global_order=$activityType->default_global_order;
		$eventActivity->name=$activityType->name;
		
        if (!$eventActivity->save()) {
			Yii::$app->session->setFlash("danger", Yii::t("app", "Failed to add"));
        }else{
			Log::write('Activity', LogWhat::CREATE, null , (string)$eventActivity);
			return $this->redirect(['editactivity','id'=>$eventActivity->id,'eventid'=>$eventid,'returnurl'=>'activities%3Fid%3D'.$eventid]);
		}
		$model=Event::findOne(['id'=>$eventid]);
        return $this->redirect(['activities','id'=>$eventid]);
	}
	public function actionExportalltasksbyevent($start, $end)
    {
    	return AllEventsExportFile::exportExcel($start, $end);
	}
    public function actionAlltasksbyevent($start, $end)
    {
		$queries = AllEventsExportFile::getDataArray($start, $end);
		return $this->render('alltasksbyevent', [
            'start' => $start,
            'end' => $end,
            'columns' => $queries[1],
            'dataRows' => $queries[0],
            'start' => $start,
            'end' => $end,
        ]);
	}
    public function actionAlltasks($start, $end)
    {
		$searchModel = new EventActivitySearch();
		$searchModel->filter_start_date = $start;
		$searchModel->filter_end_date = $end;

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 50);

        return $this->render('alltasks', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }	
    public function actionIndex()
    {
		$searchModel = new EventSearch();

		$searchModel->filter_start_date = date('Y-m-d'); // get start date
		$searchModel->filter_end_date = date("Y-m-d", strtotime('+2 month'));

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $this->_pageSize);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDelete($id)
    {
		try {
			$model=$this->findModel($id);
			if (!$model->delete()) {
				throw new ServerErrorHttpException(Yii::t('app', 'Failed to delete'));
			}
		} catch (\yii\db\IntegrityException|Exception|Throwable  $e) {
			Yii::$app->session->setFlash('danger', Yii::t('app', 'Failed to delete. Object has dependencies that must be removed first.'). $e->getMessage());
			return $this->redirect(['index']);
		}       
		Log::write('Event', LogWhat::DELETE, (string)$model, null);
        Yii::$app->session->setFlash('success', Yii::t('app', 'Successful delete'));
        
        return $this->redirect(['index']);
    }
    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param  integer $id The user id.
     * @return User The loaded model.
     *
     * @throws NotFoundHttpException if the model cannot be found.
     */
    protected function findModel($id)
    {
        $model = Event::findOne($id);

        if (is_null($model)) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        } 

        return $model;
    }
}
