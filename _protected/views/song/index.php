<?php
use app\helpers\CssHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Songs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="song-index">

    <h1>
        <?= Html::encode($this->title) ?>
        <span class="pull-right" style="margin-bottom:5px">
            <a href='create' class='btn btn-success'><span class="glyphicon glyphicon-plus"></span><?=Yii::t('app', 'Create Song')?></a>
            <a href="songimportopenlp" class='btn btn-success'><span class="glyphicon glyphicon-open"></span>Open LP</a>
            <a href="songimportcsv" class='btn btn-success'><span class="glyphicon glyphicon-open"></span>CSV</a>
            <a href="songexportcsv" class='btn btn-success'><span class="glyphicon glyphicon-download-alt"></span>CSV</a>  
            <a href='<?=URL::toRoute('doc/doc')?>?page=song-index&returnName=<?=$this->title?>&returnUrl=<?=URL::toRoute('song/index')?>' class='btn btn-primary'><span class="glyphicon glyphicon-question-sign"></span></a>			                 
        </span>         
    </h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => false,
        'columns' => [
            'name',
            'name2',
            'author',
            [
                'attribute' => 'description',
                'format' => 'raw',
                'value' => function ($model, $index, $widget) {
                    $value=str_replace("\r\n", '<br />', $model->description);
                    $value=str_replace("\n", '<br />', $value);
                    return $value;
                },
            ],              
            // buttons
            ['class' => 'yii\grid\ActionColumn',
            'header' => Yii::t('app', 'Menu'),
            'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('', $url, ['title'=>Yii::t('app', 'Edit Team Type'), 'class'=>'glyphicon glyphicon-pencil menubutton']);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('', $url, 
                        ['title'=>Yii::t('app', 'Delete team type'), 
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