<?php
use app\rbac\models\AuthItem;
use app\models\EventTemplate;
use app\models\PictureActivitySearch;
use app\models\PictureSearch;
use app\models\Song;
use app\models\File;
use app\models\BibleVerse;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use nex\datepicker\DatePicker;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use app\models\Language;
$language=Language::findOne(Yii::$app->user->identity->language_id);
$GLOBALS['fileVault'] = substr(Yii::$app->params['fileVaultPath'],strlen(dirname(__DIR__,3)));

$this->title = Yii::t('app', 'Update event task') . ': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Event'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelEvent->name . ' ' . Yii::$app->formatter->asDate($modelEvent->start_date, "Y-MM-dd H:mm"), 'url' => ['event/activities','id'=>$modelEvent->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Task');
$this->params['breadcrumbs'][] = $model->name;
$GLOBALS['activityid']=$model->id;
$GLOBALS['eventid']=$modelEvent->id;


?>
<div class="team-type-update">

    <h1>
    	<?= Html::encode($this->title) ?>
        <span class="pull-right" style="margin-bottom:5px;display:inline-block">
			<a href="<?=urldecode($returnurl)?>" class='btn btn-warning'><span class="glyphicon glyphicon-step-backward"></span><?=Yii::t('app', 'Return')?></a>   	
        </span>    
    </h1>

	<div class="row">

		<div class="col-lg-6">

		<?php $form = ActiveForm::begin(['id' => 'form-activity']); ?>

			<?= $form->field($model, 'name')->textInput(
					['placeholder' => '', 'autofocus' => true]) ?>
			<?php if($modelActivityType->description!='Not used'){ ?>
				<?= $form->field($model, 'description')->textArea(
					['placeholder' => Yii::t('app', 'Add a description'), 'autofocus' => true]) ?>
			<?php } ?>	
			<?php if(!$modelActivityType->use_globally){ ?>
				<?= $form->field($model, 'start_time')->widget(
					DatePicker::className(), [
						'addon' => false,
						'size' => 'sm',			
						'language'=>Language::getLanguageIsoNameForCalendar($language),		
						'clientOptions' => [
							'format' => 'H:mm',
							'stepping' => 1,
						],
				]);?>
				<?= $form->field($model, 'duration')->textInput() ?>
			<?php }else{ ?>
				<?= $form->field($model, 'global_order')->textInput(
						['placeholder' => Yii::t('app', 'Global order')]) ?>	
			<?php } ?>		
			<?php if($modelActivityType->using_team!='Not used'){ ?>
				<?= $form->field($model, 'team_id')->dropDownList(ArrayHelper::map(app\models\Team::find()->where([
					'team_type_id' => $modelActivityType->team_type_id])->orderBy("name ASC")->all(), 'id', 'name'),['prompt' => Yii::t('app', 'Select'),'onChange'=>'showHideFreehandTeam();']) ?>
				<?php if($modelActivityType->allow_freehand_team){ ?>
					<?= $form->field($model, 'freehand_team')->textInput() ?>
				<?php } ?>
			<?php } ?>	
			<?php if($modelActivityType->using_user!='Not used'){ ?>
				<?= $form->field($model, 'user_id')->hiddenInput() ?>

				<select id="ddslick-user_id" class="form-control" name="ddslick" aria-invalid="false">
					<option value=""><?=Yii::t('app', 'Select')?></option>
				<?php 
				$users=$modelActivityType->getUsersForActivityType()->all();
				if($users==null || count($users)==0){
					$users=app\models\User::find()->where(['church_id' => $modelEvent->church_id])->orderBy("display_name ASC")->all();
				}
				$rowCounter=1;
				$fileVault = substr(Yii::$app->params['fileVaultPath'],strlen(dirname(__DIR__,3)));
				foreach($users as $user){ 
					$file=File::findOne(['model'=>'user','itemId'=>$user->id]);	
					if($user->id==$model->user_id){$selectedUserIndex=$rowCounter;}
					$rowCounter++; ?>
					<option data-imagesrc="<?=$file?Yii::$app->request->baseUrl. $fileVault. DIRECTORY_SEPARATOR .$file->hash:''?>" data-description="<?=$user->email ?>" value="<?=$user->id ?>"><?=$user->display_name ?></option>

				<?php } ?>

				</select>
				<?php if($modelActivityType->allow_freehand_user){ ?>
					<?= $form->field($model, 'freehand_user')->textInput() ?>
				<?php } ?>
				
				<?php if( Yii::$app->user->can('EventManager')){ ?>
					<?= Html::a(Yii::t('app', 'Find volunteers'), ['event/volunteers?eventid='.$modelEvent->id.'&userid=0&actionid='.$model->id.''], ['class' => 'btn btn-success','style'=>'margin-top:40px;margin-bottom:40px;']) ?>
				<?php } ?>	

			<?php } ?>				
			<?php if($modelActivityType->using_song!='Not used'){ ?>
				<?= $form->field($model, 'song_id')->textInput(
					['value'=>$model->song_id!=null && $model->song_id!=0 ? Song::findOne($model->song_id)->name:'' ,'disabled' => true]) ?>
			<?php } ?>	
			
			<?php if($modelActivityType->bible_verse!='Not used'){ ?>
				<?=  Html::activeHiddenInput($model, 'bible_verse'); ?>
			<?php } ?>	
			
			<div class="form-group" style="margin-top:20px;">     
				<?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-primary']) ?>

				<?= Html::a(Yii::t('app', 'Cancel'), [urldecode($returnurl)], ['class' => 'btn btn-default']) ?>
			</div>

		<?php ActiveForm::end(); ?>

    </div>
	<?php if($modelActivityType->using_song !='Not used'){ ?>
		<div class="col-lg-6">
			<h3><?= Html::encode( Yii::t('app', 'Select Song')) ?></h3>
			<?= GridView::widget([
			'dataProvider' => $dataProvider,
			'filterModel' => $searchModel,
			'summary' => false,
			'columns' => [
				'name',
				'name2',
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
				'template' => '{selectsong}',
					'buttons' => [
						'selectsong' => function ($url, $model, $key) {
							return Html::a('', $url. '&activityid='.$GLOBALS['activityid']. '&eventid='.$GLOBALS['eventid'], ['title'=>Yii::t('app', 'Select song for task'), 'class'=>'glyphicon glyphicon-check']);
						},
					]

				], // ActionColumn

			], // columns

		]); ?>	
		</div>
	<?php } ?>		
	<?php if($modelActivityType->bible_verse!='Not used'){ ?>
		<div class="col-lg-6 well" style="margin-top:30px;">
			<?= Html::dropDownList('book', '-1', BibleVerse::getBibleBookArrayForSelection(),['id'=>'book']) ?>
			<select disabled id="chapter">

			</select>
			:
			<select disabled id="verse">

			</select>
			<?=Yii::t('app', 'To')?>
			<select disabled id="toverse">

			</select>
			<button disabled id="add"><?=Yii::t('app', 'Add')?></button>

			<div style="display:block;" id="displaybibleverses"></div>		
		</div>	
	<?php } ?>	
	<?php if($modelActivityType->file!='Not used'){ ?>
		<div class="col-lg-6">
			<?= $this->render('../_file', [
				'model' => $model,
				'dataProvider' => $fileDataProvider,
				'searchModel' => $fileSearchModel,
				'urlAddition' => '&fileownerid='.$model->id.'&eventid='.$modelEvent->id,
				'filedownloadUrl' => 'fileactivitydownload',
				'backurl' => 'activities?id='.$modelEvent->id,
				'deletefileUrl' => 'deleteactivityfile']) ?>		
		</div>
	 <?php } ?>	
	 </div>
<?php if($modelActivityType->using_picture!='Not used'){ ?>
	<div class="row">
		<div class="col-lg-6">	
			<h1>
				<?= Html::encode( Yii::t('app', 'Chosen pictures')) ?> 		
			</h1>	
			<?= GridView::widget([
				'dataProvider' => $pictureDataProvider,

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
					'template' => '{deletepicture}',
						'buttons' => [
							'deletepicture' => function ($url, $model, $key) {
								return Html::a('', $url. '&activityid='.$GLOBALS['activityid']. '&eventid='.$GLOBALS['eventid'], ['title'=>Yii::t('app', 'Remove picture from the task'), 'class'=>'glyphicon glyphicon-trash menubutton']);
							},
						]

					], // ActionColumn

				], // columns

			]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6">	
				<h1>
					<?= Html::encode( Yii::t('app', 'Add pictures')) ?> 		
				</h1>	
				<?= GridView::widget([
					'dataProvider' => $allPictureDataProvider,
					'filterModel' => $allPictureSearchModel,
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
						'template' => '{addpicture}',
							'buttons' => [
								'addpicture' => function ($url, $model, $key) {
									return Html::a('', $url. '&activityid='.$GLOBALS['activityid']. '&eventid='.$GLOBALS['eventid'], ['title'=>Yii::t('app', 'Select picture for the task'), 'class'=>'glyphicon glyphicon-check']);
								},
							]

						], // ActionColumn

					], // columns

				]); ?>
		</div>
	</div>		
		
		
		
	 <?php } ?>		 
</div>

<script>

var chaptersInBook=[50,40,27,36,34,24,21,4,31,24,22,25,29,36,10,13,10,42,150,
	31,12,8,66,52,5,48,12,14,3,9,1,4,7,3,3,3,2,14,4,28,16,24,21,28,16,16,13,
	6,6,4,4,5,3,6,4,3,1,13,5,5,3,5,1,1,1,22];
var versesInChapter =
[
            // Genesis
            31, 25, 24, 26, 32, 22, 24, 22, 29, 32,
            32, 20, 18, 24, 21, 16, 27, 33, 38, 18,
            34, 24, 20, 67, 34, 35, 46, 22, 35, 43,
            55, 32, 20, 31, 29, 43, 36, 30, 23, 23,
            57, 38, 34, 34, 28, 34, 31, 22, 33, 26,
            // Exodus
            22, 25, 22, 31, 23, 30, 25, 32, 35, 29,
            10, 51, 22, 31, 27, 36, 16, 27, 25, 26,
            36, 31, 33, 18, 40, 37, 21, 43, 46, 38,
            18, 35, 23, 35, 35, 38, 29, 31, 43, 38,
            // Leviticus
            17, 16, 17, 35, 19, 30, 38, 36, 24, 20,
            47, 8, 59, 57, 33, 34, 16, 30, 37, 27,
            24, 33, 44, 23, 55, 46, 34,
            // Numbers
            54, 34, 51, 49, 31, 27, 89, 26, 23, 36,
            35, 16, 33, 45, 41, 50, 13, 32, 22, 29,
            35, 41, 30, 25, 18, 65, 23, 31, 40, 16,
            54, 42, 56, 29, 34, 13,
            // Deuteronomy
            46, 37, 29, 49, 33, 25, 26, 20, 29, 22,
            32, 32, 18, 29, 23, 22, 20, 22, 21, 20,
            23, 30, 25, 22, 19, 19, 26, 68, 29, 20,
            30, 52, 29, 12,
            // Joshua
            18, 24, 17, 24, 15, 27, 26, 35, 27, 43,
            23, 24, 33, 15, 63, 10, 18, 28, 51, 9,
            45, 34, 16, 33,
            // Judges
            36, 23, 31, 24, 31, 40, 25, 35, 57, 18,
            40, 15, 25, 20, 20, 31, 13, 31, 30, 48,
            25,
            // Ruth
            22, 23, 18, 22,
            // I Samuel
            28, 36, 21, 22, 12, 21, 17, 22, 27, 27,
            15, 25, 23, 52, 35, 23, 58, 30, 24, 42,
            15, 23, 29, 22, 44, 25, 12, 25, 11, 31,
            13,
            // II Samuel
            27, 32, 39, 12, 25, 23, 29, 18, 13, 19,
            27, 31, 39, 33, 37, 23, 29, 33, 43, 26,
            22, 51, 39, 25,
            // I Kings
            53, 46, 28, 34, 18, 38, 51, 66, 28, 29,
            43, 33, 34, 31, 34, 34, 24, 46, 21, 43,
            29, 53,
            // II Kings
            18, 25, 27, 44, 27, 33, 20, 29, 37, 36,
            21, 21, 25, 29, 38, 20, 41, 37, 37, 21,
            26, 20, 37, 20, 30,
            // I Chronicles
            54, 55, 24, 43, 26, 81, 40, 40, 44, 14,
            47, 40, 14, 17, 29, 43, 27, 17, 19, 8,
            30, 19, 32, 31, 31, 32, 34, 21, 30,
            // II Chronicles
            17, 18, 17, 22, 14, 42, 22, 18, 31, 19,
            23, 16, 22, 15, 19, 14, 19, 34, 11, 37,
            20, 12, 21, 27, 28, 23, 9, 27, 36, 27,
            21, 33, 25, 33, 27, 23,
            // Ezra
            11, 70, 13, 24, 17, 22, 28, 36, 15, 44,
            // Nehemiah
            11, 20, 32, 23, 19, 19, 73, 18, 38, 39,
            36, 47, 31,
            // Esther
            22, 23, 15, 17, 14, 14, 10, 17, 32, 3,
            // Job
            22, 13, 26, 21, 27, 30, 21, 22, 35, 22,
            20, 25, 28, 22, 35, 22, 16, 21, 29, 29,
            34, 30, 17, 25, 6, 14, 23, 28, 25, 31,
            40, 22, 33, 37, 16, 33, 24, 41, 30, 24,
            34, 17,
            // Psalms
            6, 12, 8, 8, 12, 10, 17, 9, 20, 18,
            7, 8, 6, 7, 5, 11, 15, 50, 14, 9,
            13, 31, 6, 10, 22, 12, 14, 9, 11, 12,
            24, 11, 22, 22, 28, 12, 40, 22, 13, 17,
            13, 11, 5, 26, 17, 11, 9, 14, 20, 23,
            19, 9, 6, 7, 23, 13, 11, 11, 17, 12,
            8, 12, 11, 10, 13, 20, 7, 35, 36, 5,
            24, 20, 28, 23, 10, 12, 20, 72, 13, 19,
            16, 8, 18, 12, 13, 17, 7, 18, 52, 17,
            16, 15, 5, 23, 11, 13, 12, 9, 9, 5,
            8, 28, 22, 35, 45, 48, 43, 13, 31, 7,
            10, 10, 9, 8, 18, 19, 2, 29, 176, 7,
            8, 9, 4, 8, 5, 6, 5, 6, 8, 8,
            3, 18, 3, 3, 21, 26, 9, 8, 24, 13,
            10, 7, 12, 15, 21, 10, 20, 14, 9, 6,
            // Proverbs
            33, 22, 35, 27, 23, 35, 27, 36, 18, 32,
            31, 28, 25, 35, 33, 33, 28, 24, 29, 30,
            31, 29, 35, 34, 28, 28, 27, 28, 27, 33,
            31,
            // Ecclesiastes
            18, 26, 22, 16, 20, 12, 29, 17, 18, 20,
            10, 14,
            // Song of Solomon
            17, 17, 11, 16, 16, 13, 13, 14,
            // Isaiah
            31, 22, 26, 6, 30, 13, 25, 22, 21, 34,
            16, 6, 22, 32, 9, 14, 14, 7, 25, 6,
            17, 25, 18, 23, 12, 21, 13, 29, 24, 33,
            9, 20, 24, 17, 10, 22, 38, 22, 8, 31,
            29, 25, 28, 28, 25, 13, 15, 22, 26, 11,
            23, 15, 12, 17, 13, 12, 21, 14, 21, 22,
            11, 12, 19, 12, 25, 24,
            // Jeremiah
            19, 37, 25, 31, 31, 30, 34, 22, 26, 25,
            23, 17, 27, 22, 21, 21, 27, 23, 15, 18,
            14, 30, 40, 10, 38, 24, 22, 17, 32, 24,
            40, 44, 26, 22, 19, 32, 21, 28, 18, 16,
            18, 22, 13, 30, 5, 28, 7, 47, 39, 46,
            64, 34,
            // Lamentations
            22, 22, 66, 22, 22,
            // Ezekiel
            28, 10, 27, 17, 17, 14, 27, 18, 11, 22,
            25, 28, 23, 23, 8, 63, 24, 32, 14, 49,
            32, 31, 49, 27, 17, 21, 36, 26, 21, 26,
            18, 32, 33, 31, 15, 38, 28, 23, 29, 49,
            26, 20, 27, 31, 25, 24, 23, 35,
            // Daniel
            21, 49, 30, 37, 31, 28, 28, 27, 27, 21,
            45, 13,
            // Hosea
            11, 23, 5, 19, 15, 11, 16, 14, 17, 15,
            12, 14, 16, 9,
            // Joel
            20, 32, 21,
            // Amos
            15, 16, 15, 13, 27, 14, 17, 14, 15,
            // Obadiah
            21,
            // Jonah
            17, 10, 10, 11,
            // Micah
            16, 13, 12, 13, 15, 16, 20,
            // Nahum
            15, 13, 19,
            // Habakkuk
            17, 20, 19,
            // Zephaniah
            18, 15, 20,
            // Haggai
            15, 23,
            // Zechariah
            21, 13, 10, 14, 11, 15, 14, 23, 17, 12,
            17, 14, 9, 21,
            // Malachi
            14, 17, 18, 6,
            // -----------------------------------------------------------------
            // Matthew
            25, 23, 17, 25, 48, 34, 29, 34, 38, 42,
            30, 50, 58, 36, 39, 28, 27, 35, 30, 34,
            46, 46, 39, 51, 46, 75, 66, 20,
            // Mark
            45, 28, 35, 41, 43, 56, 37, 38, 50, 52,
            33, 44, 37, 72, 47, 20,
            // Luke
            80, 52, 38, 44, 39, 49, 50, 56, 62, 42,
            54, 59, 35, 35, 32, 31, 37, 43, 48, 47,
            38, 71, 56, 53,
            // John
            51, 25, 36, 54, 47, 71, 53, 59, 41, 42,
            57, 50, 38, 31, 27, 33, 26, 40, 42, 31,
            25,
            // Acts
            26, 47, 26, 37, 42, 15, 60, 40, 43, 48,
            30, 25, 52, 28, 41, 40, 34, 28, 41, 38,
            40, 30, 35, 27, 27, 32, 44, 31,
            // Romans
            32, 29, 31, 25, 21, 23, 25, 39, 33, 21,
            36, 21, 14, 23, 33, 27,
            // I Corinthians
            31, 16, 23, 21, 13, 20, 40, 13, 27, 33,
            34, 31, 13, 40, 58, 24,
            // II Corinthians
            24, 17, 18, 18, 21, 18, 16, 24, 15, 18,
            33, 21, 14,
            // Galatians
            24, 21, 29, 31, 26, 18,
            // Ephesians
            23, 22, 21, 32, 33, 24,
            // Philippians
            30, 30, 21, 23,
            // Colossians
            29, 23, 25, 18,
            // I Thessalonians
            10, 20, 13, 18, 28,
            // II Thessalonians
            12, 17, 18,
            // I Timothy
            20, 15, 16, 16, 25, 21,
            // II Timothy
            18, 26, 17, 22,
            // Titus
            16, 15, 15,
            // Philemon
            25,
            // Hebrews
            14, 18, 19, 16, 14, 20, 28, 13, 28, 39,
            40, 29, 25,
            // James
            27, 26, 18, 17, 20,
            // I Peter
            25, 25, 22, 19, 14,
            // II Peter
            21, 22, 18,
            // I John
            10, 29, 24, 21, 21,
            // II John
            13,
            // III John
            14,
            // Jude
            25,
            // Revelation of John
            20, 29, 22, 11, 14, 17, 17, 13, 21, 11,
            19, 17, 18, 20, 8, 21, 18, 24, 21, 15,
            27, 21
];

function populateChapter(book) {
	$("#chapter").children().remove();
	$("#chapter").prop("disabled", true);
	$("#verse").children().remove();
	$("#verse").prop("disabled", true);
	$("#toverse").children().remove();
	$("#toverse").prop("disabled", true);
	
	$("#add").prop("disabled", true);
	if (book == "-1") {
        return;
    }
	book=parseInt(book);
    $("#chapter").prop("disabled", false);

    $("#chapter").children().remove();
	$("<option/>", {
			id:'erasemechapter',
			value: -1,
			text: "<?=Yii::t('app', 'Chapter')?>"
		}).appendTo("#chapter");	 
	//get the number of chapters to the start of this book
	var chaptersBeforeBook=0;
	for(i=0;i<book;i++){
		chaptersBeforeBook+=chaptersInBook[i];
	}	
	// write out select statement
	for(i=chaptersBeforeBook;i<chaptersBeforeBook+chaptersInBook[book];i++){
		$("<option/>", {
				value: i,
				text: (i+1-chaptersBeforeBook)
			}).appendTo("#chapter");
	}
}
function populateVerse(chapter) {
	$("#verse").children().remove();
	$("#verse").prop("disabled", true);
	$("#toverse").children().remove();
	$("#toverse").prop("disabled", true);
	
	$("#add").prop("disabled", true);
    if (chapter == "-1") {
        return;
    }
	chapter=parseInt(chapter);
	$("#erasemechapter").remove();
	$("#add").prop("disabled", false);
    $("#verse").prop("disabled", false);

    $("#verse").children().remove();
	$("<option/>", {
			id:'erasemeverse',
			value: -1,
			text: "<?=Yii::t('app', 'Verse')?>"
		}).appendTo("#verse");	
	for(i=0;i<versesInChapter[chapter];i++){
		$("<option/>", {
				value: i,
				text: (i+1)
			}).appendTo("#verse");
	}
}
function populateToVerse(verse,chapter) {
	$("#toverse").children().remove();
	$("#toverse").prop("disabled", true);
    if (verse == "-1") {
        return;
    }
	verse=parseInt(verse);
	chapter=parseInt(chapter);
	$("#erasemeverse").remove();
    $("#toverse").children().remove();
	$("#toverse").prop("disabled", false);
	$("<option/>", {
			id:'erasemetoverse',
			value: -1,
			text: "<?=Yii::t('app', 'To verse')?>"
		}).appendTo("#toverse");	
	for(i=parseInt(verse)+1;i<versesInChapter[chapter];i++){
		$("<option/>", {
				value: i,
				text: (i+1)
			}).appendTo("#toverse");
	}
}
function AddToDisplay(book,chapter,verse,toverse) {
    //var bookText = $("#book"+book).text();
	//var bookText = $('#book :option[value="' + book + '"]').text();
	var bookText = $('#book').children('option').filter(function(){return this.value==book}).text();
	var chaptersBeforeBook=0;
	for(var i=0;i<book;i++){
		chaptersBeforeBook+=chaptersInBook[i];
	}	
	var id=makeid(20)
	var div = $("<div/>", {
			class: 'bibleverse',
			value: i,
			id:id,
			'data-en': book + "," + chapter + "," + verse  + "," +  toverse,
			text: bookText + " " + (chapter+1-chaptersBeforeBook) + ":" + (verse+1) + (toverse>=0?"-" + (toverse+1):"")
		});
	div.appendTo("#displaybibleverses");	
	$("<button/>", {
			onClick: "$('#' + $( this ).attr('name')).remove();writeOutputText();",
			text: 'X',
			name: id,
			class: 'bibleversebutton',
		}).appendTo(div);
	$("<button/>", {
			onClick: "moveUp($('#' + $( this ).attr('name')));",
			text: "<?=Yii::t('app', 'up')?>",
			name: id,
			class: 'bibleversebutton',
		}).appendTo(div);
	$("<button/>", {
			onClick: "moveDown($('#' + $( this ).attr('name')));",
			text: "<?=Yii::t('app', 'down')?>",
			name: id,
			class: 'bibleversebutton',
		}).appendTo(div);
	writeOutputText();	
}
function makeid(length) {
   var result           = '';
   var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
   var charactersLength = characters.length;
   for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
   }
   return result;
}
function moveUp(element) {
	if(getTextNode(element.prev())!=undefined){
		var text = getTextNode(element.prev()).nodeValue;
		var data = element.prev().attr('data-en');
		getTextNode(element.prev()).nodeValue = getTextNode(element).nodeValue;
		getTextNode(element).nodeValue=text;
		
		element.prev().attr('data-en', element.attr('data-en'));
		element.attr('data-en', data);

		writeOutputText();
	}
}
function moveDown(element) {
	if(getTextNode(element.next())!=undefined){
		var text = getTextNode(element.next()).nodeValue;
		var data = element.next().attr('data-en');
		getTextNode(element.next()).nodeValue = getTextNode(element).nodeValue;
		getTextNode(element).nodeValue=text;
		
		element.next().attr('data-en', element.attr('data-en'));
		element.attr('data-en', data);
		
		writeOutputText();
	}
}
function getTextNode(element){
	return element.contents()
    .filter(function() {
      return this.nodeType === 3;
    })[0];
}
function writeOutputText(){
	//$('#output').text('');
	var allTexts='';
	$('#displaybibleverses').children('div').each(function() {
		//this.firstChild.textContent 
		if(allTexts.length>0)allTexts+=";";
		allTexts += this.getAttribute('data-en');
	});
	$('#activity-bible_verse').val(allTexts);
}
function startupRepopulate(data){
	if(data.length==0){
		return
	}
	var elements = data.split(';');
	for(var i=0;i<elements.length;i++){
		var parts = elements[i].split(',');
		if(parts.length!=4){
			continue;
		}
		AddToDisplay(parseInt(parts[0]),parseInt(parts[1]),parseInt(parts[2]),parseInt(parts[3]));
	}
}
function showHideFreehandTeam(){
	if($('#activity-team_id').val() || $('#activity-team_id').val().length>0){
		$( "#activity-freehand_team" ).prop( "disabled", true );
		$( "#activity-freehand_team" ).val('');
	}else{
		$( "#activity-freehand_team" ).prop( "disabled", false );
	}
}
function showHideFreehandUser(){
	if($('#activity-user_id').val() || $('#activity-user_id').val().length>0){
		$( "#activity-freehand_user" ).prop( "disabled", true );
		$( "#activity-freehand_user" ).val('');
	}else{
		$( "#activity-freehand_user" ).prop( "disabled", false );
	}
}
$('#ddslick-user_id').ddslick({
	height:400,
	onSelected: function (data) {
		$('#activity-user_id').val(data.selectedData.value);
		<?php if($modelActivityType->using_user!='Not used' && $modelActivityType->allow_freehand_user){ ?>
			showHideFreehandUser();
		<?php } ?>
	}
});
<?php if(isset($selectedUserIndex)){ ?>
	$('#ddslick-user_id').ddslick('select', {index: <?= $selectedUserIndex ?> }); 
<?php } ?>
$(document).ready(function () {
	<?php if($modelActivityType->using_team!='Not used' && $modelActivityType->allow_freehand_team){ ?>
		showHideFreehandTeam();
	<?php } ?>		
	<?php if($modelActivityType->using_user!='Not used' && $modelActivityType->allow_freehand_user){ ?>
		showHideFreehandUser();
	<?php } ?>		
    var book = $("#book").val();
    populateChapter(book);
    $("#book").change(function () {
        book = $("#book").val();
        populateChapter(book);
    });
	$("#chapter").change(function () {
        chapter = $("#chapter").val();
        populateVerse(chapter);
    });
	$("#verse").change(function () {
        verse = $("#verse").val();
		chapter = $("#chapter").val();
        populateToVerse(verse,chapter);
    });
    $("#add").click(function () {
		var book = parseInt($("#book").val());
		var chapter = parseInt($("#chapter").val());
		var verse = parseInt($("#verse").val());
		var toverse = parseInt($("#toverse").val());		
        AddToDisplay(book,chapter,verse,toverse);
    })
	startupRepopulate($('#activity-bible_verse').val());
});

</script>