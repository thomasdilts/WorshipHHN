<?php

namespace app\controllers; 

use app\models\Log;
use app\models\LogWhat;
use app\models\User;
use app\models\Team;
use app\models\TeamUser;
use app\models\TeamSearch;
use app\models\TeamBlocked;
use app\models\TeamBlockedSearch;
use app\models\TeamMemberSearch;
use app\models\ActivityExportFile;
use app\models\Notification;
use app\models\File;
use app\models\UserSearch;
use app\models\FileSearch;
use app\models\TeamType;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii;


class TeamController extends AppController
{
	/**
     * How many TeamS we want to display per page.
     * @var int
     */
    protected $_pageSize = 31;
    public function actionTaskreject($id,$teamid){
        Notification::rejectInternallyNotification($id);
        return $this->redirect(['tasks','id'=>$teamid]);     
    }  
    public function actionTaskaccept($id,$teamid){
        Notification::acceptInternallyNotification($id);
        return $this->redirect(['tasks','id'=>$teamid]);     
    }       	
    public function actionTaskexportexcel($id,$start,$end){
        return ActivityExportFile::exportExcel(null,[$id],$start,$end);        
    }
    public function actionTaskexportpdf($id,$start,$end){
        return ActivityExportFile::exportPdf(null,[$id],$start,$end);        
    }
    public function actionTaskexportics($id,$start,$end){
        return ActivityExportFile::exportIcs(null,[$id],$start,$end);        
    }
    public function actionTasks($id)
    {
        return $this->render('tasks', 
            ActivityExportFile::GetAllData(null,[$id],date('Y-m-d'),date("Y-m-d", strtotime('+3 month')),$this->_pageSize ));
    }    
	public function actionUnavailability($id)
    {
        $searchModel = new TeamBlockedSearch();
		
		$searchModel->teamModel=Team::findOne($id);
		
		$searchModel->filter_start_date = date('Y-m-d', strtotime('-2 month')); // get start date
		$searchModel->filter_end_date = date("Y-m-d", strtotime('+6 month'));
        
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams, $this->_pageSize);

        return $this->render('unavailability', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	public function actionUnavailabilityupdate($id,$teamid)
    {
        $model = TeamBlocked::findOne($id);
		$modelOld=clone $model;
		$model->teamModel=Team::findOne($teamid);
	
        if (!$model->load(Yii::$app->request->post())) {
            return $this->render('unavailabilityupdate', ['model' => $model]);
        }		
		if(!TeamBlocked::IsValidDates($model)){
			return $this->render('unavailabilityupdate', ['model' => $model]);
		}
        if ($model->save()) {
			Log::write('TeamBlocked', LogWhat::UPDATE, (string)$modelOld, (string)$model);
            Yii::$app->session->setFlash("success", Yii::t("app", "Successful update"));
            return $this->redirect(['unavailability','id'=>$teamid]);
        } else {
			Yii::$app->session->setFlash("danger", Yii::t("app", "Failed to update"));
            return $this->render('unavailabilityupdate', ['model' => $model]);
        }		
    }
	public function actionUnavailabilitycreate($id)
    {
        $model = new TeamBlocked(['scenario' => 'create']);
		$model->teamModel=Team::findOne($id);

        if (!$model->load(Yii::$app->request->post())) {
            return $this->render('unavailabilitycreate', ['model' => $model]);
        }
		$model->team_id=$id;
		
		if(!TeamBlocked::IsValidDates($model)){
			return $this->render('unavailabilitycreate', ['model' => $model]);
		}
		
        if (!$model->save()) {
			Yii::$app->session->setFlash("danger", Yii::t("app", "Failed to create"));
            return $this->render('unavailabilitycreate', ['model' => $model]);
        }
		Log::write('TeamBlocked', LogWhat::CREATE, null, (string)$model);
		Yii::$app->session->setFlash('success', Yii::t('app', 'Successful create'));
        return $this->redirect(['unavailability','id'=>$id]);
    }
	public function actionUnavailabilitydelete($id,$teamid)
    {
		try {
			$model=TeamBlocked::findOne($id);
			if (!$model->delete()) {
				throw new ServerErrorHttpException(Yii::t('app', 'Failed to delete'));
			}
		} catch (\yii\db\IntegrityException|Exception|Throwable  $e) {
			Yii::$app->session->setFlash('danger', Yii::t('app', 'Failed to delete. Object has dependencies that must be removed first.'). $e->getMessage());
			return $this->redirect(['unavailability','id'=>$id]);
		}       
		Log::write('TeamBlocked', LogWhat::DELETE, (string)$model, null);
        Yii::$app->session->setFlash('success', Yii::t('app', 'Successful delete'));
        
        return $this->redirect(['unavailability','id'=>$teamid]);
    }
    public function actionCreate()
    {
        $model = new Team(['scenario' => 'create']);

        if (!$model->load(Yii::$app->request->post())) {
            return $this->render('create', ['model' => $model, 'church_id' => Yii::$app->user->identity->church_id]);
        }
		$model->church_id=Yii::$app->user->identity->church_id;
		
        if (!$model->save()) {
			Yii::$app->session->setFlash("danger", Yii::t("app", "Failed to create"));
            return $this->render('create', ['model' => $model, 'church_id' => Yii::$app->user->identity->church_id]);
        }
		Log::write('Team', LogWhat::CREATE, null, (string)$model);
		Yii::$app->session->setFlash('success', Yii::t('app', 'Successful create'));
        return $this->redirect('index');
    }

    public function actionIndex()
    {
        $searchModel = new TeamSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $this->_pageSize);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionFiles($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
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
	public function actionRemovefromteam($id,$teamid)
    {
		$modelOld= $this->findModel($teamid);
		$modelOldString= (string)$modelOld;
		if (!TeamUser::findOne(['user_id'=>$id,'team_id'=>$teamid])->delete()) {
			Yii::$app->session->setFlash("danger", Yii::t("app", "Failed to delete"));
        }else{
			Log::write('Team', LogWhat::UPDATE, (string)$modelOldString, (string)$this->findModel($teamid));
			Yii::$app->session->setFlash('success', Yii::t('app', 'Successful delete'));
		}

        return $this->redirect(['players','id'=>$teamid]);		
	}
	public function actionPlayersadmin($id,$userid,$value)
    {
		$teamUser = TeamUser::findOne(['user_id'=>$userid,'team_id'=>$id]);
		$teamUser->admin = ($value==0?1:0);
		if (!$teamUser->save()) {
			Yii::$app->session->setFlash("danger", Yii::t("app", "Failed to update"));
        }else{
			Log::write('Team', LogWhat::UPDATE, 'actionPlayersadmin user='.User::findOne($userid)->email.'; isAdmin='.$teamUser->admin, (string)$this->findModel($id));
			Yii::$app->session->setFlash('success', Yii::t('app', 'Successful update'));
		}

        return $this->redirect(['players','id'=>$id]);			
	}	

	public function actionAddtoteam($id,$teamid)
    {
		//check if already exists first
		if(count(TeamUser::find()->where(['user_id'=>$id,'team_id'=>$teamid])->all())!=0){
			Yii::$app->session->setFlash("danger", Yii::t("app", "The member is already in the team"));
			return $this->redirect(['players','id'=>$teamid]);	
		}
		$modelOldString= (string)$this->findModel($teamid);
		
        $teamUser = new TeamUser(['scenario' => 'create']);
		$teamUser->user_id=$id;
		$teamUser->team_id=$teamid;
		$teamUser->admin='0';
		
        if (!$teamUser->save()) {
			Yii::$app->session->setFlash("danger", Yii::t("app", "Failed to add"));
        }else{
			Log::write('Team', LogWhat::UPDATE, $modelOldString, (string)$this->findModel($teamid));
			Yii::$app->session->setFlash('success', Yii::t('app', 'Successful add'));
		}
        return $this->redirect(['players','id'=>$teamid]);		
	}

    public function actionPlayers($id)
    {
        $model = $this->findModel($id);

        $searchMembersModel = new TeamMemberSearch();
		$searchMembersModel ->teamModel=$model;
        $dataMembersProvider = $searchMembersModel->search(Yii::$app->request->queryParams, $this->_pageSize);		
        $searchUsersModel = new UserSearch();
        $dataUsersProvider = $searchUsersModel->search(Yii::$app->request->queryParams, $this->_pageSize);		
        return $this->render('players', [
			'model' => $model, 
			'church_id' => Yii::$app->user->identity->church_id,
            'searchMembersModel' => $searchMembersModel,
            'dataMembersProvider' => $dataMembersProvider,
            'searchUsersModel' => $searchUsersModel,
            'dataUsersProvider' => $dataUsersProvider,
			]);	
    }	
	
	
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', ['model' => $model]);	
    }
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$modelOld= clone $model;
        if (!$model->load(Yii::$app->request->post())) {
            return $this->render('update', ['model' => $model, 'church_id' => Yii::$app->user->identity->church_id]);
        }			
        if ($model->save()) {
			Log::write('Team', LogWhat::UPDATE, (string)$modelOld, (string)$model);
            Yii::$app->session->setFlash("success", Yii::t("app", "Successful update"));
            return $this->redirect(['index']);
        } else {
			Yii::$app->session->setFlash("danger", Yii::t("app", "Failed to update"));
            return $this->render('update', ['model' => $model, 'church_id' => Yii::$app->user->identity->church_id]);
        }		
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
		Log::write('Team', LogWhat::DELETE, (string)$model, null);
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
        $model = Team::findOne($id);

        if (is_null($model)) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        } 

        return $model;
    }
}
