<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "language".
 *
 * @property int $id
 * @property string $iso_name
 * @property string $display_name_english
 * @property string $display_name_native
 * @property int $church_id
 *
 * @property Church $church
 */
class Language extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'language';
    }
	public function scenarios() {
		$scenarios = parent::scenarios(); // This will cover you
		$scenarios['create'] = ['church_id','display_name_english','display_name_native','iso_name'];
		return $scenarios;
	}
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['display_name_english', 'display_name_native', 'church_id','iso_name'], 'required'],
            [['church_id'], 'integer'],
            [['iso_name'], 'string', 'max' => 7],
            [['display_name_english', 'display_name_native'], 'string', 'max' => 100],
			[['display_name_english', 'church_id'], 'unique', 'targetAttribute' => ['display_name_english', 'church_id']],
			[['iso_name', 'church_id'], 'unique', 'targetAttribute' => ['iso_name', 'church_id']],
            [['church_id'], 'exist', 'skipOnError' => true, 'targetClass' => Church::className(), 'targetAttribute' => ['church_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'iso_name' => Yii::t('app', 'ISO Name'),
            'display_name_english' => Yii::t('app', 'Name in English'),
            'display_name_native' => Yii::t('app', 'Name in native language'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChurch()
    {
        return $this->hasOne(Church::className(), ['id' => 'church_id']);
    }
	public static function getAllLanguages($church_id)
    {
        return Language::find()->where(['church_id'=>$church_id]);
    }
	public static function getLanguageIsoNameForCalendar($language)
    {
		if(substr_compare($language->iso_name, 'ar', 0, 2) === 0){
			return 'en';
		}
		return $language->iso_name;
    }
	
}
