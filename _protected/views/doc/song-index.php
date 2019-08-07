<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\DocForm;

$this->title = Yii::t('doc', 'Documentation') . " : " . $returnName;
$this->params['breadcrumbs'][] = ['label' => $returnName, 'url' => $returnUrl];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
	<span class="pull-right" style="">		
		<?php if(Yii::$app->user->isGuest){ ?>
			<?php $form = ActiveForm::begin(['id' => 'form-home']); ?>
				<?= $form->field($model, 'language_iso_name')->dropDownList(DocForm::getLanguages(),['onChange'=>'this.form.submit();']) ?>
			<?php ActiveForm::end(); ?>
		<?php } ?>		
	</span>	 
    <h1 style="display:inline-block;">
        <?= Html::encode($this->title) ?>
        <span class="pull-right" style="margin-left:20px;">
			<a href="<?=$returnUrl?>&lang=<?=$model->language_iso_name?>" class='btn btn-warning'><span class="glyphicon glyphicon-step-backward"></span><?=Yii::t('app', 'Return')?></a>
        </span>         
    </h1>
	<div class="row">
		<div class="col-lg-10">
			<p><?= Html::encode(Yii::t('doc', "Songs are a central part of many worship services. Here also they have a central role. There are usually so many songs that it is unreasonable to type in them all by hand. That is why you have the CSV import and the OpenLP import.")) ?></p>
			<p><?= Html::encode(Yii::t('doc', "The CSV import is usually simple enough for many people to succeed. But still you need to do it right. The best way to do a CSV import is to first write one song in by hand into the database. Then export that to a CSV file to see how it looks. Use that as a template for how to import all your songs with CSV.")) ?></p>
			<p><?= Html::encode(Yii::t('doc', "The OpenLP import is much easier. The OpenLP format uses one XML file for each song. Zip together all the songs you have exported from OpenLP into one zip file without any subdirectories. Then do the OpenLP import with that ZIP file.")) ?></p>
			<p><?= Html::encode(Yii::t('doc', "Because you may have hundreds of songs, you really need to learn how to use the powerful search tools this program offers. In each data field is an open text box that you may write a text into and then hit 'enter'. At that point all records matching in any way the text you wrote will be shown.")) ?></p>
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th><?= Html::encode(Yii::t('doc', 'Data field name'))?> </th>
						<th><?= Html::encode(Yii::t('doc', 'Description'))?></th>
						<th><?= Html::encode(Yii::t('doc', 'Examples'))?> </th>
					</tr>
				</thead> 
				<tbody>
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Name'))?> </td>
						<td><?= Html::encode(Yii::t('doc', 'The name of the song. The name that the song is most known by. This data field together with the author is a unique identifier for the record. It is with these two fields an import knows whether to update or add the song.'))?></td>	
						<td>Amazing grace, ...</td>	
					</tr>
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Name2'))?> </td>
						<td><?= Html::encode(Yii::t('doc', 'Another name the song is known by. This could also be simply a page number in a hymn book. This may also be blank.'))?></td>	
						<td></td>	
					</tr>
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Author'))?> </td>
						<td><?= Html::encode(Yii::t('doc', 'The author of the song. Of course there are authors and music composers and translators. Somehow you need to fit all of these into this field.'))?></td>	
						<td></td>		
					</tr>
					<tr>
						<td><?= Html::encode(Yii::t('doc', 'Description'))?> </td>
						<td><?= Html::encode(Yii::t('doc', 'This is the song itself. For some installations this could be left blank because only the name is needed in this program. But others may feel the need to put the entire song here because many songs are very similar and also for searching purposes. In the create and update screens this text box has a tab in one corner you can pull on to make the text box as big as you want. Otherwise the text box is very small.'))?></td>	
						<td></td>	
					</tr> 
				</tbody>
			</table>
		</div>
	</div>
</div>