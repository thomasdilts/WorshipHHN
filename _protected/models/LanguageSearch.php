<?php
namespace app\models;

use yii\data\ActiveDataProvider;
use yii\base\Model;
use Yii;

/**
 * UserSearch represents the model behind the search form for app\models\User.
 */
class LanguageSearch extends Language
{
    /**
     * Returns the validation rules for attributes.
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['display_name_english','display_name_native','iso_name'], 'safe'],
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
        $query = Language::getAllLanguages(Yii::$app->user->identity->church_id);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['display_name_english'=>SORT_ASC]],
            'pagination' => ['pageSize' => $pageSize]
        ]);

        $dataProvider->sort->attributes['display_name_english'] = [
            'asc' => ['display_name_english' => SORT_ASC],
            'desc' => ['display_name_english' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['display_name_native'] = [
            'asc' => ['display_name_native' => SORT_ASC],
            'desc' => ['display_name_native' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['iso_name'] = [
            'asc' => ['iso_name' => SORT_ASC],
            'desc' => ['iso_name' => SORT_DESC],
        ];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        $query->andFilterWhere(['like', 'display_name_english', $this->display_name_english])
              ->andFilterWhere(['like', 'display_name_native', $this->display_name_native])
              ->andFilterWhere(['like', 'iso_name', $this->iso_name]);
        return $dataProvider;
    }
}
