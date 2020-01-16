<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = Yii::t('app', 'Contact');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="col-md-5 well bs-component">

        <p>
            <?= Yii::t('app', 'If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.'); ?>
        </p>

        <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

            <?= $form->field($model, 'name')->textInput(
                ['placeholder' => Yii::t('app', 'Enter your name'), 'autofocus' => true]) ?>

            <?= $form->field($model, 'email')->input('email', ['placeholder' => Yii::t('app', 'Enter your e-mail')]) ?>

            <?= $form->field($model, 'subject')->textInput(['placeholder' => Yii::t('app', 'Enter the subject')]) ?>

            <?= $form->field($model, 'body')->textArea(['rows' => 6]) ?>
			
			<?php if(Yii::$app->has('reCaptcha3') && strlen(Yii::$app->reCaptcha3->site_key) && strlen(Yii::$app->reCaptcha3->secret_key)){ ?>
				<?= $form->field($model, 'reCaptcha')->widget(\kekaadrenalin\recaptcha3\ReCaptchaWidget::class) ?>
			<?php }else{ ?>
				<?= Html::activeHiddenInput($model, 'reCaptcha') ?>
			<?php } ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Submit'), 
                    ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
            </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
