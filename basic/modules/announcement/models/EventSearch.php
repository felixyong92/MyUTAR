<?php

namespace app\modules\announcement\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\announcement\models\Event;
use asinfotrack\yii2\audittrail\behaviors\AuditTrailBehavior;

/**
 * EventSearch represents the model behind the search form about `app\modules\announcement\models\Event`.
 */
class EventSearch extends Event
{
	public $department = '';
    public $status;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['title', 'venue', 'time', 'startDate', 'endDate', 'fee', 'type', 'description', 'publishDate', 'image', 'attachment', 'dId', 'status'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $currentDate = date("Y-m-d");

        $query = Event::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort'=> ['defaultOrder' => ['publishDate' => SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

		if (Yii::$app->user->identity->dsResponsibility !== 'Super Admin') {
			$this->department = Yii::$app->user->identity->dId;
		}

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            // 'publishDate' => $this->publishDate,
            // 'expiryDate' => $this->expiryDate,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'venue', $this->venue])
						->andFilterWhere(['like', 'time', $this->time])
						->andFilterWhere(['like', 'startDate', $this->startDate])
						->andFilterWhere(['like', 'endDate', $this->endDate])
						->andFilterWhere(['like', 'fee', $this->fee])
						->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'publishDate', $this->publishDate])
						->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'attachment', $this->attachment])
			->andFilterWhere(['like', 'dId', $this->department])
            ->andFilterWhere(['like', 'dId', $this->dId]);

        if($this->status =='Upcoming'){
            $query->andFilterWhere(['>', 'endDate', $currentDate]);
        }else if($this->status =='Archived'){
            $query->andFilterWhere(['<', 'endDate', $currentDate]);
        } else if($this->status =='Today'){
            $query->andFilterWhere(['endDate' => $currentDate]);
        }

        // var_dump($this->status);exit();
        return $dataProvider;
    }

		public function behaviors(){
    return [
    	// ...
    	'audittrail'=>[
    		'class'=>AuditTrailBehavior::className(),

    		// some of the optional configurations
    		'ignoredAttributes'=>['created_at','updated_at'],
    		'consoleUserId'=>1,

        'attributeOutput'=>[
				'desktop_id'=>function ($value) {
					$model = Desktop::findOne($value);
					return sprintf('%s %s', $model->manufacturer, $model->device_name);
				},
				'last_checked'=>'datetime',
			],
    	],
    	// ...
    ];
}

}
