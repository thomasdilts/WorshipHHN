<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_blocked".
 *
 * @property int $id
 * @property string $start_date
 * @property string $end_date
 * @property int $user_id
 *
 * @property User $user
 */
class UserBlocked extends \yii\db\ActiveRecord
{
	public $filter_start_date;
    public $filter_end_date;
	public $user_display_name;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_blocked';
    }
	public function scenarios() {
		$scenarios = parent::scenarios(); // This will cover you
		$scenarios['create'] = ['user_id', 'end_date', 'start_date'];
		return $scenarios;
	}
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['start_date', 'end_date', 'user_id'], 'required'],
            [['start_date', 'end_date'], 'safe'],
            [['user_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'start_date' => Yii::t('app', 'Start Date'),
            'end_date' => Yii::t('app', 'End Date'),
            'filter_start_date' => Yii::t('app', 'Start Date'),
            'filter_end_date' => Yii::t('app', 'End Date'),  
        ];
    }
	public function __toString()
    {
        try 
        {
            return (string) 'id='.$this->id.'; start_date='.$this->start_date.'; end_date='.$this->end_date;
        } 
        catch (Exception $exception) 
        {
            return '';
        }
    }	
    public static function IsValidDates($model){
		// check to make sure the dates are reasonable
		if($model->start_date > $model->end_date){
			Yii::$app->session->setFlash("danger", Yii::t("app", "Start Date must be before End Date"));
            return false;
		}
		$allDates=UserBlocked::getAllUserBlockeds($model->user_id)->all();
		if($allDates!=null && count($allDates)>0){
			foreach($allDates as $date){
				if($date->id!= $model->id 
						&& (($model->start_date > $date->start_date && $model->start_date < $date->end_date)
						|| ($model->end_date > $date->start_date && $model->end_date < $date->end_date))){
					Yii::$app->session->setFlash("danger", Yii::t("app", "Dates confict with existing date") . ' : ' . date('Y-m-d',strtotime($date->start_date)) . ' -> ' . date('Y-m-d',strtotime($date->end_date)));
					return false;
				}
			}
		}
		return true;
	}
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
	
	public function getAllUserBlockeds($id)
    {
		Yii::info($id,'getAllUserBlockeds');
        return UserBlocked::find()->where(['user_id'=>$id]);
    }
}
