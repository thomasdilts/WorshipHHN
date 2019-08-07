<?php
namespace app\models;

use app\models\Team;
use app\models\User;
use app\models\TeamUser;
use app\rbac\models\AuthItem;
use yii\data\ActiveDataProvider;
use yii\base\Model;
use Yii;

/**
 * UserSearch represents the model behind the search form for app\models\User.
 */
class TeamMemberSearch extends User
{
	public $teamModel;
	public $admin;
	
    /**
     * Returns the validation rules for attributes.
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['display_name', 'email'], 'safe'],
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
        $query = $this->teamModel->getTeamUsers()->joinWith(['teamUser b'])->where(['b.team_id'=>$this->teamModel->id]);
				
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id'=>SORT_ASC]],
            'pagination' => ['pageSize' => $pageSize]
        ]);

        $dataProvider->sort->attributes['display_name'] = [
            'asc' => ['display_name' => SORT_ASC],
            'desc' => ['display_name' => SORT_DESC],
        ];        
		$dataProvider->sort->attributes['email'] = [
            'asc' => ['email' => SORT_ASC],
            'desc' => ['email' => SORT_DESC],
        ];


        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'display_name', $this->display_name])
              ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
