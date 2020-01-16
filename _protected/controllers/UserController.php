<?php
namespace app\controllers;

use app\models\Log;
use app\models\LogWhat;
use app\models\User;
use app\models\File;
use app\models\Language;
use app\models\Activity;
use app\models\UserActivityType;
use app\models\UserSearch;
use app\models\ActivityExportFile;
use app\models\UserActivitySearch;
use app\models\Notification;
use app\models\UserNotification;
use app\models\UserNotificationSearch;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use Yii;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends AppController
{
    /**
     * How many users we want to display per page.
     * @var int
     */
    protected $_pageSize = 21;
    public function actionTaskreject($id){
		$activity=Activity::findOne($id);
		if(Yii::$app->user->identity->id != $activity->user_id){
			Yii::$app->session->setFlash('error', Yii::t('app', 'You are not allowed to do this operation'));
			return $this->redirect(['tasks','id'=>$activity->user_id]);
		}
        Notification::rejectInternallyNotification($id);
        return $this->redirect(['tasks','id'=>$activity->user_id]);
    }
    public function actionTaskaccept($id){
		$activity=Activity::findOne($id);
		if(Yii::$app->user->identity->id != $activity->user_id){
			Yii::$app->session->setFlash('error', Yii::t('app', 'You are not allowed to do this operation'));
			return $this->redirect(['tasks','id'=>$activity->user_id]);
		}
        Notification::acceptInternallyNotification($id);
        return $this->redirect(['tasks','id'=>$activity->user_id]);
    }
    public function actionTaskexportexcel($id,$start,$end){
        $user = User::findOne($id);
        $query =  $user->getTeams()->all();
        return ActivityExportFile::exportExcel($id,ArrayHelper::getColumn($query , 'id'),$start,$end);
    }
    public function actionTaskexportpdf($id,$start,$end){
        $user = User::findOne($id);
        $query =  $user->getTeams()->all();
        return ActivityExportFile::exportPdf($id,ArrayHelper::getColumn($query , 'id'),$start,$end);
    }
    public function actionTaskexportics($id,$start,$end){
        $user = User::findOne($id);
        $query =  $user->getTeams()->all();
        return ActivityExportFile::exportIcs($id,ArrayHelper::getColumn($query , 'id'),$start,$end);
    }
    public function actionTasks($id)
    {
        $user = User::findOne($id);
        $query =  $user->getTeams()->all();
        return $this->render('tasks',
            ActivityExportFile::GetAllData($id,ArrayHelper::getColumn($query , 'id'),date('Y-m-d'),date("Y-m-d", strtotime('+3 month')),$this->_pageSize ));
    }

    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $this->_pageSize);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     *
     * @param  integer $id The user id.
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
		$model = $this->findModel($id);
        return $this->render('view', 
			['model' => User::find()->where(['user.id'=>$id])->joinWith('language')->one(),
			'updateUrl'=>'update?id='.$id,
			'abilities'=>$model->getActivityTypesForUser()]);
    }
    public function actionViewme()
    {
		$model = $this->findModel(Yii::$app->user->identity->id);
        return $this->render('view', 
			['model' => User::find()->where(['user.id'=>Yii::$app->user->identity->id])->joinWith('language')->one(),
			'updateUrl'=>'updateme',
			'abilities'=>$model->getActivityTypesForUser()]);
    }

    public function actionFileupload()
    {
        $model = $this->findModel(Yii::$app->user->identity->id);
        if ($model->load(Yii::$app->request->post())) {
            File::addFileTrimImage($model,150);
        }
        return $this->redirect('updateme');
    }
    public function actionFiledelete()
    {
        $model = $this->findModel(Yii::$app->user->identity->id);
        $file=File::findOne(['model'=>$model->tableName(),'itemId'=>$model->id]);
        File::deletefile($file->id);
		Log::write('User', LogWhat::FILE_DELETE, null, (string)'name='.$file->name.'; size='.$file->size);
        return $this->redirect('updateme');
    }
    public function actionFileuploadadmin($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            File::addFileTrimImage($model,150);
        }
        return $this->redirect(['update','id'=>$id]);
    }
    public function actionFiledeleteadmin($id)
    {
		$model = $this->findModel($id);
        $file=File::findOne(['model'=>$model->tableName(),'itemId'=>$model->id]);
        File::deletefile($file->id);
		Log::write('User', LogWhat::FILE_DELETE, null, (string)'name='.$file->name.'; size='.$file->size);
        return $this->redirect(['update','id'=>$id]);
    }	
    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $user = new User(['scenario' => 'create']);
        if (!$user->load(Yii::$app->request->post())) {
			$language=Language::find()->where(['iso_name'=>Yii::$app->language])->one();
			$user->language_id=$language?$language->id:0;
			$user->church_id=Yii::$app->user->identity->church_id;
            return $this->render('create', ['model'=>$user,'image'=>File::findOne(['model'=>$user->tableName(),'itemId'=>$user->id])]);
        }

        $user->setPassword($user->password);
        $user->generateAuthKey();
		
        if (!$user->save()) {
            return $this->render('create', ['model'=>$user,'image'=>File::findOne(['model'=>$user->tableName(),'itemId'=>$user->id])]);
        }
		
		UserActivityType::saveActivityTypesForUser($user->id,$user->abilities);	
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($user->item_name);
        $info = $auth->assign($role, $user->getId());

        if (!$info) {
            Yii::$app->session->setFlash('error', Yii::t('app', 'There was some error while saving user role.'));
        }
		Log::write('User', LogWhat::CREATE, null, (string)$user);
        return $this->redirect(['index','id'=>Yii::$app->user->identity->id]);
    }
    public function actionUpdateme()
    {
        return $this->actionUpdate(Yii::$app->user->identity->id,'viewme','viewme');
    }
    /**
     * Updates an existing User and Role models.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param  integer $id The user id.
     * @return string|\yii\web\Response
     *
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id,$returnUrl='index',$redirectUrl='view')
    {
        // load user data
        $user = $this->findModel($id);
		$userOldString=(string)$user;
        $auth = Yii::$app->authManager;

        // get user role if he has one
        if ($roles = $auth->getRolesByUser($id)) {
            // it's enough for us the get first assigned role name
            $role = array_keys($roles)[0];
        }

        // if user has role, set oldRole to that role name, else offer 'member' as sensitive default
        $oldRole = (isset($role)) ? $auth->getRole($role) : $auth->getRole('member');

        // set property item_name of User object to this role name, so we can use it in our form
        $user->item_name = $oldRole->name;

        if (!$user->load(Yii::$app->request->post())) {
            return $this->render('update', ['role' => $user->item_name,'returnUrl'=>$returnUrl,'model'=>$user, 'image'=>File::findOne(['model'=>$user->tableName(),'itemId'=>$user->id])]);
        }

        // only if user entered new password we want to hash and save it
        if ($user->password) {
            $user->setPassword($user->password);
        }

        // if admin is activating user manually we want to remove account activation token
        if ($user->status == User::STATUS_ACTIVE && $user->account_activation_token != null) {
            $user->removeAccountActivationToken();
        }

        if (!$user->save()) {
            return $this->render('update', ['role' => $user->item_name,'returnUrl'=>$returnUrl,'model'=>$user,'model'=>$user, 'image'=>File::findOne(['model'=>$user->tableName(),'itemId'=>$user->id])]);
        }
		
		UserActivityType::saveActivityTypesForUser($user->id,$user->abilities);	

        // take new role from the form
        $newRole = $auth->getRole($user->item_name);
        // get user id too
        $userId = $user->getId();

        // we have to revoke the old role first and then assign the new one
        // this will happen if user actually had something to revoke
        if ($auth->revoke($oldRole, $userId)) {
            $info = $auth->assign($newRole, $userId);
        }

        // in case user didn't have role assigned to him, then just assign new one
        if (!isset($role)) {
            $info = $auth->assign($newRole, $userId);
        }

        if (!$info) {
            Yii::$app->session->setFlash('error', Yii::t('app', 'There was some error while saving user role.'));
        }
		Log::write('User', LogWhat::UPDATE, (string)$userOldString, (string)$user);
        return $redirectUrl=='view'?$this->redirect([$redirectUrl, 'id' => $user->id]):$this->redirect([$redirectUrl]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param  integer $id The user id.
     * @return \yii\web\Response
     *
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        // delete user or throw exception if could not
		$user=$this->findModel($id);
		$userString = (string)$user;
        if (!$user->delete()) {
            throw new ServerErrorHttpException(Yii::t('app', 'We could not delete this user.'));
        }

        $auth = Yii::$app->authManager;
        $info = true; // monitor info status

        // get user role if he has one
        if ($roles = $auth->getRolesByUser($id)) {
            // it's enough for us the get first assigned role name
            $role = array_keys($roles)[0];
        }

        // remove role if user had it
        if (isset($role)) {
            $info = $auth->revoke($auth->getRole($role), $id);
        }
		UserActivityType::deleteAll('user_id = '.$user->id);

        if (!$info) {
            Yii::$app->session->setFlash('error', Yii::t('app', 'There was some error while deleting user role.'));
            return $this->redirect(['index']);
        }

        Yii::$app->session->setFlash('success', Yii::t('app', 'You have successfuly deleted user and his role.'));
		Log::write('User', LogWhat::DELETE, (string)$userString, null);
        return $this->redirect(['index']);
    }
	
	public function actionSeenotify($id, $userid)
    {
    	$model=UserNotification::findOne($id);
    	$userFrom=User::findOne($model->user_from_id);
    	$userTo=User::findOne($model->user_to_id);

    	return $this->render('seenotify', ['model'=>$model, 'userid'=>$userid, 'userFrom'=>$userFrom, 'userTo'=>$userTo]);	
	}
	public function actionDeletenotify($id, $userid)
    {
    	try {
			$model=UserNotification::findOne($id);
			if (!$model->delete()) {
				throw new ServerErrorHttpException(Yii::t('app', 'Failed to delete'));
			}
		} catch (\yii\db\IntegrityException|Exception|Throwable  $e) {
			Yii::$app->session->setFlash('danger', Yii::t('app', 'Failed to delete. Object has dependencies that must be removed first.'). $e->getMessage());
			return $this->redirect(['notifications','id'=>$teamid]);
		}       
		Log::write('UserNotification', LogWhat::DELETE, (string)$model, null);
        Yii::$app->session->setFlash('success', Yii::t('app', 'Successful delete'));

    	return $this->redirect(['notifications','id'=>$userid]);
	}

	public function actionNotify($id)
    {
		$model = new UserNotification();
        if ($model->load(Yii::$app->request->post())) {
			Log::write('actionNotify', LogWhat::DELETE, (string)$model, null);
			if($model->message_html && strlen($model->message_html)>2 && $model->user_to_id && strlen($model->user_to_id)>0){
				UserNotification::sendSMSForMany($model->user_to_id, null, $model->message_html);
				return $this->redirect(['notifications','id'=>$id]);
			}
			Yii::$app->session->setFlash("danger", Yii::t("app", "Failed to update"));
        }	

		Yii::$app->session->setFlash("success", Yii::t("app", "Successful create"));
		return $this->redirect(['notifications','id'=>$id]);
    }

	public function actionNotifications($id=null)
    {
		
		if((!$id && !Yii::$app->user->can('ChurchAdmin')) || ($id && $id!=Yii::$app->user->identity->id)){
			throw new ServerErrorHttpException(Yii::t('app', 'Error'));
		}
		
		$model = new UserNotification();
		
		
        $searchNotificationModel = new UserNotificationSearch();
        $searchNotificationModel->user_from_id = $id;
        $dataNotificationProvider = $searchNotificationModel->search(Yii::$app->request->queryParams, $this->_pageSize);		
		if (Yii::$app->request->post()) {
			//this is a request to refresh SMS notifications.
			foreach($dataNotificationProvider->query->all() as $notify){
				$notify->updateSmsNotificationStatus();
			}
			
        }			
		
        return $this->render('notifications', [
			'id' => $id,
			'church_id' => Yii::$app->user->identity->church_id,
            'searchNotificationModel' => $searchNotificationModel,
            'dataNotificationProvider' => $dataNotificationProvider,
			'model' => $model,
			]);	
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
        $model = User::findOne($id);

        if (is_null($model)) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }

        return $model;
    }

}
