<?php
namespace app\models;

use yii\data\ActiveDataProvider;
use yii\base\Model;
use Yii;

/**
 * UserSearch represents the model behind the search form for app\models\User.
 */
class EventSearch extends Event
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
            [['description','filter_start_date','filter_end_date','name','use_team_or_user','use_name','use_globally','use_song','use_file','default_start_time','default_end_time'], 'safe'],
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
        $query = Event::getAllEvents(Yii::$app->user->identity->church_id);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['start_date'=>SORT_ASC]],
            'pagination' => ['pageSize' => $pageSize]
        ]);

        $dataProvider->sort->attributes['start_date'] = [
            'asc' => ['start_date' => SORT_ASC],
            'desc' => ['start_date' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['name'] = [
            'asc' => ['name' => SORT_ASC],
            'desc' => ['name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['description'] = [
            'asc' => ['description' => SORT_ASC],
            'desc' => ['description' => SORT_DESC],
        ];
		
		$this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

		$query->andFilterWhere(['between', 'start_date', $this->filter_start_date, $this->filter_end_date])
			->andFilterWhere(['like', 'name', $this->name])
			->andFilterWhere(['like', 'description', $this->description]);
        return $dataProvider;
    }
}







