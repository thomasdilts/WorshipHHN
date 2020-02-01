<?php

namespace app\controllers;

use app\models\AllEventsExportFile;
use app\models\Log;

use app\models\LogWhat;
use app\models\User;
use app\models\File;
use app\models\Event;
use app\models\Team;
use app\models\PictureActivity;
use app\models\PictureActivitySearch;
use app\models\PictureSearch;
use app\models\MessageTemplate;
use app\models\EventExportFile;
use app\models\EventSearch;
use app\models\EventActivityUserSearch;
use app\models\EventActivitySearch;
use app\models\NotificationSearch;
use app\models\Notification;
use app\models\MessageTemplateSearch;
use app\models\UserNotification;
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
    protected $_pageSize = 1000;

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
	
	public function actionAddpicture($id,$activityid,$eventid)
    {
		$modelActivity = Activity::findOne($activityid);
		
		$model = new PictureActivity(['scenario' => 'create']);
		$model->picture_id=$id;
		$model->activity_id=$activityid;
		$model->save();		

		return $this->redirect(['editactivity','id'=>$activityid,'eventid'=>$eventid,'returnurl'=>'activities%3Fid%3D'.$eventid]);
	}
	public function actionDeletepicture($id,$activityid,$eventid)
    {
		$modelActivity = Activity::findOne($activityid);
		PictureActivity::DeleteAll(['activity_id'=>$activityid,'picture_id'=>$id]);

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
	private function getDuration($model,$event,$modelActivityType){
		if($modelActivityType->use_globally){
			return 1;
		}
		$searchModel = new ActivitySearch();
		$searchModel->event = $event;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $this->_pageSize);
		
        if (($sort = $dataProvider->getSort()) !== false) {
            $dataProvider->query->addOrderBy($sort->getOrders());
        }	

		$dataByRows=$dataProvider->query->all();
		$foundPreviousRow=null;
		$collection = new \CachingIterator(
                  new \ArrayIterator($dataByRows));		
        foreach ($collection as $row)
        {
			if($row->id==$model->id){
				$duration = $collection->hasNext() ? $this->minutesDiff($row->start_time,$collection->getInnerIterator()->current()->start_time) : 1;
				return $duration>0 ? $duration : 1;
			}
		}
		return 1;
	}	
	private function getEditActivityModelArray($modelEvent,$modelActivityType,$modelActivity,$returnurl){
        $searchModel = new SongSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 5);
		
		$arrayViewModel=File::getSearchArray($modelActivity, 11, 'fileSearchModel','fileDataProvider');
		$arrayViewModel['model']=$modelActivity;
		$arrayViewModel['modelEvent']=$modelEvent;
		$arrayViewModel['modelActivityType']=$modelActivityType;
		$arrayViewModel['searchModel']=$searchModel;
		$arrayViewModel['dataProvider']=$dataProvider;
		$arrayViewModel['returnurl']=$returnurl;
				
		$pictureSearchModel = new PictureActivitySearch();
		$pictureSearchModel->activity_id=$modelActivity->id;
		$pictureDataProvider = $pictureSearchModel->search(Yii::$app->request->queryParams, 10);			
		$allPictureSearchModel = new PictureSearch();
		$allPictureDataProvider = $allPictureSearchModel->search(Yii::$app->request->queryParams, 10);			
		$arrayViewModel['pictureSearchModel']=$pictureSearchModel;
		$arrayViewModel['pictureDataProvider']=$pictureDataProvider;
		$arrayViewModel['allPictureSearchModel']=$allPictureSearchModel;
		$arrayViewModel['allPictureDataProvider']=$allPictureDataProvider;		
			
		return $arrayViewModel;
	}
    public function actionEditactivity($id,$eventid,$returnurl)
    {
        $modelEvent = $this->findModel($eventid);
		$modelActivity = Activity::findOne($id);
		$modelActivityType=ActivityType::findOne($modelActivity->activity_type_id);
		$modelActivity->duration = $this->getDuration($modelActivity,$modelEvent,$modelActivityType);
		$modelActivityOld= clone $modelActivity;
		
		$arrayViewModel = $this->getEditActivityModelArray($modelEvent,$modelActivityType,$modelActivity,$returnurl);

        if (!$modelActivity->load(Yii::$app->request->post())) {
			// adjust the start_time or else it looks funny in the screen
			$modelActivity->start_time=substr($modelActivity->start_time,0,5);
            return $this->render('editactivity', $arrayViewModel);
        }		
		if($modelActivityType->use_globally){
			$modelActivity->duration=1;
			$modelActivity->start_time='00:00:01';
		}	

        if ($modelActivity->save()) {
			if(!$modelActivityType->use_globally){
				$duration=$this->getDuration($modelActivity,$modelEvent,$modelActivityType);
				if($modelActivity->duration!= $duration){
					$this->changeDuration($eventid,$id,$modelActivity->duration - $duration );
				}
			}
			Log::write('Activity', LogWhat::UPDATE, (string)$modelActivityOld, (string)$modelActivity);
			File::addFiles($modelActivity);
            Yii::$app->session->setFlash("success", Yii::t("app", "Successful update"));
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
				$model->copy_persons_teams=0;
				$model->copy_all_songs=0;			
				$model->number_weeks_repeat=1;			
			}
            return $this->render('create', ['model'=>$model]);
        }
			
		if($copyFromEventId){
			$query = Activity::getAllActivities($copyFromEventId)->all();
			$modelToSave=$model;
			for($i=0;$i<$model->number_weeks_repeat;$i++){
				if ($modelToSave->save()) {
					foreach($query as $activity){
						$newActivity = new Activity(['scenario' => 'create']);
						$newActivity->activity_type_id=$activity->activity_type_id;
						$newActivity->event_id=$modelToSave->id;		
						$newActivity->start_time=$activity->start_time;
						$newActivity->end_time=$activity->end_time;
						$newActivity->global_order=$activity->global_order;
						$newActivity->name=$activity->name;
						if($model->copy_persons_teams){
							$newActivity->user_id=$activity->user_id;
							$newActivity->team_id=$activity->team_id;
						}
						if($model->copy_all_songs){
							$newActivity->song_id=$activity->song_id;
						}
						$newActivity->save();
					}
					$lastModel=$modelToSave;
					Log::write('Event', LogWhat::CREATE, null, (string)$modelToSave);
					$modelToSave=new Event(['scenario' => 'create']);
					$modelToSave->church_id=Yii::$app->user->identity->church_id;				
					$modelToSave->name=$lastModel->name;					
					$modelToSave->description=$lastModel->description;
					$modelToSave->start_date=date('Y-m-d H:i:s', strtotime($lastModel->start_date. ' + 7 days'))	;
					$modelToSave->end_date=date('Y-m-d H:i:s', strtotime($lastModel->end_date. ' + 7 days'))		;
				}				
			}
		}
		else if (!$model->save()) {
			Yii::$app->session->setFlash("danger", Yii::t("app", "Failed to create"));
            return $this->render('create', ['model'=>$model]);
        }else{
			Log::write('Event', LogWhat::CREATE, null, (string)$model);
		}
		
		Yii::$app->session->setFlash('success', Yii::t('app', 'Successful create'));
        return $this->redirect('index');
    }
	private function addTime($time, $minutesToAdd){
		$split = explode ( ':' , $time);
		$minutes= (int)$split[0]*60 + (int)$split[1];
		$minutes+=$minutesToAdd;
		$hours = (int)($minutes/60);
		return sprintf('%02d', $hours) . ':' . sprintf('%02d', ($minutes % 60));
	}
	private function minutesDiff($timeStart, $timeFinish){
		$split = explode ( ':' , $timeStart);
		$minutesStart= (int)$split[0]*60 + (int)$split[1];
		$split = explode ( ':' , $timeFinish);
		$minutesFinish= (int)$split[0]*60 + (int)$split[1];
		return $minutesFinish - $minutesStart;
	}	
	private function changeDuration($eventid,$activityid,$minutesToAdd){
		$model = $this->findModel($eventid);
		$searchModel = new ActivitySearch();
		$searchModel->event = $model;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $this->_pageSize);
		
        if (($sort = $dataProvider->getSort()) !== false) {
            $dataProvider->query->addOrderBy($sort->getOrders());
        }	

		$dataByRows=$dataProvider->query->all();
		$foundActivity=false;
		$foundActTime='';
        foreach ($dataByRows as $row)
        {
			if($foundActivity){
				$row->start_time=$this->addTime($row->start_time, $minutesToAdd);
				if($foundActTime>=$row->start_time){
					break;
				}
				$row->save();
			}
			if($row->id==$activityid){
				$foundActivity=true;
				$foundActTime=$this->addTime($row->start_time, 0);
			}
		}				
	}
    public function actionUptime($eventid,$activityid)
    {
		$this->changeDuration($eventid,$activityid,1);
		return $this->redirect(['activities','id'=>$eventid,'activityid'=>$activityid]);	
	}
    public function actionDowntime($eventid,$activityid)
    {
		$this->changeDuration($eventid,$activityid,-1);
		return $this->redirect(['activities','id'=>$eventid,'activityid'=>$activityid]);			
	}	
    public function actionMoveup($eventid,$id)
    {
		$model = $this->findModel($eventid);
		$searchModel = new ActivitySearch();
		$searchModel->event = $model;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $this->_pageSize);
		
        if (($sort = $dataProvider->getSort()) !== false) {
            $dataProvider->query->addOrderBy($sort->getOrders());
        }	

		$dataByRows=$dataProvider->query->all();
		$foundPreviousRow=null;
		$collection = new \CachingIterator(
                  new \ArrayIterator($dataByRows));		
        foreach ($collection as $row)
        {
			if($row->id==$id && $foundPreviousRow!=null){
				if($foundPreviousRow!=null){
					$durationThis=$collection->hasNext()?$this->minutesDiff($row->start_time,$collection->getInnerIterator()->current()->start_time):1;
					$row->start_time=$foundPreviousRow->start_time;
					$foundPreviousRow->start_time = $this->addTime($foundPreviousRow->start_time, $durationThis);
					$row->save();
					$foundPreviousRow->save();
				}
				break;
			}
			if(!$row->activityType->use_globally){
				$foundPreviousRow=$row;
			}
		}			

		return $this->redirect(['activities','id'=>$eventid,'activityid'=>$id]);		
	}
    public function actionMovedown($eventid,$id)
    {
		$model = $this->findModel($eventid);
		$searchModel = new ActivitySearch();
		$searchModel->event = $model;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $this->_pageSize);
		
        if (($sort = $dataProvider->getSort()) !== false) {
            $dataProvider->query->addOrderBy($sort->getOrders());
        }	

		$dataByRows=$dataProvider->query->all();
		$keys = array_keys($dataByRows);
		for ($i = 0; $i < count($keys); $i++) {
			$row=$dataByRows[$keys[$i]];
			if($row->id==$id){
				if(($i+1) < count($keys)){
					$foundNextRow=$dataByRows[$keys[$i+1]];
					$durationNext=($i+2) < count($keys) ? $this->minutesDiff($foundNextRow->start_time,$dataByRows[$keys[$i+2]]->start_time):1;
					$foundNextRow->start_time=$row->start_time;
					$row->start_time = $this->addTime($row->start_time, $durationNext);
					$row->save();
					$foundNextRow->save();
				}
				
				break;
			}
		}

		return $this->redirect(['activities','id'=>$eventid,'activityid'=>$id]);	
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
	
	private function getActivitiesToShow($model,$activityid)
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
			'activityid' => $activityid,
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
    	$user_from=User::findOne($model->user_from_id);
    	$template=MessageTemplate::findOne($model->message_template_id);
    	$teamname= $model->team_id?Team::findOne($model->team_id)->name:'';
    	return $this->render('seenotify', ['model'=>$model, 'activity'=>$activity, 'event'=>$event, 'user_from'=>$user_from, 'user'=>$user, 'teamname'=>$teamname, 'template'=>$template]);	
	}
	public function actionVolunteers($actionid, $userid, $eventid)
    {
    	$model = new UserNotification();
		
        if ($model->load(Yii::$app->request->post())) {
			if($model->message_html && strlen($model->message_html)>2 && $model->user_to_id && strlen($model->user_to_id)>0){
				Notification::sendSmsOnlyForOne($model->user_to_id, $actionid, $eventid, null, $model->message_html);
				return $this->redirect(['editactivity','id'=>$actionid,'eventid'=>$eventid,'returnurl'=>'activities%3Fid%3D'.$eventid]);
			}
			Yii::$app->session->setFlash("danger", Yii::t("app", "Failed to update"));
        }			

		$event=Event::findOne($eventid);
		$activity=Activity::findOne($actionid);
		$eventname=$event->name . ' ' . Yii::$app->formatter->asDate($event->start_date, "Y-MM-dd H:mm") ;
		$modelActivityType=ActivityType::findOne($activity->activity_type_id);
		$users=$modelActivityType->getUsersForActivityType()->all();
		if($users==null || count($users)==0){
			$users=app\models\User::find()->where(['church_id' => $modelEvent->church_id])->orderBy("display_name ASC")->all();
		}

		return $this->render('volunteers', [
			'model'=>$model,
			'users'=>$users,
			'eventname'=>$eventname,
			'eventid'=>$eventid,
			'activityname'=>$activity->name,
		]);	    	
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
	public function actionActivities($id,$activityid=null)
    {
		$model=Event::findOne(['id'=>$id]);
		
        return $this->render('activities', $this->getActivitiesToShow($model,$activityid));	
	}
	public function actionRemovefromevent($id,$eventid)
    {
		$model=Activity::findOne(['id'=>$id]);
		File::deleteAllFiles($model);
		PictureActivity::deleteAll('activity_id = '.$id);
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
		$modelActivityType=ActivityType::findOne(['id'=>$id]);
        $modelActivity = new Activity(['scenario' => 'create']);
		$modelActivity->activity_type_id=$id;
		$modelActivity->event_id=$eventid;
		$modelEvent=Event::findOne(['id'=>$eventid]);
		
		$modelActivity->start_time= Yii::$app->formatter->asDate($modelEvent->start_date, "HH:mm");
		$modelActivity->end_time=$modelActivityType->default_end_time;
		$modelActivity->global_order=$modelActivityType->default_global_order;
		$modelActivity->name=$modelActivityType->name;
		if($modelActivityType->use_globally){
			$modelActivity->duration=1;
			$modelActivity->start_time='00:00:01';
		}

        if (!$modelActivity->save()) {
			Yii::$app->session->setFlash("danger", Yii::t("app", "Failed to add"));
        }else{
			Log::write('Activity', LogWhat::CREATE, null , (string)$modelActivity);
			return $this->redirect(['editactivity','id'=>$modelActivity->id,'eventid'=>$eventid,'returnurl'=>'activities%3Fid%3D'.$eventid]);
		}
		$model=Event::findOne(['id'=>$eventid]);
        return $this->redirect(['activities','id'=>$eventid]);
	}
	public function actionExportalltasksbyevent($start, $end, $filters=null)
    {
    	return AllEventsExportFile::exportExcel($start, $end, $filters);
	}
    public function actionAlltasksbyevent($start, $end, $filters=null)
    {
		/*
		$model = new EventNameFilter();
		$model->resetTo(1);
        if ($model->load(Yii::$app->request->post())) {
            //Log::write('Activity', LogWhat::CREATE, serialize($model ), (string)$start);
        }		
		*/
		$queries = AllEventsExportFile::getDataArray($start, $end, true, $filters);
		
		
		//$model->setFieldNames($queries[2]);
		return $this->render('alltasksbyevent', [
            'start' => $start,
            'end' => $end,
            'columns' => $queries[1],
            'dataRows' => $queries[0],
			'filterNames' => $queries[2],
			'filters' => $filters,
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
		$searchModel->filter_end_date = date("Y-m-d", strtotime('+5 month'));

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
			// delete all messages
			$searchNotificationModel = new NotificationSearch();
			$searchNotificationModel->event = $model;
			$dataNotificationProvider = $searchNotificationModel->search(Yii::$app->request->queryParams, $this->_pageSize);		
			foreach($dataNotificationProvider->query->all() as $notify){
				$notify->delete();
			}

			// delete all activities(removeing files)
			$query = Activity::getAllActivities($id)->all();
			foreach($query as $activity){	
				File::deleteAllFiles($activity);
				PictureActivity::deleteAll('activity_id = '.$activity->id);
				$activity->delete();
			}			
			
			// remove files 
			File::deleteAllFiles($model);
			
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
