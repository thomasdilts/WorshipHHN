<?php

namespace app\models;

use \app\models\User;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "picture".
 *
 * @property int $id
 * @property int $church_id
 * @property string $name
 * @property string $description
 *
 * @property Activity[] $activities
 * @property Church $church
 */
class Picture extends \yii\db\ActiveRecord
{
	public $imageFiles;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'picture';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description','name','church_id','imageFiles'], 'safe'],
            [['church_id', 'name'], 'required'],
            [['church_id'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['description'], 'string','max' => 1000],
            [['church_id'], 'exist', 'skipOnError' => true, 'targetClass' => Church::className(), 'targetAttribute' => ['church_id' => 'id']],
        ];
    }
	public function scenarios() {
		$scenarios = parent::scenarios(); // This will cover you
		$scenarios['create'] = ['description','name','church_id','imageFiles'];
		return $scenarios;
	}
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Name'),
			'description' => Yii::t('app', 'Description'),
            'imageFiles' => Yii::t('app', 'Picture'),                                                                                                                                    
        ];
    }
	public function __toString()
    {
        try 
        {
            return (string) 'id='.$this->id.'; name='.$this->name.'; description='.$this->description.'; picture='
				.File::findOne(['model'=>$this->tableName(),'itemId'=>$this->id]);
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

}
