<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "song".
 *
 * @property int $id
 * @property string $name
 * @property string $name2
 * @property string $description
 *
 * @property Activity[] $activities
 */
class Song extends \yii\db\ActiveRecord
{
    public $imageFiles;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'song';
    }
	public function scenarios() {
		$scenarios = parent::scenarios(); // This will cover you
		$scenarios['create'] = ['name','name2','description', 'author'];
		return $scenarios;
	}
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
			[['church_id'], 'integer'],
            [['name', 'name2', 'author'], 'string', 'max' => 100],
            [['church_id', 'name', 'author'], 'unique', 'targetAttribute' => ['church_id','name', 'author'],'message' => Yii::t('app', 'Another song already has this name and author.')],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Name'),
            'name2' => Yii::t('app', 'Name'). '2',
            'author' => Yii::t('app', 'Author'),
            'description' => Yii::t('app', 'Description'),
        ];
    }
	public function __toString()
    {
        try 
        {
            return (string) 'id='.$this->id.'; name='.$this->name.'; name2='.$this->name2.'; author='
				.$this->author.'; description='.$this->description;
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
        return $this->hasMany(Activity::className(), ['song_id' => 'id']);
    }
	
	    /**
     * @return \yii\db\ActiveQuery
     */
    public static function getAllSongs($church_id)
    {
        return Song::find()->where(['church_id'=>$church_id]);
    }
}
