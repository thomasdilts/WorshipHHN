<?php
use app\helpers\CssHelper;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

$this->title = Yii::t('app', 'Team files');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Teams'), 'url' => ['index']];;
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = $model->name;
?>
<div class="user-index">

    <div>
		<?=$model->name?>
        <?= $this->render('../_file', [
			'model' => $model,
			'dataProvider' => $dataProvider,
			'searchModel' => $searchModel,
			'urlAddition' => '&fileownerid='.$model->id,
			'filedownloadUrl' => 'filedownload',
			'backurl' => 'index',
			'deletefileUrl' => 'deletefile']) ?>
    </div>

</div>