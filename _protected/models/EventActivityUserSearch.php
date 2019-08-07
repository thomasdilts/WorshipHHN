<?php
namespace app\models;

use app\rbac\models\AuthItem;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\base\Model;
use Yii;

/**
 * UserSearch represents the model behind the search form for app\models\User.
 */
class EventActivityUserSearch extends Activity
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
            [['username', 'email', 'status', 'item_name'], 'safe'],
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

        $query = Activity::getAllActivities($this->event->id)->joinWith('user', true)->joinWith('team', true);

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
        $dataProvider->sort->attributes['name'] = [
            'asc' => ['name' => SORT_ASC],
            'desc' => ['name' => SORT_DESC],
        ];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        return $dataProvider;
    }
    public function getArray(){

        $dataProvider = $this->search(Yii::$app->request->queryParams, 10000);
        if (($sort = $dataProvider->getSort()) !== false) {
            $dataProvider->query->addOrderBy($sort->getOrders());
        }

        $activities = $dataProvider->query->all($dataProvider->db); 
        $returnArray = array();
        foreach($activities as $row){ 
            $rowObj=array();
            $rowObj['name']=$row->name;
            $rowObj['action_id']=$row->id;
            if($row['user']!=null){ 
                $rowObj['display_name']=$row['user']['display_name'];
                $rowObj['user_id']=$row['user']['id'];
                $rowObj['email']=$row['user']['email'];
                $rowObj['teamname']='';
                array_push($returnArray,$rowObj);
            }else if($row['team_id']!=null  ){ 
                $teamModel = Team::findOne($row['team_id']);
                $query = $teamModel->getTeamUsers()->joinWith(['teamUser b'])->where(['b.team_id'=>$row['team_id']])->all();
                foreach($query as $user){ 
                    $byTeam = ArrayHelper::index($user->teamUser, 'team_id');

                    if($byTeam[$row['team_id']]->admin){    
                        $rowObj['display_name']=$user['display_name'];
                        $rowObj['user_id']=$user['id'];
                        $rowObj['email']=$user['email'];
                        $rowObj['teamname']=$teamModel->name;
                        array_push($returnArray,$rowObj);
                    }
                }
            }

        } 

        return $returnArray;
    }

    public function getAllNotifyData($actionid, $userid, $eventid, $model){
        $searchModel = new MessageTemplateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 100000);
        if (($sort = $dataProvider->getSort()) !== false) {
            $dataProvider->query->addOrderBy($sort->getOrders());
        }
  
        $templates = $dataProvider->query->where(['message_template.language_id'=>Yii::$app->user->identity->language_id])->all($dataProvider->db);         
        $templateArray=ArrayHelper::toArray($templates,['church_id', 'language_id', 'name', 'show_accept_button', 'use_auto_subject', 'show_reject_button', 'show_link_to_object', 'allow_custom_message', 'accept_button_text', 'reject_button_text', 'link_text', 'subject','usage','body']);
        $event=Event::findOne($eventid);
        if($userid){
            $user=User::findOne($userid);
            $activity=Activity::findOne($actionid);
            $subject=$event->name . ' ' . Yii::$app->formatter->asDate($event->start_date, "Y-MM-dd H:mm") . ' ' . $activity->name;
            $emails=$user->email;
        }else{
            $searchPersonsModel = new EventActivityUserSearch();
            $searchPersonsModel->event = $event;
            $allusers = $searchPersonsModel->getArray();
            $emails=implode('; ', ArrayHelper::getColumn($allusers, 'email'));
            $subject=$event->name . ' ' . Yii::$app->formatter->asDate($event->start_date, "Y-MM-dd H:mm");
        }

        return [
            'subject'=>$subject, 
            'emails'=>$emails, 
            'jsonTemplates'=>json_encode($templateArray),
            'actionid'=>$actionid, 
            'userid'=>$userid, 
            'eventid'=>$eventid,
            'templates' => $templates,
            'model' => $model,
        ];   

    }
}
