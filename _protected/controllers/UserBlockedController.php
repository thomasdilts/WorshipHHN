<?php

namespace app\controllers;

use app\models\User;
use app\models\UserBlocked;
use app\models\UserBlockedSearch;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii;

class UserBlockedController extends AppController
{
	/**
     * How many UserBlockeds we want to display per page.
     * @var int
     */
    protected $_pageSize = 11;
	
    public function actionCreate()
    {
        $model = new UserBlocked(['scenario' => 'create']);
		$model->user_display_name=Yii::$app->user->identity->display_name;
		$model->user_id=Yii::$app->user->identity->id;
        if (!$model->load(Yii::$app->request->post())) {
            return $this->render('create', ['model' => $model]);
        }
		$model->user_id=Yii::$app->user->identity->id;
		
		if(!UserBlocked::IsValidDates($model)){
			return $this->render('create', ['model' => $model]);
		}
		
        if (!$model->save()) {
			Yii::$app->session->setFlash("danger", Yii::t("app", "Failed to create"));
            return $this->render('create', ['model' => $model]);
        }
		Yii::$app->session->setFlash('success', Yii::t('app', 'Successful create'));
        return $this->redirect(['index','id'=>Yii::$app->user->identity->id]);
    }

    public function actionIndex($id)
    {
		$user=User::findOne($id);
        $searchModel = new UserBlockedSearch();
		$searchModel->userid=$id;
		$searchModel->user_display_name=$user->display_name;
		$searchModel->filter_start_date = date('Y-m-d', strtotime('-2 month')); // get start date
		$searchModel->filter_end_date = date("Y-m-d", strtotime('+6 month'));
        
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams, $this->_pageSize);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$model->user_display_name=Yii::$app->user->identity->display_name;
		
		if(Yii::$app->user->identity->id != $model->user_id){
			Yii::$app->session->setFlash('error', Yii::t('app', 'You are not allowed to do this operation'));
			return $this->redirect(['index','id'=>$model->user_id]);
		}		
		
		
        if (!$model->load(Yii::$app->request->post())) {
            return $this->render('update', ['model' => $model]);
        }		
		if(!UserBlocked::IsValidDates($model)){
			return $this->render('create', ['model' => $model]);
		}
        if ($model->save()) {
            Yii::$app->session->setFlash("success", Yii::t("app", "Successful update"));
            return $this->redirect(['index','id'=>$model->user_id]);
        } else {
			Yii::$app->session->setFlash("danger", Yii::t("app", "Failed to update"));
            return $this->render('update', ['model' => $model]);
        }		
    }

    public function actionDelete($id)
    {
		$model = $this->findModel($id);
		if(Yii::$app->user->identity->id != $model->user_id){
			Yii::$app->session->setFlash('error', Yii::t('app', 'You are not allowed to do this operation'));
			return $this->redirect(['index','id'=>$model->user_id]);
		}				
		try {
			if (!$model->delete()) {
				throw new ServerErrorHttpException(Yii::t('app', 'Failed to delete'));
			}
		} catch (\yii\db\IntegrityException|Exception|Throwable  $e) {
			Yii::$app->session->setFlash('danger', Yii::t('app', 'Failed to delete. Object has dependencies that must be removed first.'). $e->getMessage());
			return $this->redirect(['index','id'=>$model->user_id]);
		}       

        Yii::$app->session->setFlash('success', Yii::t('app', 'Successful delete'));
        
        return $this->redirect(['index','id'=>$model->user_id]);
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
        $model = UserBlocked::findOne($id);

        if (is_null($model)) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        } 

        return $model;
    }
}


