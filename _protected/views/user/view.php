<?php
use app\helpers\CssHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\User;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->display_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1>
        <?= Html::encode($this->title) ?>
        <div class="pull-right">
            <?php if($updateUrl!='updateme') { ?>
                <a href="index" class='btn btn-warning'><span class="glyphicon glyphicon-step-backward"></span><?=Yii::t('app', 'Return')?></a>
            <?php } ?>
            <a href="<?=$updateUrl?>" class='btn btn-primary'><span class="glyphicon glyphicon-pencil"></span><?=Yii::t('app', 'Update')?></a>
			<a href='<?=URL::toRoute('doc/doc')?>?page=user-profile&returnName=<?=$this->title?>&returnUrl=<?=URL::toRoute('user/view?id='.$model->id)?>' class='btn btn-primary'><span class="glyphicon glyphicon-question-sign"></span></a>			                 
        </div>
    </h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'display_name',
            'username',
            'email:email',
            'mobilephone',
            //'password_hash',
            [
                'attribute'=>'status',
                'value' => '<span class="'.CssHelper::userStatusCss($model->status).'">
                                '.$model->getStatusName($model->status).'
                            </span>',
                'format' => 'raw'
            ],
            [
                'attribute'=>'item_name',
                'value' => '<span class="'.CssHelper::roleCss($model->getRoleName()).'">
                                '.$model->getRoleName().'
                            </span>',
                'format' => 'raw'
            ],
            //'auth_key',
            //'password_reset_token',
            //'account_activation_token',
            'language.iso_name',
            'created_at:date',
            'updated_at:date',
            'hide_user_icons:boolean',
            [
                'attribute'=>'image',
                'value' => User::getImage($model->id),
                'format' => 'raw'
            ],
        ],
    ]) ?>

</div>
