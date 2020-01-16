<?php
use app\rbac\models\AuthItem;
use kartik\password\PasswordInput;
use yii\helpers\Html;
use kartik\file\FileInput;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\helpers\CssHelper;
use yii\grid\GridView;
use app\models\Language;
use app\models\ActivityType;
use yii\widgets\ActiveField;
$language=Language::findOne(Yii::$app->user->identity->language_id);
$fileVault = substr(Yii::$app->params['fileVaultPath'],strlen(dirname(__DIR__,3)));
/* @var $this yii\web\View */
/* @var $user app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
    <div class="col-md-5 well">
        <div class="user-form">
            <?php $form = ActiveForm::begin(['id' => 'form-user']); ?>
				<?php if($model->isNewRecord && Yii::$app->user->can('theCreator')){ ?>
					<?= $form->field($model, 'church_id')->dropDownList(ArrayHelper::map(app\models\Church::find()->orderBy("name ASC")->all(), 'id', 'name')) ?>
				<?php }else{ ?>
					<?= $form->field($model, 'church_id')->hiddenInput() ?>
				<?php } ?>
                <?= $form->field($model, 'username')->textInput(
                        ['autofocus' => true]) ?>
                <?= $form->field($model, 'display_name')->textInput() ?>

                <?= $form->field($model, 'email')->input('email', ['placeholder' => Yii::t('app', 'Enter e-mail')]) ?>
                <?= $form->field($model, 'mobilephone')->textInput() ?>

                <?php if ($model->scenario === 'create'): ?>

                    <?= $form->field($model, 'password')->widget(PasswordInput::classname(),
                        ['options' => ['placeholder' => Yii::t('app', 'Create password')]]) ?>

                <?php else: ?>

                    <?= $form->field($model, 'password')->widget(PasswordInput::classname(),
                             ['options' => ['placeholder' => Yii::t('app', 'Change password ( if you want )')]]) ?>

                <?php endif ?>

            <div class="row">
                <div class="col-md-12">

                    <?= $form->field($model, 'status')->dropDownList($model->statusList,!Yii::$app->user->can('ChurchAdmin')?['disabled'=>'']:[]) ?>

                    <?php foreach (AuthItem::getRoles() as $item_name): ?>
                        <?php $roles[$item_name->name] = $item_name->name ?>
                    <?php endforeach ?>
                    <?= $form->field($model, 'item_name')->dropDownList($roles,!Yii::$app->user->can('ChurchAdmin')?['disabled'=>'']:[]) ?>

                    <?= $form->field($model, 'hide_user_icons')->checkbox() ?>

                    <?= $form->field($model, 'language_id')->dropDownList(ArrayHelper::map(app\models\Language::find()->where([
                        'church_id' => Yii::$app->user->identity->church_id])->orderBy("display_name_native ASC")->all(), 'id', 'display_name_native')) ?>
<?php $model->abilities = ArrayHelper::map($model->getActivityTypesForUser()->all(),'id','id'); ?>
					<?= $form->field($model, 'abilities')->checkboxList(ArrayHelper::map(ActivityType::getActivityTypesUsingUsers()->all(),'id','name'),['separator'=>'<br />']) ?>









                </div>

            </div>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create')
                    : Yii::t('app', 'Update'), ['class' => $model->isNewRecord
                    ? 'btn btn-success' : 'btn btn-primary']) ?>

                <?= Html::a(Yii::t('app', 'Cancel'), [$returnUrl], ['class' => 'btn btn-default']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

	<?php if(!$model->isNewRecord) { ?>
		<div class="col-md-6" >
			 <div class="col-md-6" align="center">
				<?php if($image) { ?>
					 <h3><?=Yii::t('app', 'Manage your photo')?></h3>
					<img src="<?=Yii::$app->request->baseUrl. $fileVault. DIRECTORY_SEPARATOR .$image->hash?>" class='profilephotofullsize'>
					<?php $form = ActiveForm::begin(['id' => 'form-user2','action'=>$returnUrl=='viewme'?'filedelete':'filedeleteadmin?id='.$model->id]); ?>
					 <?= Html::submitButton(Yii::t('app', 'Delete the photo'), ['class' => 'btn btn-primary']) ?>
					<?php ActiveForm::end(); ?>
				<?php } else { ?>
					<h3><?=Yii::t('app', 'Add a photo of yourself')?></h3>
					<p><?=Yii::t('app', 'A square photo will look the best.')?></p>
					<?php $form = ActiveForm::begin(['id' => 'form-user3','action'=>$returnUrl=='viewme'?'fileupload':'fileuploadadmin?id='.$model->id]); ?>
						<?= $form->field($model, 'imageFiles')->widget(FileInput::classname(), [
							'options' => ['accept' => '*','multiple' => false],
							'language' =>  $language->iso_name,
						]); ?>

					<?php ActiveForm::end(); ?>
				<?php } ?>
			</div>
		</div>
	<?php } ?>
</div>



