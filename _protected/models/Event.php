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
	public $copyFromEventId;
	public $copy_persons_teams;
	public $copy_all_songs;
	public $number_weeks_repeat;
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
		$scenarios['create'] = ['number_weeks_repeat','copyFromEventId','copy_persons_teams','copy_all_songs','name', 'description', 'start_date','end_date','church_id'];
		return $scenarios;
	}
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['church_id', 'name', 'start_date','end_date'], 'required'],
            [['church_id','copy_persons_teams','copy_all_songs'], 'integer'],
            [['number_weeks_repeat'], 'integer','min' => 1,'max' => 16],
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
            'number_weeks_repeat' => Yii::t('app', 'Number of weeks to copy to'),   
            'copy_persons_teams' => Yii::t('app', 'Copy all persons and teams'),   
            'copy_all_songs' => Yii::t('app', 'Copy all songs'),   

        ];
    }
	public function __toString()
    {
        try 
        {
            return (string) 'id='.$this->id.'; name='.$this->name.'; Description='.$this->description.'; start_date='
				.$this->start_date.'; end_date='.$this->end_date;
        } 
        catch (Exception $exception) 
        {
            return '';
        }
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
