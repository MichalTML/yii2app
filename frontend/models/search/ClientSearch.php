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
            [['id', 'clientNumber', 'phone', 'fax', 'krs', 'regon', 'creUserId', 'updUserId', 'contactId'], 'integer'],
            [['name', 'abr', 'adress', 'email', 'nip', 'www', 'creDate', 'updDate'], 'safe'],
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
            'clientNumber' => $this->clientNumber,
            'phone' => $this->phone,
            'fax' => $this->fax,
            'krs' => $this->krs,
            'regon' => $this->regon,
            'creDate' => $this->creDate,
            'updDate' => $this->updDate,
            'creUserId' => $this->creUserId,
            'updUserId' => $this->updUserId,
            'contactId' => $this->contactId,
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
