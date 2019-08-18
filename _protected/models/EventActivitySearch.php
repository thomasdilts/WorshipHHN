<?php
namespace app\models;

use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\base\Model;
use Yii;

/**
 * UserSearch represents the model behind the search form for app\models\User.
 */
class EventActivitySearch extends Event 
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
            [['filter_start_date','filter_end_date','name','use_team_or_user','use_name','use_globally','use_song','use_file','default_start_time','default_end_time'], 'safe'],
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
        $queryEvents = Event::getAllEvents(Yii::$app->user->identity->church_id);
		$queryEvents->andFilterWhere(['between', 'start_date', $this->filter_start_date, $this->filter_end_date]);

        $query = Activity::find()->joinWith('event',true)->joinWith('user', true)->joinWith('team', true)->where(['and',[ 'activity.event_id'=>ArrayHelper::getColumn($queryEvents->all() , 'id')],['or', ['not', ['activity.user_id' => null]], ['not', ['activity.team_id' => null]]]]);
		//$query->andFilterWhere();
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['start_date'=>SORT_ASC,'global_order'=>SORT_ASC]],
            'pagination' => ['pageSize' => $pageSize]
        ]);
		
        $dataProvider->sort->attributes['start_date'] = [
            'asc' => ['start_date' => SORT_ASC],
            'desc' => ['start_date' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['team.name'] = [
            'asc' => ['team.name' => SORT_ASC],
            'desc' => ['team.name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['user.display_name'] = [
            'asc' => ['user.display_name' => SORT_ASC],
            'desc' => ['user.display_name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['status'] = [
            'asc' => ['status' => SORT_ASC],
            'desc' => ['status' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['event.name'] = [
            'asc' => ['event.name' => SORT_ASC],
            'desc' => ['event.name' => SORT_DESC],
        ];		

        return $dataProvider;
    }
}







