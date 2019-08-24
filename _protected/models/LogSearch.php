<?php
namespace app\models;

use yii\data\ActiveDataProvider;
use yii\base\Model;
use Yii;

/**
 * UserSearch represents the model behind the search form for app\models\User.
 */
class LogSearch extends Log
{
	public $filter_start_date;
    public $filter_end_date;

    /**
     * Returns the validation rules for attributes.
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['filter_start_date','filter_end_date','datestamp','place','what','who','before','after'], 'safe'],
        ];
    }

    /**
     * Returns a list of scenarios and the corresponding active attributes.
     *
     * @return array
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied.
     *
     * @param  array   $params
     * @param  integer $pageSize How many users to display per page.
     * @return ActiveDataProvider
     */
    public function search($params, $pageSize = 20)
    {
        $query = Log::find()->where(['church_id'=>Yii::$app->user->identity->church_id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['datestamp'=>SORT_DESC]],
            'pagination' => ['pageSize' => $pageSize]
        ]);

        $dataProvider->sort->attributes['datestamp'] = [
            'asc' => ['datestamp' => SORT_ASC],
            'desc' => ['datestamp' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['place'] = [
            'asc' => ['place' => SORT_ASC],
            'desc' => ['place' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['what'] = [
            'asc' => ['what' => SORT_ASC],
            'desc' => ['what' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['who'] = [
            'asc' => ['who' => SORT_ASC],
            'desc' => ['who' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['before'] = [
            'asc' => ['before' => SORT_ASC],
            'desc' => ['before' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['after'] = [
            'asc' => ['after' => SORT_ASC],
            'desc' => ['after' => SORT_DESC],
        ];
		
		$this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
		
		$church= Church::findOne(Yii::$app
            ->user
            ->identity
            ->church_id);		
		$start=$this->filter_start_date?LogSearch::date_convert($this->filter_start_date, $church->time_zone, 'Y-m-d H:i:s', 'UTC', 'Y-m-d H:i:s'):'';
		$end=$this->filter_start_date?LogSearch::date_convert($this->filter_end_date, $church->time_zone, 'Y-m-d H:i:s', 'UTC', 'Y-m-d H:i:s'):'';
		$query//->andFilterWhere(['between', 'datestamp', $start, $end])
			->andFilterWhere(['like', 'place', $this->place])
			->andFilterWhere(['like', 'what', $this->what])
			->andFilterWhere(['like', 'who', $this->who])
			->andFilterWhere(['like', 'before', $this->before])
            ->andFilterWhere(['like', 'after', $this->after]);
        return $dataProvider;
    }
	function date_convert($dt, $tz1, $df1, $tz2, $df2) {
	  $res = '';
	  if(!in_array($tz1, timezone_identifiers_list())) { // check source timezone
		trigger_error(__FUNCTION__ . ': Invalid source timezone ' . $tz1, E_USER_ERROR);
	  } elseif(!in_array($tz2, timezone_identifiers_list())) { // check destination timezone
		trigger_error(__FUNCTION__ . ': Invalid destination timezone ' . $tz2, E_USER_ERROR);
	  } else {
		// create DateTime object
		$d = \DateTime::createFromFormat($df1, $dt, new \DateTimeZone($tz1));
		// check source datetime
		if($d && \DateTime::getLastErrors()["warning_count"] == 0 && \DateTime::getLastErrors()["error_count"] == 0) {
		  // convert timezone
		  $d->setTimeZone(new \DateTimeZone($tz2));
		  // convert dateformat
		  $res = $d->format($df2);
		} else {
		  trigger_error(__FUNCTION__ . ': Invalid source datetime ' . $dt . ', ' . $df1, E_USER_ERROR);
		}
	  }
	  return $res;
	}	
}







