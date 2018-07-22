<?php

namespace app\modules\staff\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\staff\models\Staff;

/**
 * StaffSearch represents the model behind the search form about `app\modules\staff\models\Staff`.
 */
class StaffSearch extends Staff
{

    public $busStatus;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dsId', 'dsName', 'dsEmail', 'dsResponsibility', 'dId'], 'safe'],
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
		
        $query = Staff::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort'=> ['defaultOrder' => ['dsName' => SORT_ASC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'dsId', $this->dsId])
            ->andFilterWhere(['like', 'dsName', $this->dsName])
            ->andFilterWhere(['like', 'dsEmail', $this->dsEmail])
            ->andFilterWhere(['like', 'dsResponsibility', $this->dsResponsibility])
			->andFilterWhere(['<>', 'dsResponsibility', 'Super Admin'])
            ->andFilterWhere(['like', 'dId', $this->dId]);

        return $dataProvider;
    }
}
