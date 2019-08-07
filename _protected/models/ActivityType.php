<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "activity_type".
 *
 * @property int $id
 * @property int $church_id
 * @property string $name
 * @property string $use_team_or_user
 * @property string $use_name
 * @property string $use_globally
 * @property string $use_song
 * @property string $use_file
 * @property string $default_start_time
 * @property string $default_end_time
 *
 * @property Activity[] $activities
 * @property Church $church
 * @property EventTemplateActivityType[] $eventTemplateActivityTypes
 */
class ActivityType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'activity_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['church_id', 'name', 'notify_user_event_errors', 'use_globally', 'default_global_order'], 'required'],
            [['church_id', 'notify_user_event_errors', 'team_type_id', 'use_globally', 'default_global_order'], 'integer'],
            [['using_user', 'using_team', 'description', 'using_song', 'file', 'bible_verse', 'special_needs'], 'string'],
            [['default_start_time', 'default_end_time'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['church_id'], 'exist', 'skipOnError' => true, 'targetClass' => Church::className(), 'targetAttribute' => ['church_id' => 'id']],
            [['team_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => TeamType::className(), 'targetAttribute' => ['team_type_id' => 'id']],
        ];
    }
	public function scenarios() {
		$scenarios = parent::scenarios(); // This will cover you
		$scenarios['create'] = ['name', 'using_team','using_user', 'description', 'using_song', 'file','bible_verse','special_needs', 'use_globally','default_start_time', 'default_end_time', 'default_global_order','demand_team','demand_user','demand_description','demand_song','demand_file','notify_user_event_errors'];
		return $scenarios;
	}
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app','Name'),
            'using_team' => Yii::t('app','Use Team'),
            'using_user' => Yii::t('app','Use User'),
            'description' => Yii::t('app','Use Description'),
            'use_globally' => Yii::t('app','Use Globally (No start time)'),
            'using_song' => Yii::t('app','Use Song'),
            'file' => Yii::t('app','Use File'),
            'bible_verse' => Yii::t('app','Use Bible Verse'),
            'special_needs' => Yii::t('app','Use Special Needs'),			
            'notify_user_event_errors' => Yii::t('app','Notify this user of event problems'),
            'default_start_time' => Yii::t('app','Default Start Time'),
            'default_end_time' => Yii::t('app','Default End Time'),
            'default_global_order' => Yii::t('app','Default global order'),
			'team_type_id' => Yii::t('app','Team type'),
        ];
    }
    public static function getAllActivityTypes($church_id)
    {
        return ActivityType::find()->where(['church_id'=>$church_id]);
    }
	
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivities()
    {
        return $this->hasMany(Activity::className(), ['activity_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChurch()
    {
        return $this->hasOne(Church::className(), ['id' => 'church_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventTemplateActivityTypes()
    {
        return $this->hasMany(EventTemplateActivityType::className(), ['activity_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeamType()
    {
        return $this->hasOne(TeamType::className(), ['id' => 'team_type_id']);
    }
}
