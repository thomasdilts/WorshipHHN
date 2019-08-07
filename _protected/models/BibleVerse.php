<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bible_verse".
 *
 * @property int $id
 * @property int $activity_id
 * @property int $book
 * @property int $chapter
 * @property int $verse
 * @property int $to_verse
 * @property int $order_by
 *
 * @property Activity $activity
 */
class BibleVerse extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bible_verse';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['activity_id', 'book', 'chapter', 'verse', 'to_verse', 'order_by'], 'required'],
            [['activity_id', 'book', 'chapter', 'verse', 'to_verse', 'order_by'], 'integer'],
            [['activity_id'], 'exist', 'skipOnError' => true, 'targetClass' => Activity::className(), 'targetAttribute' => ['activity_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'activity_id' => 'Activity ID',
            'book' => 'Book',
            'chapter' => 'Chapter',
            'verse' => 'Verse',
            'to_verse' => 'To Verse',
            'order_by' => 'Order By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivity()
    {
        return $this->hasOne(Activity::className(), ['id' => 'activity_id']);
    }
	
	public static function getFormatedBibleVersesForActivity($stringToParse,$seperator)
    {
		if(strlen($stringToParse)==0){
			return '';
		}
		Yii::info($stringToParse,'stringToParse getFormatedBibleVersesForActivity');
		$parsedString='';
		$elements = explode(';',$stringToParse);
		for($i=0;$i<count($elements);$i++){
			$parts = explode(',',$elements[$i]);
			Yii::info(count($parts),'getFormatedBibleVersesForActivity');
			if(count($parts)!=4){
				continue;
			}
			if(strlen($parsedString)!=0){$parsedString.=$seperator;}
			$parsedString.=Yii::t('biblebooks', BibleVerse::$bookNumToName[$parts[0]]) . ' ' . BibleVerse::getChapterNumForAbsoluteChapter($parts[0],$parts[1]) . ':' . ($parts[2]+1) . ($parts[3]!='-1'?'-'.($parts[3]+1):'');
			Yii::info($parsedString . ": book=  " . Yii::t('biblebooks', BibleVerse::$bookNumToName[$parts[0]]),'parsedString getFormatedBibleVersesForActivity');
		}
		return $parsedString;
    }
	public static function getChapterNumForAbsoluteChapter($bookNum, $absolutChapter)
    {
		$chaptersBeforeBook=0;
		for($i=0;$i<$bookNum;$i++){
			$chaptersBeforeBook+=BibleVerse::$chaptersInBook[$i];
		}	
		return $absolutChapter - $chaptersBeforeBook + 1;
    }
	public static function getBookForNum($num)
    {

		foreach(BibleVerse::$bookNumToName as $key=>$bookname){
			if((int)$key==$num){ 
				return $bookname;
			}
		}
		return '';
    }
	public static function getBibleBookArrayForSelection()
    {
		$allBooks=[];
		foreach(BibleVerse::$bookNumToName as $key=>$bookname){
			$allBooks[$key]=Yii::t('biblebooks',$bookname);
		}
		return $allBooks;
    }
	public static $chaptersInBook=[50,40,27,36,34,24,21,4,31,24,22,25,29,36,10,13,10,42,150,
	31,12,8,66,52,5,48,12,14,3,9,1,4,7,3,3,3,2,14,4,28,16,24,21,28,16,16,13,
	6,6,4,4,5,3,6,4,3,1,13,5,5,3,5,1,1,1,22];

	public static $jsonBookToChapterArray="

	";
	public static $jsonChapterToVerseArray="
	";
	public static $bookNumToName=[
		'0'=>'Gen',
		'1'=>'Exod',
		'2'=>'Lev',
		'3'=>'Num',
		'4'=>'Deut',
		'5'=>'Josh',
		'6'=>'Judg',
		'7'=>'Ruth',
		'8'=>'1Sam',
		'9'=>'2Sam',
		'10'=>'1Kgs',
		'11'=>'2Kgs',
		'12'=>'1Chr',
		'13'=>'2Chr',
		'14'=>'Ezra',
		'15'=>'Neh',
		'16'=>'Esth',
		'17'=>'Job',
		'18'=>'Ps',
		'19'=>'Prov',
		'20'=>'Eccl',
		'21'=>'Song',
		'22'=>'Isa',
		'23'=>'Jer',
		'24'=>'Lam',
		'25'=>'Ezek',
		'26'=>'Dan',
		'27'=>'Hos',
		'28'=>'Joel',
		'29'=>'Amos',
		'30'=>'Obad',
		'31'=>'Jonah',
		'32'=>'Mic',
		'33'=>'Nah',
		'34'=>'Hab',
		'35'=>'Zeph',
		'36'=>'Hag',
		'37'=>'Zech',
		'38'=>'Mal',
		'39'=>'Matt',
		'40'=>'Mark',
		'41'=>'Luke',
		'42'=>'John',
		'43'=>'Acts',
		'44'=>'Rom',
		'45'=>'1Cor',
		'46'=>'2Cor',
		'47'=>'Gal',
		'48'=>'Eph',
		'49'=>'Phil',
		'50'=>'Col',
		'51'=>'1Thess',
		'52'=>'2Thess',
		'53'=>'1Tim',
		'54'=>'2Tim',
		'55'=>'Titus',
		'56'=>'Phlm',
		'57'=>'Heb',
		'58'=>'Jas',
		'59'=>'1Pet',
		'60'=>'2Pet',
		'61'=>'1John',
		'62'=>'2John',
		'63'=>'3John',
		'64'=>'Jude',
		'65'=>'Rev',
		];
}
