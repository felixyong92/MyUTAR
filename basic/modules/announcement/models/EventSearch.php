<?php

namespace app\modules\announcement\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\announcement\models\Event;

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
            [['title', 'venue', 'time', 'fee', 'type', 'description', 'publishDate', 'image', 'attachment', 'expiryDate', 'dId', 'status'], 'safe'],
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
						->andFilterWhere(['like', 'fee', $this->fee])
						->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'publishDate', $this->publishDate])
            ->andFilterWhere(['like', 'expiryDate', $this->expiryDate])
            ->andFilterWhere(['like', 'attachment', $this->attachment])
			->andFilterWhere(['like', 'dId', $this->department])
            ->andFilterWhere(['like', 'dId', $this->dId]);

        if($this->status =='Upcoming'){
            $query->andFilterWhere(['>', 'expiryDate', $currentDate]);
        }else if($this->status =='Archived'){
            $query->andFilterWhere(['<', 'expiryDate', $currentDate]);
        } else if($this->status =='Today'){
            $query->andFilterWhere(['expiryDate' => $currentDate]);
        }

        // var_dump($this->status);exit();
        return $dataProvider;
    }

}
