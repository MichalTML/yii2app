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
    public function attributes() {
        return array_merge(parent::attributes(), ['status.statusName', 'creUser.username']);
    }
    
    public function rules()
    {
        return [
            [['status.statusName', 'name', 'phone', 'email', 'nip', 'krs', 'regon', 'creTime', 'creUser.username', 'city'], 'safe'],
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
        $query->joinWith(['creUser', 'status']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->sort->attributes['creUser.username'] = 
                [
                    'asc' => ['user.username' => SORT_ASC],
                    'desc' => ['user.username' => SORT_DESC],
                ];
        $dataProvider->sort->attributes['status.statusName'] =
                [
                    'asc' => ['o_client_data_status.statusName' => SORT_ASC],
                    'desc' => ['o_client_data_status.statusName' => SORT_DESC],
                ];
        
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'clientNumber', $this->clientNumber])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere( ['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'abr', $this->abr])
            ->andFilterWhere(['like', 'adress', $this->adress])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'postal', $this->postal])
            ->andFilterWhere(['like', 'o_client_data.email', $this->email])
            ->andFilterWhere(['like', 'nip', $this->nip])
            ->andFilterWhere(['like', 'regon', $this->regon])
            ->andFilterWhere(['like', 'krs', $this->krs])
            ->andFilterWhere(['like', 'www', $this->www])
            ->andFilterWhere(['like', 'creTime', $this->creTime])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'user.username', $this->getAttribute('creUser.username')])
            ->andFilterWhere(['=', 'o_client_data_status.statusName', $this->getAttribute('status.statusName')]);

        return $dataProvider;
    }
}
