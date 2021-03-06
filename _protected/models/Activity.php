<?php

namespace app\models;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use Yii;

/**
 * This is the model class for table "activity".
 *
 * @property int $id
 * @property int $activity_type_id
 * @property int $event_id
 * @property int $user_id
 * @property int $team_id
 * @property int $song_id
 * @property string $name
 * @property string $description
 * @property string $start_time
 * @property string $end_time:
 * @property int $global_order
 *
 * @property ActivityType $activityType
 * @property Event $event
 * @property User $user
 * @property Team $team
 * @property Song $song
 * @property TeamUserNotify[] $teamUserNotifies
 */
class Activity extends \yii\db\ActiveRecord
{
	public $imageFiles;
	public $duration;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'activity';
    }
	public function scenarios() {
		$scenarios = parent::scenarios(); // This will cover you
		$scenarios['create'] = ['duration','freehand_user','freehand_team','name','bible_verse', 'description', 'start_time','end_time','church_id','activity_type_id','event_id','user_id', 'team_id', 'song_id','global_order'];
		return $scenarios;
	}
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['activity_type_id', 'event_id', 'name'], 'required'],
            [['activity_type_id', 'event_id', 'user_id', 'team_id', 'song_id', 'global_order'], 'integer'],
            [['description','bible_verse'], 'string'],
            [['start_time', 'end_time'], 'safe'],
            [['name','freehand_user','freehand_team'], 'string', 'max' => 100],
			[['duration'], 'integer', 'max' => 300, 'min' => 1],
            [['activity_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ActivityType::className(), 'targetAttribute' => ['activity_type_id' => 'id']],
            [['event_id'], 'exist', 'skipOnError' => true, 'targetClass' => Event::className(), 'targetAttribute' => ['event_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['team_id'], 'exist', 'skipOnError' => true, 'targetClass' => Team::className(), 'targetAttribute' => ['team_id' => 'id']],
            [['song_id'], 'exist', 'skipOnError' => true, 'targetClass' => Song::className(), 'targetAttribute' => ['song_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Activity'),
            'description' => Yii::t('app', 'Description'),
            'start_time' => Yii::t('app', 'Start Time'),
            'end_time' => Yii::t('app', 'End Time'),
            'global_order' => Yii::t('app', 'Global Order'),    
            'team_id' => Yii::t('app', 'Team'),
            'user_id' => Yii::t('app', 'User'),   
            'song_id' => Yii::t('app', 'Song'),   
            'imageFiles' => Yii::t('app', 'Files'),  
			'bible_verse' => Yii::t('app', 'Bible verses'), 
			'user_display_name' => Yii::t('app', 'Display name'), 
			'status' => Yii::t('app', 'Status'),
			'team_name' => Yii::t('app', 'Team'),
			'start_date' => Yii::t('app', 'Start Date'),
			'event_name' => Yii::t('app', 'Event Name'),
			'freehand_user' => Yii::t('app', 'Text name entry'),
			'freehand_team' => Yii::t('app', 'Text name entry'),
			'duration' => Yii::t('app', 'Duration in minutes'),
        ];
    }
	public function __toString()
    {
        try 
        {
            return (string) 'id='.$this->id.'; name='.$this->name.'; description='.$this->description.'; start_time='
				.$this->start_time.'; end_time='.$this->end_time.'; global_order='
				.$this->global_order.'; team_id='.$this->team_id.'; freehand_team='.$this->freehand_team.'; user_id='.$this->user_id.'; freehand_user='.$this->freehand_user
				.'; song_id='.$this->song_id.'; bible_verse='.$this->bible_verse;
        } 
        catch (Exception $exception) 
        {
            return '';
        }
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivityType()
    {
        return $this->hasOne(ActivityType::className(), ['id' => 'activity_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Event::className(), ['id' => 'event_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeam()
    {
        return $this->hasOne(Team::className(), ['id' => 'team_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSong()
    {
        return $this->hasOne(Song::className(), ['id' => 'song_id']);
    }
    public function getFiles()
    {
		return File::getAllFiles($this->tableName(),$this->id);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeamUserNotifies()
    {
        return $this->hasMany(TeamUserNotify::className(), ['activity_id' => 'id']);
    }
	
	public static function getAllActivities($eventId)
    {
        return Activity::find()->where(['event_id'=>$eventId]);
    }
	public static function getOtherColumnWeb($model,$start_date)
    {	
        return Activity::getOtherColumn($model,$start_date,'<br/>',true,'<span style="color:red">','</span>','<span style="color:goldenrod">','</span>')['value'];
    }

	public static function getOtherColumn($model,$start_date,$seperator=";\r\n",$showImages=false, $preRed='',$postRed='',$preYellow='',$postYellow='')
    {
		$value='';
        $isRed = false;
        $isYellow= false;		
		if($model->activityType->using_song!='Not used'){
			$song=$model->getSong()->one();
			$value.=strlen($value)>0?$seperator:'';
            if ($model->activityType->using_song=='Demand' && ($song == null || strlen($song->name) == 0))
            {
                $isRed = true;
            }
			$songText='';			
			if ($song!=null && strlen($song->name)>0)
            {
				$songText = (strlen($preRed)==0?'':'<a href="'.URL::toRoute('song/view').'?id='.$song->id.'">'). $song->name . (strlen($preRed)==0?'':'</a>') ;
			}

			$value.=$song!=null && strlen($song->name)>0?$songText:($model->activityType->using_song=='Demand'?$preRed.Yii::t('app', 'Missing-song').$postRed:'');							
		}

		if($model->activityType->using_team!='Not used' || $model->activityType->using_user!='Not used'){
			$notifications= Notification::find()->where(['activity_id'=>$model->id])->all();
			if($notifications && count($notifications)>0) {									
				$statuses = ArrayHelper::getColumn($notifications,'status');
				if(in_array('Accepted',$statuses)){
					//do nothing. All is ok
				}elseif(in_array('Not replied yet',$statuses)) {
					$value.=$preYellow.Yii::t('app', 'Not replied yet').$postYellow;
					$isYellow=true;
				}elseif(in_array('Rejected',$statuses)) {
					$value.=$preRed.Yii::t('app', 'Rejected').$postRed;
					$isRed = true;
				}
			}
		}

		if($model->activityType->using_team!='Not used'){
			$team=$model->getTeam()->one();
			$isTeamBlocked=$team!=null ? $team->IsTeamBlocked($start_date):false;
			$value.=strlen($value)>0?$seperator:'';
			$value.=$team!=null && strlen($team->name)>0?
				($isTeamBlocked?$preRed.Yii::t('app', 'Unavailable-team').$postRed:$team->name)
				:($model->activityType->using_team=='Demand' && (!$model->freehand_team || strlen($model->freehand_team)<2)?$preRed.Yii::t('app', 'Missing-team').$postRed:($model->freehand_team && strlen($model->freehand_team)>1?$model->freehand_team:''));		
            if (($model->activityType->using_team=='Demand' && ($team == null || strlen($team->name) == 0)&& (!$model->freehand_team || strlen($model->freehand_team)<2)) ||$isTeamBlocked)
            {
                $isRed = true;
            }					
		}
		if($model->activityType->using_user!='Not used'){
			$user=$model->getUser()->one();
			$value.=strlen($value)>0?$seperator:'';
			$isUserBlocked=$user!=null ? $user->IsUserBlocked($start_date):false;
			$value.=$user!=null && strlen($user->display_name)>0
				?($isUserBlocked?$preRed.Yii::t('app', 'Unavailable-user').$postRed:($showImages?User::getThumbnailMedium($user->id):'').$user->display_name)
				:($model->activityType->using_user=='Demand' && (!$model->freehand_user || strlen($model->freehand_user)<2)?$preRed.Yii::t('app', 'Missing-user').$postRed:($model->freehand_user && strlen($model->freehand_user)>1?$model->freehand_user:''));							
            if (($model->activityType->using_user=='Demand' && ($user == null || strlen($user->display_name) == 0)&& (!$model->freehand_user || strlen($model->freehand_user)<2)) || $isUserBlocked)
            {
                $isRed = true;
            }
		}
		if($model->activityType->file!='Not used'){
			$files=$model->getFiles()->all();
			$foundfile=false;
			if($files!=null && count($files)>0){
				foreach($files as $file){
					$foundfile=true;
					$value.=strlen($value)>0?$seperator:'';
					$value.=$preRed==''?$file->name:Html::a($file->name, 'fileactivitydownload?id='.$file->id.'&fileownerid='.$model->id.'&eventid='.$model->event_id, ['title'=>Yii::t('app', 'Download')]);
				}
			}
			if(!$foundfile && $model->activityType->file=='Demand'){
				$value.=strlen($value)>0?$seperator:'';
				$value.=$preRed.Yii::t('app', 'Missing-file').$postRed;
				$isRed = true;
			}
		}
		if($model->activityType->using_picture!='Not used'){
			$activity = Activity::findOne(['id' => $model->id]);
			$pictures = $activity->hasMany(Picture::className(), ['id' => 'picture_id'])
				->viaTable('picture_activity',['activity_id' => 'id'])
				->orderBy('name')
				->all();			
			$foundPicture=false;
			if($pictures!=null && count($pictures)>0){
				foreach($pictures as $picture){
					$foundPicture=true;
					$value.=strlen($value)>0?$seperator:'';
					$value.=$preRed==''?$picture->name:Html::a($picture->name,URL::toRoute('picture/view') .'?id='.$picture->id, ['title'=>Yii::t('app', 'View picture')]);
				}
			}
			if(!$foundPicture && $model->activityType->using_picture=='Demand'){
				$value.=strlen($value)>0?$seperator:'';
				$value.=$preRed.Yii::t('app', 'Missing-picture').$postRed;
				$isRed = true;
			}
		}		
		if($model->activityType->description!='Not used'){
			$value.=strlen($value)>0?$seperator:'';
			$value.=$model->description!=null && strlen($model->description)>0
				?str_replace ("\r\n",$seperator,$model->description):($model->activityType->description=='Demand'?$preRed.Yii::t('app', 'Missing-description').$postRed:'');						
            if ($model->activityType->description=='Demand' && ($model->description == null || strlen($model->description) == 0))
            {
                $isRed = true;
            }
		}	
		if($model->activityType->special_needs!='Not used'){
			$value.=strlen($value)>0?$seperator:'';
			$value.=$model->special_needs!=null && strlen($model->special_needs)>0
				?$model->special_needs:($model->activityType->special_needs=='Demand'?$preRed.Yii::t('app', 'Missing special needs').$postRed:'');						
            if ($model->activityType->special_needs=='Demand' && ($model->special_needs == null || strlen($model->special_needs) == 0))
            {
                $isRed = true;
            }
		}								
		if($model->activityType->bible_verse!='Not used'){
			$value.=strlen($value)>0?$seperator:'';
			$usedVerses = BibleVerse::getFormatedBibleVersesForActivity($model->bible_verse,$seperator);
			$value.=strlen($usedVerses)>0
				?$usedVerses:($model->activityType->bible_verse=='Demand'?$preRed.Yii::t('app', 'Missing bible verse').$postRed:'');						
            if ($model->activityType->bible_verse=='Demand' && ($model->bible_verse == null || strlen($model->bible_verse) == 0))
            {
                $isRed = true;
            }
		}	

        return array(
            'value' => $value,
            'isRed' => $isRed,
            'isYellow' => $isYellow
        );
    }
}
