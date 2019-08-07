<?php
namespace app\models;

use app\rbac\models\AuthItem;
use yii\data\ActiveDataProvider;
use yii\base\Model;
use Yii;

/**
 * UserSearch represents the model behind the search form for app\models\User.
 */
class NotificationSearch extends Notification
{
    public $event;

    /**
     * Returns the validation rules for attributes.
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['status', 'activity_id', 'event_id', 'notified_date', 'notify_replied_date', 'reminded_date'], 'safe'],
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
        $query = Notification::find()->where(['notification.event_id'=>$this->event->id])->joinWith('user')->joinWith('activity')->joinWith('team');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['user.display_name'=>SORT_ASC]],
            'pagination' => ['pageSize' => $pageSize]
        ]);

        // make item_name (Role) sortable
        $dataProvider->sort->attributes['user.display_name'] = [
            'asc' => ['user.display_name' => SORT_ASC],
            'desc' => ['user.display_name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['activity.name'] = [
            'asc' => ['activity.name' => SORT_ASC],
            'desc' => ['activity.name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['status'] = [
            'asc' => ['status' => SORT_ASC],
            'desc' => ['status' => SORT_DESC],
        ];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        return $dataProvider;
    }
}
