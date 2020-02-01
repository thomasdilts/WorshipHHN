<?php
namespace app\models;

use yii\data\ActiveDataProvider;
use yii\base\Model;
use Yii;

/**
 * UserSearch represents the model behind the search form for app\models\User.
 */
class PictureSearch extends Picture
{

    /**
     * Returns the validation rules for attributes.
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['name','description','imageFiles'], 'safe'],
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
		$query = Picture::find()->where(['church_id'=>Yii::$app->user->identity->church_id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['name'=>SORT_ASC]],
            'pagination' => ['pageSize' => $pageSize]
        ]);

        $dataProvider->sort->attributes['name'] = [
            'asc' => ['name' => SORT_ASC],
            'desc' => ['name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['description'] = [
            'asc' => ['description' => SORT_ASC],
            'desc' => ['description' => SORT_DESC],
        ];


        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        $query->andFilterWhere(['like', 'name', $this->name])
			  ->andFilterWhere(['like', 'description', $this->description]);
        return $dataProvider;
    }
}
