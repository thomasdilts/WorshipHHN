<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bible_contents".
 *
 * @property int $id
 * @property int $bible_id
 * @property int $book
 * @property int $chapter
 * @property int $verse
 * @property string $text
 *
 * @property Bible $bible
 */
class BibleContents extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bible_contents';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bible_id', 'book', 'chapter', 'verse', 'text'], 'required'],
            [['bible_id', 'book', 'chapter', 'verse'], 'integer'],
            [['text'], 'string'],
            [['bible_id', 'book', 'chapter', 'verse'], 'unique', 'targetAttribute' => ['bible_id', 'book', 'chapter', 'verse']],
            [['bible_id'], 'exist', 'skipOnError' => true, 'targetClass' => Bible::className(), 'targetAttribute' => ['bible_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bible_id' => 'Bible ID',
            'book' => 'Book',
            'chapter' => 'Chapter',
            'verse' => 'Verse',
            'text' => 'Text',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBible()
    {
        return $this->hasOne(Bible::className(), ['id' => 'bible_id']);
    }
}
