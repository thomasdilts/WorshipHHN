<?php
namespace app\models;

use yii\data\ActiveDataProvider;
use yii\base\Model;
use Yii;

/**
 * UserSearch represents the model behind the search form for app\models\User.
 */
class TeamSearch extends Team
{
	public $teamtypename;
    /**
     * Returns the validation rules for attributes.
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['name','team-type'], 'safe'],
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
		if(Yii::$app->user->can('TeamManager')){
			$query = Team::find()->where(['team.church_id'=>Yii::$app->user->identity->church_id]);
		}else{
			$user=User::findOne(Yii::$app->user->id);
			$query =  $user->getTeams();
		}
		$query -> joinWith(['teamType']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['team.name'=>SORT_ASC]],
            'pagination' => ['pageSize' => $pageSize]
        ]);

        $dataProvider->sort->attributes['team.name'] = [
            'asc' => ['team.name' => SORT_ASC],
            'desc' => ['team.name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['team_type.name'] = [
            'asc' => ['team_type.name' => SORT_ASC],
            'desc' => ['team_type.name' => SORT_DESC],
        ];


        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        $query->andFilterWhere(['like', 'team.name', $this->name])
			  ->andFilterWhere(['like', 'teamType.name', $this->teamtypename]);
        return $dataProvider;
    }
}
