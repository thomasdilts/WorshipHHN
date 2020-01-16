<?php
namespace app\models;

use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\base\Model;
use Yii;
use yii\helpers\Url;

/**
 * UserSearch represents the model behind the search form for app\models\User.
 */
class EventActivitySearch extends Activity 
{
	public $filter_start_date;
    public $filter_end_date;
    public $user_display_name;
    public $team_name;
    public $event_name;

    /**
     * Returns the validation rules for attributes.
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['event_name','team_name','user_display_name','filter_start_date','filter_end_date','name','use_team_or_user','use_name','use_globally','use_song','use_file','default_start_time','default_end_time'], 'safe'],
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
	public static function getStatus($model,$isHtml=true){
		$value='';
		$color='';
		$notifications= Notification::find()->where(['activity_id'=>$model->id])->all();
		if($notifications && count($notifications)>0) {									
			$statuses = ArrayHelper::getColumn($notifications,'status');
			if(in_array('Accepted',$statuses)){
				$value.=($isHtml?'<span style="color:lightgreen">':'').Yii::t('app', 'Accepted').($isHtml?'</span>':'');
			}elseif(in_array('Not replied yet',$statuses)) {
				$value.=($isHtml?'<span style="color:goldenrod">':'').Yii::t('app', 'Not replied yet').($isHtml?'</span>':'');
				$color='yellow';
			}elseif(in_array('Rejected',$statuses)) {
				$value.=($isHtml?'<span style="color:red">':'').Yii::t('app', 'Rejected').($isHtml?'</span>':'');
				$color='red';
			}
		}
		if(isset($model->team) && $model->team->IsTeamBlocked($model->event->start_date)){
			$value.=strlen($value)>0?'; ':'';
			$value.=($isHtml?'<span style="color:red">':'').Yii::t('app', 'Unavailable-team').($isHtml?'</span>':'');	
			$color='red';			
		}elseif(isset($model->user) && $model->user->IsUserBlocked($model->event->start_date)){
			$value.=strlen($value)>0?'; ':'';
			$value.=($isHtml?'<span style="color:red">':'').Yii::t('app', 'Unavailable-user').($isHtml?'</span>':'');		
			$color='red';			
		}	
		
		if($model->activityType->using_team=='Demand' && !$model->team_id && (!$model->freehand_team || strlen($model->freehand_team)<2) ){
			$value.=strlen($value)>0?'; ':'';
			$value.=($isHtml?'<span style="color:red">':'').Yii::t('app', 'Missing-team').($isHtml?'</span>':'');	
			$color='red';			
		}elseif($model->activityType->using_user=='Demand' && !$model->user_id && (!$model->freehand_user || strlen($model->freehand_user)<2)){
			$value.=strlen($value)>0?'; ':'';
			$value.=($isHtml?'<span style="color:red">':'').Yii::t('app', 'Missing-user').($isHtml?'</span>':'');		
			$color='red';			
		}			
		return [$value,$color];
	}
	
    /**
     * Creates data provider instance with search query applied.
     *
     * @param  array   $params
     * @param  integer $pageSize How many users to display per page.
     * @return ActiveDataProvider
     */
    public function search($params, $pageSize = 20)
    {
        $query = Activity::find()->joinWith('activityType',true)->joinWith('event',true)->joinWith('user', true)->joinWith('team', true)->where(['and',['between', 'event.start_date', $this->filter_start_date, $this->filter_end_date],'event.church_id'=>Yii::$app->user->identity->church_id,['or', ['activity_type.using_user' => 'Demand'], ['activity_type.using_team' => 'Demand']]]);
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['start_date'=>SORT_ASC]],
            'pagination' => ['pageSize' => $pageSize]
        ]);
		
        $dataProvider->sort->attributes['start_date'] = [
            'asc' => ['start_date' => SORT_ASC],
            'desc' => ['start_date' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['team_name'] = [
            'asc' => ['team.name' => SORT_ASC],
            'desc' => ['team.name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['user_display_name'] = [
            'asc' => ['user.display_name' => SORT_ASC],
            'desc' => ['user.display_name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['event_name'] = [
            'asc' => ['event.name' => SORT_ASC],
            'desc' => ['event.name' => SORT_DESC],
        ];		
        $dataProvider->sort->attributes['name'] = [
            'asc' => ['activity.name' => SORT_ASC],
            'desc' => ['activity.name' => SORT_DESC],
        ];		

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
		
		$query->andFilterWhere(['like', 'activity.name', $this->name])
			->andFilterWhere(['like', 'user.display_name', $this->user_display_name])
			->andFilterWhere(['like', 'event.name', $this->event_name])
			->andFilterWhere(['like', 'team.name', $this->team_name]);
		
        return $dataProvider;
    }
}







