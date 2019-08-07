<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "team_type".
 *
 * @property int $id
 * @property string $name
 * @property int $church_id
 *
 * @property Team[] $teams
 * @property Church $church
 */
class TeamType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'team_type';
    }
	public function scenarios() {
		$scenarios = parent::scenarios(); // This will cover you
		$scenarios['create'] = ['name'];
		return $scenarios;
	}
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'church_id'], 'required'],
            [['church_id'], 'integer'],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public static function getAllTeamTypes($church_id)
    {
        return TeamType::find()->where(['church_id'=>$church_id]);
    }
	
    public function getTeams()
    {
        return $this->hasMany(Team::className(), ['team_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChurch()
    {
        return $this->hasOne(Church::className(), ['id' => 'church_id']);
    }
}
