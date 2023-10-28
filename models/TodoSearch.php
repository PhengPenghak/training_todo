<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Todo;
use Yii;

/**
 * TodoSearch represents the model behind the search form of `app\models\Todo`.
 */
class TodoSearch extends Todo
{
    /**
     * {@inheritdoc}
     */
    public $globalSearch;
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['title', 'globalSearch', 'create_at', 'date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Todo::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        if (key_exists('status', $params)) {
            //if (isset($_GET['status'])) {
            //if (Yii::$app->request->get('status')) {
            $query->andFilterWhere([
                'status' => $params['status'],
            ]);
            //echo "have key status";
            //} else {
            //echo "have not key status";
        }
        //exit;
        // grid filtering conditions
        // $query->andFilterWhere([
        //     'id' => $this->id,
        //     'title' => $this->title,
        //     'status' => $this->status,
        //     'create_at' => $this->create_at,
        //     'date' => $this->date,
        // ]);

        $query->orFilterWhere(['like', 'title', $this->globalSearch])
            ->orFilterWhere(['like', 'status', $this->globalSearch])
            ->orFilterWhere(['like', 'date', $this->globalSearch])
            ->orFilterWhere(['like', 'create_at', $this->globalSearch]);

        // $query->andFilterWhere([
        //     'OR',
        //     ['like', 'id', $this->globalSearch],


        // ]);
        return $dataProvider;
    }
}
