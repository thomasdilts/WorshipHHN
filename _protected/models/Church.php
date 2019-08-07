<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "church".
 *
 * @property int $id
 * @property string $name
 * @property string $admin_email
 *
 * @property ActivityType[] $activityTypes
 * @property Event[] $events
 * @property EventTemplate[] $eventTemplates
 * @property Team[] $teams
 * @property TeamType[] $teamTypes
 * @property User[] $users
 */
class Church extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'church';
    }
	public function scenarios() {
		$scenarios = parent::scenarios(); // This will cover you
		$scenarios['create'] = ['name', 'admin_email'];
		return $scenarios;

	}
    public static function getList() {
        $options = [];
         
        $churches = self::find()->all();
		if(count($churches)==0){
			// we must have at least one church. Create one.
			$model = new Church();
			$model->name=Yii::t('app', 'Generic Church');
			$model->save();
			$churches = self::find()->all();
		}
		foreach($churches as $church) {
			$options[$church->id] = $church->name;	
		}
        return $options;
    } 
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['name', 'string', 'min' => 3, 'max' => 100],
            ['time_zone', 'string', 'min' => 3, 'max' => 50],
            ['paper_size', 'string', 'min' => 2, 'max' => 50],
            ['admin_email', 'filter', 'filter' => 'trim'],
            ['admin_email', 'required'],
            ['admin_email', 'email'],
			['paper_margin_top_bottom', 'double','min' => 0, 'max' => 1],
			['paper_margin_right_left', 'double','min' => 0, 'max' => 1],
            ['admin_email', 'string', 'max' => 100],			
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Name'),
            'admin_email' => Yii::t('app', 'Admin Email'),
            'time_zone' => Yii::t('app', 'Time zone'). ' ' . '(Europe/Stockholm, America/Kentucky/Louisville, ...)',
            'paper_size' => Yii::t('app', 'Paper size'). ' ' . '(A4, Letter, ...)',
            'paper_margin_top_bottom' => Yii::t('app', 'Paper margin top and bottom from zero to one'),
            'paper_margin_right_left' => Yii::t('app', 'Paper margin right and left from zero to one'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivityTypes()
    {
        return $this->hasMany(ActivityType::className(), ['church_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(Event::className(), ['church_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventTemplates()
    {
        return $this->hasMany(EventTemplate::className(), ['church_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeams()
    {
        return $this->hasMany(Team::className(), ['church_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeamTypes()
    {
        return $this->hasMany(TeamType::className(), ['church_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['church_id' => 'id']);
    }
    public static function getChurchAdminEmail($church_id){
		$foundAdmins=[];
		
		$users = User::find()->where(['church_id'=>$church_id,'item_name'=>'ChurchAdmin'])->joinWith('role')->all();
		if($users && count($users)>0){
			foreach($users as $user){
				array_push($foundAdmins,$user->email);
			}
		}
        if(count($foundAdmins)==0){
			$church=Church::findOne($church_id);
			return [$church->admin_email];
		}
		return $foundAdmins;
    }	
}
