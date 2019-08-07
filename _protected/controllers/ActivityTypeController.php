<?php

namespace app\controllers;

use app\models\ActivityType;
use app\models\ActivityTypeSearch;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii;

class ActivityTypeController extends AppController
{
	/**
     * How many ActivityTypeS we want to display per page.
     * @var int
     */
    protected $_pageSize = 31;
	
    public function actionCreate()
    {
        $model = new ActivityType(['scenario' => 'create']);
		$model->church_id=Yii::$app->user->identity->church_id;
		
        if (!$model->load(Yii::$app->request->post())) {
            return $this->render('create', ['model' => $model]);
        }
		$model->church_id=Yii::$app->user->identity->church_id;
		
		if ($model->default_global_order==null) {	
			$model->default_global_order=0;
		}
        if (!$model->save()) {
			Yii::$app->session->setFlash("danger", Yii::t("app", "Failed to create"));
            return $this->render('create', ['model' => $model]);
        }
		Yii::$app->session->setFlash('success', Yii::t('app', 'Successful create'));
        return $this->redirect('index');
    }

    public function actionIndex()
    {
        $searchModel = new ActivityTypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $this->_pageSize);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if (!$model->load(Yii::$app->request->post())) {
            return $this->render('update', ['model' => $model]);
        }	
		if ($model->default_global_order==null) {	
			$model->default_global_order=0;
		}	
        if ($model->save()) {
            Yii::$app->session->setFlash("success", Yii::t("app", "Successful update"));
            return $this->redirect(['index']);
        } else {
			Yii::$app->session->setFlash("danger", Yii::t("app", "Failed to update"));
            return $this->render('update', ['model' => $model]);
        }		
    }

    public function actionDelete($id)
    {
		try {
			if (!$this->findModel($id)->delete()) {
				throw new ServerErrorHttpException(Yii::t('app', 'Failed to delete'));
			}
		} catch (\yii\db\IntegrityException|Exception|Throwable  $e) {
			Yii::$app->session->setFlash('danger', Yii::t('app', 'Failed to delete. Object has dependencies that must be removed first.'). $e->getMessage());
			return $this->redirect(['index']);
		}       

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
        $model = ActivityType::findOne($id);

        if (is_null($model)) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        } 

        return $model;
    }
}
