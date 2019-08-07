<?php
namespace app\models;

use yii\data\ActiveDataProvider;
use yii\base\Model;
use Yii;

/**
 * UserSearch represents the model behind the search form for app\models\User.
 */
class SongSearch extends Song
{
    /**
     * Returns the validation rules for attributes.
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['name','name2','description','author'], 'safe'],
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
        $query = Song::getAllSongs(Yii::$app->user->identity->church_id);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['name'=>SORT_ASC]],
            'pagination' => ['pageSize' => $pageSize]
        ]);

        $dataProvider->sort->attributes['name'] = [
            'asc' => ['name' => SORT_ASC],
            'desc' => ['name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['name2'] = [
            'asc' => ['name2' => SORT_ASC],
            'desc' => ['name2' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['author'] = [
            'asc' => ['author' => SORT_ASC],
            'desc' => ['author' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['description'] = [
            'asc' => ['description' => SORT_ASC],
            'desc' => ['description' => SORT_DESC],
        ];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        $query->andFilterWhere(['like', 'name', $this->name])
              ->andFilterWhere(['like', 'name2', $this->name2])
              ->andFilterWhere(['like', 'author', $this->author])
			  ->andFilterWhere(['like', 'description', $this->description]);
        return $dataProvider;
    }
}
