<?php

namespace frontend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\ClientData;

/**
 * ClientSearch represents the model behind the search form about `frontend\models\ClientData`.
 */
class ClientSearch extends ClientData
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'phone', 'fax', 'krs', 'regon', 'creUserId', 'updUserId'], 'integer'],
            [['name', 'abr', 'adress', 'email', 'nip', 'www', 'creTime', 'updTime'], 'safe'],
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
        $query = ClientData::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'phone' => $this->phone,
            'fax' => $this->fax,
            'krs' => $this->krs,
            'regon' => $this->regon,
            'creTime' => $this->creTime,
            'updTime' => $this->updTime,
            'creUserId' => $this->creUserId,
            'updUserId' => $this->updUserId,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'abr', $this->abr])
            ->andFilterWhere(['like', 'adress', $this->adress])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'nip', $this->nip])
            ->andFilterWhere(['like', 'www', $this->www]);

        return $dataProvider;
    }
}
