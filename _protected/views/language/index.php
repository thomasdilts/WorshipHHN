<?php
use app\helpers\CssHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Languages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="language-index">

    <h1>
        <?= Html::encode($this->title) ?>
        <span class="pull-right">
            <a href='create' class='btn btn-success'><span class="glyphicon glyphicon-plus"></span><?=Yii::t('app', 'Create Language')?></a>
			<a href='<?=URL::toRoute('doc/doc')?>?page=language-index&returnName=<?=$this->title?>&returnUrl=<?=URL::toRoute('event/index')?>' class='btn btn-primary'><span class="glyphicon glyphicon-question-sign"></span></a>
        </span>         
    </h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => false,
        'columns' => [
            'iso_name',
            'display_name_english',
            'display_name_native',
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