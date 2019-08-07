<?php

namespace app\controllers;

use app\models\Song;
use app\models\SongImportFile;
use app\models\SongSearch;
use app\models\SongExportCsvFile;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii;

class SongController extends AppController
{
	/**
     * How many Songs we want to display per page.
     * @var int
     */
    protected $_pageSize = 11;

    public function actionSongimportopenlp()
    {
        $model=new Song();

        if ($model->load(Yii::$app->request->post())) {
            $filePath=SongImportFile::getFileFromUser($model);
            if($filePath && strlen($filePath)>0){
                SongImportFile::importOpenLp($filePath);
            }

            return $this->redirect('index');
        }   

        return $this->render('songimport',[
            'mimeType'=>'application/zip, application/octet-stream, application/x-zip-compressed, multipart/x-zip',
            'model'=>$model]);
    }
    public function actionSongimportcsv()
    {
        $model=new Song();

        if ($model->load(Yii::$app->request->post())) {
            $filePath=SongImportFile::getFileFromUser($model);
            if($filePath && strlen($filePath)>0){
                SongImportFile::importCsv($filePath);
            }

            return $this->redirect('index');
        }   

        return $this->render('songimport',['mimeType'=>'text/csv','model'=>$model]);
    }
    public function actionSongexportcsv()
    {
        return SongExportCsvFile::exportCsv();
    }
    public function actionCreate()
    {
        $model = new Song(['scenario' => 'create']);

        if (!$model->load(Yii::$app->request->post())) {
            return $this->render('create', ['model' => $model]);
        }
		$model->church_id=Yii::$app->user->identity->church_id;
		
        if (!$model->save()) {
			Yii::$app->session->setFlash("danger", Yii::t("app", "Failed to create"));
            return $this->render('create', ['model' => $model]);
        }
		Yii::$app->session->setFlash('success', Yii::t('app', 'Successful create'));
        return $this->redirect('index');
    }

    public function actionIndex()
    {
        $searchModel = new SongSearch();
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
        $model = Song::findOne($id);

        if (is_null($model)) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        } 

        return $model;
    }
}

