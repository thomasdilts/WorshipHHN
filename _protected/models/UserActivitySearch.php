<?php
namespace app\models;

use app\rbac\models\AuthItem;
use yii\data\ActiveDataProvider;
use yii\base\Model;
use Yii;

/**
 * UserSearch represents the model behind the search form for app\models\User.
 */
class UserActivitySearch extends Activity
{
    public $userid;
    public $filter_start_date;
    public $filter_end_date;
    public $teamIdArray;
    public $user;
	public $team_name;
    public $event_name;

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
    
	public function rules()
    {
        return [
            [['filter_start_date','filter_end_date','name','description','team_name', 'event_name'], 'safe'],
        ];
    }

    /**
     * Creates data provider instance with search query applied.
     *
     * @param  array   $params
     * @param  integer $pageSize How many users to display per page.
     * @return ActiveDataProvider
     */
    public function search($params, $pageSize = 30)
    {
        if($this->teamIdArray && $this->user){
            $query = Activity::find()
				->joinWith('event',true)
				->joinWith('team', true)
				->joinWith('user', true)
				->where(['or', ['activity.user_id'=>$this->user->id],['activity.team_id'=>$this->teamIdArray]]);
        }elseif($this->teamIdArray){
            $query = Activity::find()->joinWith('event',true)->joinWith('team', true)->joinWith('user', true)->where(['activity.team_id'=>$this->teamIdArray]);
        }else{
            $query = Activity::find()->joinWith('event',true)->joinWith('user', true)->where(['activity.user_id'=>$this->user->id]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['start_date'=>SORT_ASC,'global_order'=>SORT_ASC]],
            'pagination' => ['pageSize' => $pageSize]
        ]);
		
        $dataProvider->sort->attributes['start_date'] = [
            'asc' => ['event.start_date' => SORT_ASC],
            'desc' => ['event.start_date' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['team_name'] = [
            'asc' => ['team.name' => SORT_ASC],
            'desc' => ['team.name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['name'] = [
            'asc' => ['name' => SORT_ASC],
            'desc' => ['name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['status'] = [
            'asc' => ['status' => SORT_ASC],
            'desc' => ['status' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['event_name'] = [
            'asc' => ['event.name' => SORT_ASC],
            'desc' => ['event.name' => SORT_DESC],
        ];		
		
		
        //Yii::info($this->filter_start_date.':'.$this->filter_end_date, 'UserActivitySearch');
        if (!($this->load($params) && $this->validate())) {
            $query->andFilterWhere(['between', 'event.start_date', $this->filter_start_date, $this->filter_end_date]);
            return $dataProvider;
        }
		//print_r($this);die();
        $query->andFilterWhere(['between', 'event.start_date', $this->filter_start_date, $this->filter_end_date])
			->andFilterWhere(['like', 'event.name', $this->event_name])
			->andFilterWhere(['like', 'activity.name', $this->name])
			->andFilterWhere(['like', 'team.name', $this->team_name])
			;
        return $dataProvider;
    }
}
