<?php

namespace frontend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\ClientContacts;

/**
 * ClientContactsSearch represents the model behind the search form about `frontend\models\ClientContacts`.
 */
class ClientContactsSearch extends ClientContacts
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['clientId', 'creUserId', 'updUserId'], 'integer'],
            [['firstName', 'lastName', 'gender', 'phone', 'fax', 'email', 'department', 'position', 'creTime', 'updTime', 'description'], 'safe'],
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
        $query = ClientContacts::find();
        $query->joinWith(['client', 'gender', 'creUser']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $dataProvider->sort->attributes['clientName'] =
                [
                    'asc' => ['client_data.name' => SORT_ASC],
                    'desc' => ['client_data.name' => SORT_DESC],
                ];
        
        $dataProvider->sort->attributes['genderName'] =
                [
                    'asc' => ['gender.genderName' => SORT_ASC],
                    'desc' => ['gender.genderName' => SORT_DESC],
                ];
        $dataProvider->sort->attributes['creUserName'] =
                [
                    'asc' => ['user.username' => SORT_ASC],
                    'desc' => ['user.username' => SORT_DESC],
                ];
        
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'clientId' => $this->clientId,
            'creTime' => $this->creTime,
            'creUserId' => $this->creUserId,
            'updTime' => $this->updTime,
            'updUserId' => $this->updUserId,
        ]);

        $query->andFilterWhere(['like', 'firstName', $this->firstName])
            ->andFilterWhere(['like', 'lastName', $this->lastName])
            ->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'fax', $this->fax])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'department', $this->department])
            ->andFilterWhere(['like', 'position', $this->position])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'user.username', $this->creUser])
            ->andFilterWhere(['like', 'gender.genderName', $this->gender])
            ->andFilterWhere(['like', 'client_data.name', $this->client]);

        return $dataProvider;
    }
}
