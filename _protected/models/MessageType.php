<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "message_type".
 *
 * @property int $id
 * @property string $name
 * @property int $church_id
 *
 * @property Messages[] $messages
 * @property Church $church
 */
class MessageType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'message_type';
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
	public function __toString()
    {
        try 
        {
            return (string) 'id='.$this->id.'; name='.$this->name;
        } 
        catch (Exception $exception) 
        {
            return '';
        }
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
    public static function getAllMessageTypes($church_id)
    {
        return MessageType::find()->where(['church_id'=>$church_id]);
    }
	
    public function getMessages()
    {
        return $this->hasMany(MessageTemplate::className(), ['message_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChurch()
    {
        return $this->hasOne(Church::className(), ['id' => 'church_id']);
    }
}
