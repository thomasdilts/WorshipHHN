<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Language;
use app\models\DocForm;

$this->title = Yii::$app->name;
?>
<div class="site-index">
	<?php if(Yii::$app->params['showWhhnServerOffer']=='true'){ ?>
		<div class="col-lg-6" id="div_wide"  style="display:none;">
			<iframe width="500px" height="280px" src="https://www.youtube.com/embed/_yHIqsgiw8k" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>	
		</div>	
		<div class="col-lg-6" id="div_thin"  style="display:none;">
			<iframe width="100%" src="https://www.youtube.com/embed/_yHIqsgiw8k" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>	
		</div>	
	<?php } ?>	
    <div class="<?=Yii::$app->params['showWhhnServerOffer']=='true'?'col-lg-6':'jumbotron'?>">
		<span class="pull-right" style="">		
			<?php if(Yii::$app->user->isGuest){ ?>
				<?php $form = ActiveForm::begin(['id' => 'form-home']); ?>
					<?= $form->field($model, 'language_iso_name')->dropDownList(DocForm::getLanguages(),['onChange'=>'this.form.submit();']) ?>
				<?php ActiveForm::end(); ?>
			<?php } ?>		
		</span>	 
		<div class="jumbotron">
			<h2  style="font-size:3.0em"><?=Yii::t('app', 'Welcome to')?><br /> Worship H<span style="font-size:0.3em">is</span>H<span style="font-size:0.3em">oly</span>N<span style="font-size:0.3em">ame</span></h2>
			(<?=Yii::t('app', 'Worship His Holy Name')?>)
			<p class="lead"><?=Yii::t('app', 'A worship service planner and organizer')?></p>
		</div>
    </div>

    <div class="body-content">
        <div class="row">
            <div class="col-lg-4">
                <h3><a style="display:block;" href="<?=URL::toRoute('doc/doc')?>?page=features&returnName=<?=Yii::t('app', "Features")?>&returnUrl=<?=URL::toRoute('home')?>%3Fpage%3Dhome%26returnName%3D<?=Yii::t('app', "Home")?>%26returnUrl%3D<?=URL::toRoute('site/home')?>&lang=<?=$model->language_iso_name?>">
					<?= Html::encode(Yii::t('app', "Features")) ?></a></h3>
            </div>
            <div class="col-lg-4">
                <h3><a style="display:block;" href="<?=URL::toRoute('doc/doc')?>?page=screenshots&returnName=<?=Yii::t('app', "Screenshots")?>&returnUrl=<?=URL::toRoute('home')?>%3Fpage%3Dhome%26returnName%3D<?=Yii::t('app', "Home")?>%26returnUrl%3D<?=URL::toRoute('site/home')?>&lang=<?=$model->language_iso_name?>">
					<?= Html::encode(Yii::t('app', "Screenshots")) ?></a></h3>
            </div>
            <div class="col-lg-4">
                <h3><a style="display:block;" href="<?=URL::toRoute('doc/doc')?>?page=home&returnName=<?=Yii::t('app', "Home")?>&returnUrl=<?=URL::toRoute('home')?>%3Fpage%3Dhome%26returnName%3D<?=Yii::t('app', "Home")?>%26returnUrl%3D<?=URL::toRoute('site/home')?>&lang=<?=$model->language_iso_name?>">
					<?= Html::encode(Yii::t('app', "Documentation")) ?></a></h3>
            </div>
        </div>
		<?php if(Yii::$app->params['showWhhnServerOffer']=='true'){ ?>
        <div class="row">
            <div class="col-lg-4">
                <h3><?=Yii::t('app', 'Cost')?></h3>

                <p><?=Yii::t('app', 'Free and open source if you put the program on your own server. Because this software is for churches we try to keep all our services free of charge.')?></p>
            </div>
            <div class="col-lg-4">
                <h3><?=Yii::t('app', 'Test on our server')?></h3>

                <p><?=Yii::t('app', 'Test it on our server free for three months. After three months we can either extend or discuss a more permanent solution for you that will normally involve moving over to your own domain and web hotel. Write to us in the contact menu above to request a test site.')?></p>
            </div>
            <div class="col-lg-4">
                <h3><?=Yii::t('app', 'License')?></h3>

                <p><a href="https://www.gnu.org/licenses/gpl-3.0.en.html"><?=Yii::t('app', 'GPLv3')?></a>. <?=Yii::t('app', 'The GNU General Public License is a free, copyleft license for software and other kinds of works.')?></p>
            </div>
        </div>
		<?php } ?>
		<div class="row jumbotron">
			<div class="col-lg-5">
				<p>
				<?=Yii::t('app', 'WorshipHHN is designed to fit into whatever device you are using. Larger screens allow you to see the bigger picture but smaller screens can accomplish the same thing and are conveniently found in your pocket.')?>
				</p>
			</div>
			<div class="col-lg-5">
				<p>
				<img src="<?=Yii::$app->request->baseUrl?>/images/alldevices.png" style="max-width: 100%;max-height: 100%;" />
				</p>
			</div>
		</div>	
    </div>
</div>
<?php if(Yii::$app->params['showWhhnServerOffer']=='true'){ ?>
	<script>
		function showThinScreen(){
			if($(window).outerWidth()<768){
				$( "#div_wide" ).hide();
				$( "#div_thin" ).show();
			}
			else{
				$( "#div_wide" ).show();
				$( "#div_thin" ).hide();
			}		
		}
		$( document ).ready(function() {
			showThinScreen();
			$( window ).on('resize', function() {
				showThinScreen();
			});
		});

	</script>
<?php } ?>	
