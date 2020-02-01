<?php
use app\helpers\CssHelper;
use app\models\File;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Pictures');
$this->params['breadcrumbs'][] = $this->title;
$GLOBALS['fileVault'] = substr(Yii::$app->params['fileVaultPath'],strlen(dirname(__DIR__,3)));
?>
<div class="picture-index">

    <h1>
        <?= Html::encode($this->title) ?>
        <span class="pull-right" style="margin-bottom:5px">
            <a href='create' class='btn btn-success'><span class="glyphicon glyphicon-plus"></span><?=Yii::t('app', 'Create Picture')?></a>
            <a href='<?=URL::toRoute('doc/doc')?>?page=picture-index&returnName=<?=$this->title?>&returnUrl=<?=URL::toRoute('picture/index')?>%3Ftemp%3Dtemp' class='btn btn-primary'><span class="glyphicon glyphicon-question-sign"></span></a>			                 
        </span>         
    </h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => false,
        'columns' => [  
			[
				'attribute' => 'name',
				'contentOptions' => ['style' =>'white-space:pre-line;'],

			],
			[
				'attribute' => 'description',
				'contentOptions' => ['style' =>'white-space:pre-line;'],

			],			
			[
				'format' => 'raw',
				'value' => function ($model) {
					$image=File::findOne(['model'=>$model->tableName(),'itemId'=>$model->id]);
					return $image==null?'':'<a href="'.Yii::$app->request->baseUrl. $GLOBALS['fileVault']. DIRECTORY_SEPARATOR . $image->hash.'"><img src="'. Yii::$app->request->baseUrl. $GLOBALS['fileVault']. DIRECTORY_SEPARATOR . $image->hash.'" style="max-width:250px"></a>';
				}
			],			
            // buttons
            ['class' => 'yii\grid\ActionColumn',
            'header' => Yii::t('app', 'Menu'),
            'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('', $url, ['title'=>Yii::t('app', 'Edit'), 'class'=>'glyphicon glyphicon-pencil menubutton']);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('', $url, 
                        ['title'=>Yii::t('app', 'Delete'), 
                            'class'=>'glyphicon glyphicon-trash menubutton',
                            'data' => [
                                'confirm' => Yii::t('app', 'Are you sure you want to delete this?'),
                                'method' => 'post']
                        ]);
                    }
                ]

            ], // ActionColumn

        ], // columns

    ]); ?>

</div>