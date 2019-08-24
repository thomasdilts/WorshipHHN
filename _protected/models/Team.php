<?php

namespace app\models;

use \app\models\TeamUser;
use \app\models\User;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "team".
 *
 * @property int $id
 * @property int $church_id
 * @property int $team_type_id
 * @property string $name
 *
 * @property Activity[] $activities
 * @property Church $church
 * @property TeamType $teamType
 * @property TeamBlocked[] $teamBlockeds
 * @property TeamUser[] $teamUsers
 */
class Team extends \yii\db\ActiveRecord
{
	public $imageFiles;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'team';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['church_id', 'team_type_id', 'name'], 'required'],
            [['church_id', 'team_type_id'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['church_id'], 'exist', 'skipOnError' => true, 'targetClass' => Church::className(), 'targetAttribute' => ['church_id' => 'id']],
            [['team_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => TeamType::className(), 'targetAttribute' => ['team_type_id' => 'id']],
        ];
    }
	public function scenarios() {
		$scenarios = parent::scenarios(); // This will cover you
		$scenarios['create'] = ['name','team_type_id','church_id'];
		return $scenarios;
	}
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'team_type_id' => Yii::t('app', 'Team Type'),
            'name' => Yii::t('app', 'Name'),
			'team_type.name' => Yii::t('app', 'Team type name'),
            'imageFiles' => Yii::t('app', 'Files'),                        
        ];
    }
	public function __toString()
    {
        try 
        {
			$users = implode(': ',ArrayHelper::getColumn($this->getTeamUsers()->all(), 'email', false));
            return (string) 'id='.$this->id.'; name='.$this->name.'; team_type_id='.$this->team_type_id.'; teamUsers='
				.$users;
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
        return $this->hasMany(Activity::className(), ['team_id' => 'id']);
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
    public function getTeamType()
    {
        return $this->hasOne(TeamType::className(), ['id' => 'team_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeamBlockeds()
    {
        return $this->hasMany(TeamBlocked::className(), ['team_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeamUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable("team_user", ['team_id' => 'id']);
    }

	    /**
     * Relation with Role model.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTypeName()
    {
        // User has_one Role via Role.user_id -> id
        return $this->hasOne(TeamType::className(), ['team_type_id' => 'id']);
    }
    public function IsTeamBlocked($testDate)
    {
        $formatDate=Yii::$app->formatter->asDate($testDate, "Y-MM-dd H:mm");
        $blockedDates = $this->hasMany(TeamBlocked::className(), ['team_id' => 'id'])
            ->andFilterWhere(['<=','start_date', $formatDate])
            ->andFilterWhere(['>=','end_date', $formatDate])->all();
        return $blockedDates != null && count($blockedDates)>0;
    }
}
