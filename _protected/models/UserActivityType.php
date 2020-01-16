<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "activity_type".
 *
 * @property int $id
 * @property int $user_id
 * @property int $activity_type_id
 */
class UserActivityType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_activity_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'activity_type_id'], 'required'],
            [['user_id', 'activity_type_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['activity_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ActivityType::className(), 'targetAttribute' => ['activity_type_id' => 'id']],
        ];
    }
	public function scenarios() {
		$scenarios = parent::scenarios(); // This will cover you
		$scenarios['create'] = ['user_id','activity_type_id'];
		return $scenarios;
	}
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
        ];
    }
	public function __toString()
    {
        try 
        {
            return (string) 'id='.$this->id.'; user_id='.$this->user_id.'; activity_type_id='.$this->activity_type_id;
        } 
        catch (Exception $exception) 
        {
            return '';
        }
    }
    public function saveActivityTypesForUser($user_id, $activity_types)
    {
        UserActivityType::deleteAll('user_id = '.$user_id);
		if($activity_types && count($activity_types)){
			foreach($activity_types as $activity){
				$model = new UserActivityType(['scenario' => 'create']);
				$model->user_id=$user_id;
				$model->activity_type_id=$activity;
				$model->save();
			}
		}
    }	
}
