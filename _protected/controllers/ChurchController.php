<?php
namespace app\controllers;

use app\models\Church;
use app\models\Language;
use app\models\ChurchSearch;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii;

class ChurchController extends AppController
{
	/**
     * How many ChurchS we want to display per page.
     * @var int
     */
    protected $_pageSize = 11;
	
    public function actionCreate()
    {
        $model = new Church(['scenario' => 'create']);

        if (!$model->load(Yii::$app->request->post())) {
            return $this->render('create', ['model' => $model]);
        }

        if (!$model->save()) {
			Yii::$app->session->setFlash("danger", Yii::t("app", "Failed to create"));
            return $this->render('create', ['model' => $model]);
        }
		
		//copy all languages as well.
		$languages = Language::find()->where(['church_id'=>Yii::$app->user->identity->church_id])->all();
		Yii::info('Language count= ' . count($languages),'actionCreate');
		foreach($languages as $language){
			$lang = new Language();
			Yii::info('Language ' . $language->iso_name,'actionCreate');
			$lang->iso_name=$language->iso_name;
			$lang->display_name_english=$language->display_name_english;
			$lang->display_name_native=$language->display_name_native;
			$lang->church_id=$model->id;
			$lang->validate();
			Yii::info('Language validate errors ' . serialize($lang->errors),'actionCreate');
			$lang->save();
		}
		
		Yii::$app->session->setFlash('success', Yii::t('app', 'Successful create'));
        return $this->redirect('index');
    }

    public function actionIndex()
    {
        $searchModel = new ChurchSearch();
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
		if(!Yii::$app->user->can('theCreator') && $id!=Yii::$app->user->identity->church_id){
			Yii::$app->session->setFlash("danger", Yii::t("app", "Failed to update"));
			return $this->redirect(['/home']);
		}
		if ($model->save()) {
            Yii::$app->session->setFlash("success", Yii::t("app", "Successful update"));
			if(Yii::$app->user->can('theCreator')){
				return $this->redirect(['index']);
			}else{
				return $this->redirect(['/home']);
			}
        } else {
			Yii::$app->session->setFlash("danger", Yii::t("app", "Failed to update"));
            return $this->render('update', ['model' => $model]);
        }		
    }

    public function actionDelete($id)
    {
        // delete Church or throw exception if could not
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
        $model = Church::findOne($id);

        if (is_null($model)) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        } 

        return $model;
    }
}
