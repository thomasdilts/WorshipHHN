<?php
namespace app\models;

use yii\data\ActiveDataProvider;
use yii\base\Model;
use Yii;

/**
 * UserSearch represents the model behind the search form for app\models\User.
 */
class ActivityTypeSearch extends ActivityType
{
    /**
     * Returns the validation rules for attributes.
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['name','use_team_or_user','use_name','use_globally','use_song','use_file','default_start_time','default_end_time', 'default_global_order'], 'safe'],
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
        $query = ActivityType::getAllActivityTypes(Yii::$app->user->identity->church_id);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['name'=>SORT_ASC]],
            'pagination' => ['pageSize' => $pageSize]
        ]);

        $dataProvider->sort->attributes['name'] = [
            'asc' => ['name' => SORT_ASC],
            'desc' => ['name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['default_start_time'] = [
            'asc' => ['default_start_time' => SORT_ASC],
            'desc' => ['default_start_time' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['default_global_order'] = [
            'asc' => ['default_global_order' => SORT_ASC],
            'desc' => ['default_global_order' => SORT_DESC],
        ];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
		$query->andFilterWhere(['like', 'name', $this->name])
			->andFilterWhere(['like', 'default_start_time', $this->default_start_time])
			->andFilterWhere(['like', 'default_global_order', $this->default_global_order]);
        return $dataProvider;
    }
}
