<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "activity_type".
 *
 * @property int $id
 * @property int $picture_id
 * @property int $activity_id
 */
class PictureActivity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'picture_activity';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['picture_id', 'activity_id'], 'required'],
            [['picture_id', 'activity_id'], 'integer'],
            [['picture_id'], 'exist', 'skipOnError' => true, 'targetClass' => Picture::className(), 'targetAttribute' => ['picture_id' => 'id']],
            [['activity_id'], 'exist', 'skipOnError' => true, 'targetClass' => Activity::className(), 'targetAttribute' => ['activity_id' => 'id']],
        ];
    }
	public function scenarios() {
		$scenarios = parent::scenarios(); // This will cover you
		$scenarios['create'] = ['picture_id','activity_id'];
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
            return (string) 'id='.$this->id.'; picture_id='.$this->picture_id.'; activity_id='.$this->activity_id;
        } 
        catch (Exception $exception) 
        {
            return '';
        }
    }
    public function savePicturesForActivity($activity_id, $pictures)
    {
        PictureActivity::deleteAll('activity_id = '.$activity_id);
		if($pictures && count($pictures)){
			foreach($pictures as $picture){
				$model = new PictureActivity(['scenario' => 'create']);
				$model->picture_id=$picture->id;
				$model->activity_id=$activity_id;
				$model->save();
			}
		}
    }	
}
