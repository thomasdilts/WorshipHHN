<?php
use app\helpers\CssHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Task templates');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1>
        <?= Html::encode($this->title) ?>
        <span class="pull-right" style="margin-bottom:5px">
            <a href='create' class='btn btn-success'><span class="glyphicon glyphicon-plus"></span><?=Yii::t('app', 'Create Task Template')?></a>
            <a href='<?=URL::toRoute('doc/doc')?>?page=activity-type-index&returnName=<?=$this->title?>&returnUrl=<?=URL::toRoute('activity-type/index')?>%3Ftemp%3Dtemp' class='btn btn-primary'><span class="glyphicon glyphicon-question-sign"></span></a>			
        </span>         
    </h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'default_start_time',
            'default_global_order',
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
