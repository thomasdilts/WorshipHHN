<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bible".
 *
 * @property int $id
 * @property int $language_id
 * @property int $church_id
 * @property string $name
 *
 * @property Language $language
 * @property Church $church
 * @property BibleContents[] $bibleContents
 */
class Bible extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bible';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['language_id', 'church_id', 'name'], 'required'],
            [['language_id', 'church_id'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['language_id' => 'id']],
            [['church_id'], 'exist', 'skipOnError' => true, 'targetClass' => Church::className(), 'targetAttribute' => ['church_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'language_id' => 'Language ID',
            'church_id' => 'Church ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'language_id']);
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
    public function getBibleContents()
    {
        return $this->hasMany(BibleContents::className(), ['bible_id' => 'id']);
    }
}
