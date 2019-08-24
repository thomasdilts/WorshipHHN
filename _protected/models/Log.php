<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Log".
 *
 * @property int $id
 * @property int $church_id
 * @property string $datestamp
 * @property string $place
 * @property string $what
 * @property string $who
 * @property string $before
 * @property string $after
 *
 * @property Church $church
 */
class Log extends \yii\db\ActiveRecord
{
    public $imageFiles;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'log';
    }
	public function scenarios() {
		$scenarios = parent::scenarios(); // This will cover you
		$scenarios['create'] = ['name', 'description', 'start_date','end_date','church_id'];
		return $scenarios;
	}
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['church_id', 'datestamp', 'place','what','who'], 'required'],
            [['church_id'], 'integer'],
            [['before','after'], 'string'],
            [['datestamp'], 'safe'],
            [['place','what'], 'string', 'max' => 100],
            [['who'], 'string', 'max' => 255],
            [['church_id'], 'exist', 'skipOnError' => true, 'targetClass' => Church::className(), 'targetAttribute' => ['church_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'datestamp' => Yii::t('app', 'Start Date'),
            'place' => Yii::t('app', 'Where'),
            'what' => Yii::t('app', 'What'),
            'who' => Yii::t('app', 'Who'),
            'before' => Yii::t('app', 'Before'),
            'after' => Yii::t('app', 'After'),
            'filter_start_date' => Yii::t('app', 'Start Date'),
            'filter_end_date' => Yii::t('app', 'End Date')
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChurch()
    {
        return $this->hasOne(Church::className(), ['id' => 'church_id']);
    }
	
    public static function write($place, $what, $before, $after)
    {
		if($what==LogWhat::UPDATE && $before == $after){
			// no changes so no logging.
			return;
		}
		$log=new Log();
		$log->datestamp=gmdate('Y-m-d H:i:s');
		$log->church_id=Yii::$app->user->identity->church_id;
		$log->who=Yii::$app->user->identity->email;
		$log->place=$place;
		$log->what=$what;
		$log->before=$before;
		$log->after=$after;
		$log->save();
	}
}
