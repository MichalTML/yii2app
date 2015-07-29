<?php

namespace frontend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\OClientData;

/**
 * OClientDataSearch represents the model behind the search form about `frontend\models\OClientData`.
 */
class OClientDataSearch extends OClientData
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'statusId', 'phone', 'fax', 'krs', 'regon', 'creUserId', 'updUserId'], 'integer'],
            [['clientNumber', 'name', 'abr', 'adress', 'city', 'postal', 'email', 'nip', 'www', 'description', 'creTime', 'updTime'], 'safe'],
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
        $query = OClientData::find();

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
            'statusId' => $this->statusId,
            'phone' => $this->phone,
            'fax' => $this->fax,
            'krs' => $this->krs,
            'regon' => $this->regon,
            'creTime' => $this->creTime,
            'creUserId' => $this->creUserId,
            'updTime' => $this->updTime,
            'updUserId' => $this->updUserId,
        ]);

        $query->andFilterWhere(['like', 'clientNumber', $this->clientNumber])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'abr', $this->abr])
            ->andFilterWhere(['like', 'adress', $this->adress])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'postal', $this->postal])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'nip', $this->nip])
            ->andFilterWhere(['like', 'www', $this->www])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
