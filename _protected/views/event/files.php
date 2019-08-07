<?php
use app\helpers\CssHelper;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Event files');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Events'), 'url' => ['event/index']];;
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