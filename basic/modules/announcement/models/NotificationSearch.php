<?php

namespace app\modules\announcement\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\announcement\models\Notification;

/**
 * NotificationSearch represents the model behind the search form about `app\modules\announcement\models\Notification`.
 */
class NotificationSearch extends Notification
{
	public $department = '';
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['title', 'description', 'publishDate', 'image', 'attachment', 'link', 'department', 'dId'], 'safe'],
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
        $query = Notification::find();

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
            //'publishDate' => $this->publishDate,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'attachment', $this->attachment])
            ->andFilterWhere(['like', 'publishDate', $this->publishDate])
            ->andFilterWhere(['like', 'link', $this->link])
            ->andFilterWhere(['like', 'department', $this->department])
            ->andFilterWhere(['like', 'dId', $this->dId]);

        return $dataProvider;
    }
}
