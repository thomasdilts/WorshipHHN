<?php

namespace app\controllers;

use app\models\Log;
use app\models\LogWhat;
use app\models\Language;
use app\models\LanguageSearch;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii;

class LanguageController extends AppController
{
	/**
     * How many Songs we want to display per page.
     * @var int
     */
    protected $_pageSize = 11;
	
    public function actionCreate()
    {
        $model = new Language(['scenario' => 'create']);

        if (!$model->load(Yii::$app->request->post())) {
            return $this->render('create', ['model' => $model]);
        }
		$model->church_id=Yii::$app->user->identity->church_id;
		
        if (!$model->save()) {
			Yii::$app->session->setFlash("danger", Yii::t("app", "Failed to create"));
            return $this->render('create', ['model' => $model]);
        }
		Log::write('Language', LogWhat::CREATE, null, (string)$model);
		Yii::$app->session->setFlash('success', Yii::t('app', 'Successful create'));
        return $this->redirect('index');
    }

    public function actionIndex()
    {
        $searchModel = new LanguageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $this->_pageSize);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$modelOld=clone $model;
        if (!$model->load(Yii::$app->request->post())) {
            return $this->render('update', ['model' => $model]);
        }		
        if ($model->save()) {
			Log::write('Language', LogWhat::UPDATE, (string)$modelOld, (string)$model);
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
			$model=$this->findModel($id);
			if (!$model->delete()) {
				throw new ServerErrorHttpException(Yii::t('app', 'Failed to delete'));
			}
		} catch (\yii\db\IntegrityException|Exception|Throwable  $e) {
			Yii::$app->session->setFlash('danger', Yii::t('app', 'Failed to delete. Object has dependencies that must be removed first.'). $e->getMessage());
			return $this->redirect(['index']);
		}       
		Log::write('Language', LogWhat::DELETE, (string)$model, null);
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
        $model = Language::findOne($id);

        if (is_null($model)) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        } 

        return $model;
    }
}

