<?php
namespace app\models;

use yii\data\ActiveDataProvider;
use yii\base\Model;
use Yii;
use yii\web\ServerErrorHttpException;


/**
 * TeamSearch represents the model behind the search form for app\models\Team.
 */
class TeamBlockedSearch extends TeamBlocked
{
    /**
     * Returns the validation rules for attributes.
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['filter_start_date','filter_end_date','start_date','end_date','team_id'], 'safe'],
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
    public function search($params, $pageSize = 10)
    {
		if($this->teamModel==null){
			throw new ServerErrorHttpException('this->teamModel==null');
		}
        $query = TeamBlocked::getAllTeamBlockeds($this->teamModel->id);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['start_date'=>SORT_ASC]],
            'pagination' => ['pageSize' => $pageSize]
        ]);

        $dataProvider->sort->attributes['start_date'] = [
            'asc' => ['start_date' => SORT_ASC],
            'desc' => ['start_date' => SORT_DESC],
        ];

		
		$this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

		$query->andFilterWhere(['or',['between', 'start_date', $this->filter_start_date, $this->filter_end_date],['between', 'end_date', $this->filter_start_date, $this->filter_end_date]]);

        return $dataProvider;
    }
}
