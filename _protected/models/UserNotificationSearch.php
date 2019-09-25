<?php
namespace app\models;

use app\rbac\models\AuthItem;
use yii\data\ActiveDataProvider;
use yii\base\Model;
use Yii;

/**
 * UserSearch represents the model behind the search form for app\models\User.
 */
class UserNotificationSearch extends UserNotification
{
    /**
     * Returns the validation rules for attributes.
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['notified_date'], 'safe'],
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
		$whereArray=['user_notification.team_id'=>$this->team_id];
		if($this->user_from_id){
			$whereArray=['and', 'user_notification.team_id IS NULL', ['or', 'user_from_id='.$this->user_from_id, 'user_to_id='.$this->user_from_id]];
		}
		$query = UserNotification::find()->where($whereArray)->joinWith('userFrom a')->joinWith('userTo b');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['notified_date'=>SORT_DESC]],
            'pagination' => ['pageSize' => $pageSize]
        ]);

        $dataProvider->sort->attributes['notified_date'] = [
            'asc' => ['notified_date' => SORT_ASC],
            'desc' => ['notified_date' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['display_name'] = [
            'asc' => ['a.display_name' => SORT_ASC],
            'desc' => ['a.display_name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['b.display_name'] = [
            'asc' => ['b.display_name' => SORT_ASC],
            'desc' => ['b.display_name' => SORT_DESC],
        ];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        return $dataProvider;
    }
}
