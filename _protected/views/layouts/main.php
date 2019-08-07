<?php
/* @var $this \yii\web\View */
/* @var $content string */
use app\assets\AppAsset;
use app\models\Church;
use app\models\Language;
use app\models\User;
use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
$lang = Yii::$app->request->$queryParams['lang'];
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>

    <script src="<?=Yii::$app->request->baseUrl?>/themes/jquery.min.js"></script> 
    <script src="<?=Yii::$app->request->baseUrl?>/themes/jquery.ddslick.min.js"></script> 
    <script src="<?=Yii::$app->request->baseUrl?>/themes/select2/js/select2.js"></script> 
	<link rel="stylesheet" type="text/css" href="<?=Yii::$app->request->baseUrl?>/themes/select2/css/select2.css">

	<link rel="icon" href="<?=Yii::$app->request->baseUrl?>/images/favicon-32x32.png" sizes="32x32" />
	<link rel="icon" href="<?=Yii::$app->request->baseUrl?>/images/favicon-192x192.png" sizes="192x192" />
	<link rel="apple-touch-icon-precomposed" href="<?=Yii::$app->request->baseUrl?>/images/favicon-180x180.png" />	
    <link href='https://fonts.googleapis.com/css?family=Ubuntu:400,700' rel='stylesheet' type='text/css'>
    <?php $this->head() ?>
	
</head>
<body>
<?php 
$title="WorshipHHN";
if(Yii::$app->user!=null && Yii::$app->user->identity!=null)
{
	$church = Church::findOne(Yii::$app->user->identity->church_id);
	if($church!=null)
	{
		$title=$church->name;
	}
}
$this->beginBody() ?>
<div class="wrap">
    <?php
	NavBar::begin([
        'brandLabel' => '<img src="'.Yii::$app->request->baseUrl.'/images/logo-icon.png" style="height:40px;float:left;margin-right: 5px;margin-top: -10px"/> '.$title ,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-default navbar-fixed-top',
        ],
    ]);

    // everyone can see Home page
    $menuItems[] = ['label' => '<span class="glyphicon glyphicon-home" aria-hidden="true"></span> '.Yii::t('app', 'Home'), 'url' => ['/site/home','lang'=>$lang]];

    // we do not need to display Contact pages to employee+ roles
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => Yii::t('app', 'Documentation'), 'url' => ['/doc/doc','page'=>'home','returnName'=>'home','returnUrl'=>'/site/home','lang'=>$lang]];
        $menuItems[] = ['label' => Yii::t('app', 'Contact'), 'url' => ['/site/contact','lang'=>$lang]];
    }
	else{
        $menuItems[] = ['label' => '<span class="glyphicon glyphicon-tasks" aria-hidden="true"></span> '.Yii::t('app', 'Events'), 'url' => ['/event/index']];
        $menuItems[] = ['label' => '<span class="glyphicon glyphicon-tower" aria-hidden="true"></span> '.Yii::t('app', 'Teams'), 'url' => ['/team/index']];
	}
    if (Yii::$app->user->can('EventEditor')){
        $menuItems[] = ['label' => '<span class="glyphicon glyphicon-volume-up" aria-hidden="true"></span> '.Yii::t('app', 'Songs'), 'url' => ['/song/index']];
    }

    if (Yii::$app->user->can('ChurchAdmin')){
        $menuItems[] = ['label' => '<span class="glyphicon glyphicon-cog" aria-hidden="true"></span> '.Yii::t('app', 'Admin'),
			'items' => 
				[
					['label' => Yii::t('app', 'Users'), 'url' => ['/user/index']],
					['label' => Yii::t('app', 'Team types'), 'url' => ['/team-type/index']],
                    ['label' => Yii::t('app', 'Task templates'), 'url' => ['/activity-type/index']],
                    ['label' => Yii::t('app', 'Message templates'), 'url' => ['/message-template/index']],
                    ['label' => Yii::t('app', 'Message types'), 'url' => ['/message-type/index']],
					['label' => Yii::t('app', 'Languages'), 'url' => ['/language/index']],
					['label' => Yii::t('app', 'Churches'), 'url' => Yii::$app->user->can('theCreator')?['/church/index']:['/church/update?id='.Yii::$app->user->identity->church_id]],
				],
			];
    }
    
    // display Logout to logged in users
	/*
    if (!Yii::$app->user->isGuest) {
        $menuItems[] = [
            'label' => Yii::t('app', 'Logout'). ' (' . Yii::$app->user->identity->username . ')',
            'url' => ['/site/logout'],
            'linkOptions' => ['data-method' => 'post']
        ];
    }*/

    // display Signup and Login pages to guests of the site
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => Yii::t('app', 'Signup'), 'url' => ['/site/signup','lang'=>$lang]];
        $menuItems[] = ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login','lang'=>$lang]];
    }
	else {
		$menuItems[] = ['label' => '<span class="glyphicon glyphicon-user" aria-hidden="true"></span> '. Yii::$app->user->identity->display_name,
			'items' => 
				[
					['label' => '<span class="glyphicon glyphicon-briefcase" aria-hidden="true"></span> '.Yii::t('app', 'Profile'), 'url' => ['/user/viewme']],
					['label' => '<span class="glyphicon glyphicon-tasks" aria-hidden="true"></span> '.Yii::t('app', 'Tasks'), 'url' => ['/user/tasks','id'=>Yii::$app->user->identity->id]],
					['label' => '<span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span> '.Yii::t('app', 'Unavailability'), 'url' => ['/user-blocked/index','id'=>Yii::$app->user->identity->id]],
					['label' => '<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> ' . Yii::t('app', 'Documentation'), 'url' => ['/doc/doc','page'=>'home','returnName'=>'home','returnUrl'=>'/site/home']],
					'<li class="divider"></li>',
					['label' => '<i class="glyphicon glyphicon-off"></i> '.Yii::t('app', 'Sign Out'),
						'url' => ['/site/logout'],
						'linkOptions' => ['data-method' => 'post']],
				],
			];
	}
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
		'encodeLabels' => false,
        'items' => $menuItems,
    ]);

 
    NavBar::end();

    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?> 
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Yii::$app->name ?> <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
