<?php
namespace app\models;

use yii\data\ActiveDataProvider;
use yii\base\Model;
use Yii;

/**
 * UserSearch represents the model behind the search form for app\models\User.
 */
class MessageTemplateSearch extends MessageTemplate
{

    /**
     * Returns the validation rules for attributes.
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['church_id', 'language_id','message_type_id', 'name', 'show_accept_button', 'show_reject_button', 'show_link_to_object', 'allow_custom_message', 'accept_button_text', 'reject_button_text', 'link_text', 'subject'], 'safe'],
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
        $query = MessageTemplate::getAllMessageTemplates(Yii::$app->user->identity->church_id)->joinWith('language',true)->joinWith('messageType',true);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['name'=>SORT_ASC,'messageType.name'=>SORT_ASC,'language.iso_name'=>SORT_ASC,]],
            'pagination' => ['pageSize' => $pageSize]
        ]);

        $dataProvider->sort->attributes['name'] = [
            'asc' => ['name' => SORT_ASC],
            'desc' => ['name' => SORT_DESC],
        ];        
        $dataProvider->sort->attributes['messageType.name'] = [
            'asc' => ['message_type.name' => SORT_ASC],
            'desc' => ['message_type.name' => SORT_DESC],
        ];        
        $dataProvider->sort->attributes['language.iso_name'] = [
            'asc' => ['language.iso_name' => SORT_ASC],
            'desc' => ['language.iso_name' => SORT_DESC],
        ];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
		$query->andFilterWhere(['like', 'name', $this->name]);
        return $dataProvider;
    }
}
