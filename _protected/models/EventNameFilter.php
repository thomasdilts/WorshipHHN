<?php

namespace app\models;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use Yii;

class EventNameFilter extends \yii\db\ActiveRecord
{
	
	public $i0;
	public $i1;
	public $i2;
	public $i3;
	public $i4;
	public $i5;
	public $i6;
	public $i7;
	public $i8;
	public $i9;
	public $i10;
	public $i11;
	public $i12;
	public $i13;
	public $i14;
	public $i15;
	public $i16;
	public $i17;
	public $i18;
	public $i19;
	public $i20;
	public $i21;
	public $i22;
	public $i23;
	public $i24;
	public $i25;
	public $i26;
	public $i27;
	public $i28;
	public $i29;
	public $i30;
	public $i31;
	public $i32;
	public $i33;
	public $i34;
	public $i35;
	public $i36;
	public $i37;
	public $i38;
	public $i39;
	public $i40;
	public $i41;
	public $i42;
	public $i43;
	public $i44;
	public $i45;
	public $i46;
	public $i47;
	public $i48;
	public $i49;

	private $lables;
	private $ruleArray;
	public const NUM_VARIABLES = 50;

    /**
     * {@inheritdoc}
     */

	public function scenarios() {
		$scenarios = parent::scenarios(); // This will cover you
		$variables=array();
		for($i=0;$i<EventNameFilter::NUM_VARIABLES;$i++){
			array_push($variables,'i'.$i);
		}
		$scenarios['create'] = $variables;
		return $scenarios;
	}
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
		$this->ruleArray=array();
		$safeStuff=array();
		$ruleArray2=array();
		for($i=0;$i<EventNameFilter::NUM_VARIABLES;$i++){
			array_push($safeStuff,'i'.$i);
		}		
		array_push($this->ruleArray,$safeStuff);
		array_push($this->ruleArray,'safe');
		array_push($ruleArray2,$safeStuff);
		array_push($ruleArray2,'integer');
        return [$this->ruleArray,$ruleArray2];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return $this->lables;
    }
	public function setFieldNames($filterNames)
    {
		$this->lables=array();
		$i=0;
		foreach($filterNames as $key=>$value){
			$this->lables['i'.$i]=$key;
			$i++;
		}

	}
	public function resetTo($value)
    {
		for($i=0;$i<EventNameFilter::NUM_VARIABLES;$i++){
			$this->{'i'.$i}=$value;
		}
    }
}
