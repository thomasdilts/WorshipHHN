<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "event".
 *
 * @property int $id
 * @property int $church_id
 * @property string $name
 * @property string $description
 * @property string $start_date
 * @property string $end_date
 *
 * @property Activity[] $activities
 * @property Church $church
 * @property EventTemplate $eventTemplate
 */
class Event extends \yii\db\ActiveRecord
{
    public $imageFiles;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event';
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
            [['church_id', 'name', 'start_date','end_date'], 'required'],
            [['church_id'], 'integer'],
            [['description'], 'string'],
            [['start_date','end_date'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['church_id'], 'exist', 'skipOnError' => true, 'targetClass' => Church::className(), 'targetAttribute' => ['church_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'start_date' => Yii::t('app', 'Start Date'),
            'end_date' => Yii::t('app', 'End Date'),
            'filter_start_date' => Yii::t('app', 'Start Date'),
            'filter_end_date' => Yii::t('app', 'End Date'),   
            'imageFiles' => Yii::t('app', 'Files'),   

        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivities()
    {
        return $this->hasMany(Activity::className(), ['event_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChurch()
    {
        return $this->hasOne(Church::className(), ['id' => 'church_id']);
    }

	
	public static function getAllEvents($church_id)
    {
        return Event::find()->where(['church_id'=>$church_id]);
    }
}
