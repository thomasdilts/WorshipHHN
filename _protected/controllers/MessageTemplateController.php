<?php

namespace app\controllers;

use app\models\MessageTemplate;
use app\models\Language;
use app\models\MessageTemplateSearch;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii;

class MessageTemplateController extends AppController
{
	/**t
     * How many MessageTemplate we want to display per page.
     * @var int
     */
    protected $_pageSize = 11;
	
    public function actionCreate()
    {
        $model = new MessageTemplate(['scenario' => 'create']);
		$language=Language::find()->where(['iso_name'=>Yii::$app->language])->one();
		$model->language_id=$language?$language->id:0;
        if (!$model->load(Yii::$app->request->post())) {
            return $this->render('create', ['model' => $model,'church_id'=>Yii::$app->user->identity->church_id]);
        }
		$model->church_id=Yii::$app->user->identity->church_id;
		
        if (!$model->save()) {
			Yii::$app->session->setFlash("danger", Yii::t("app", "Failed to create"));
            return $this->render('create', ['model' => $model,'church_id'=>Yii::$app->user->identity->church_id]);
        }
		Yii::$app->session->setFlash('success', Yii::t('app', 'Successful create'));
        return $this->redirect('index');
    }

    public function actionIndex()
    {
        $searchModel = new MessageTemplateSearch();
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
            return $this->render('update', ['model' => $model,'church_id'=>Yii::$app->user->identity->church_id]);
        }	

        if ($model->save()) {
            Yii::$app->session->setFlash("success", Yii::t("app", "Successful update"));
            return $this->redirect(['index']);
        } else {
			Yii::$app->session->setFlash("danger", Yii::t("app", "Failed to update"));
            return $this->render('update', ['model' => $model,'church_id'=>Yii::$app->user->identity->church_id]);
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
        $model = MessageTemplate::findOne($id);

        if (is_null($model)) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        } 

        return $model;
    }
}
