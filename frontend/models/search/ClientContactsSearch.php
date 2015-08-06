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
    
    public function attributes() {
        return array_merge(parent::attributes(), ['client.name', 'gender.genderName', 'creUser.username']);
    }
    
    public function rules()
    {
        return [
            [['firstName', 'lastName', 'gender', 'phone', 'fax', 'email', 'department', 'position', 'creTime', 'updTime', 'description', 'client.name', 'gender.genderName', 'creUser.username'], 'safe'],
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
        
        $dataProvider->sort->attributes['client.name'] =
                [
                    'asc' => ['client_data.name' => SORT_ASC],
                    'desc' => ['client_data.name' => SORT_DESC],
                ];
        
        $dataProvider->sort->attributes['gender.genderName'] =
                [
                    'asc' => ['gender.genderName' => SORT_ASC],
                    'desc' => ['gender.genderName' => SORT_DESC],
                ];
        $dataProvider->sort->attributes['creUser.username'] =
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

        $query->andFilterWhere(['like', 'firstName', $this->firstName])
            ->andFilterWhere(['like', 'lastName', $this->lastName])
            ->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'client_contacts.phone', $this->phone])
            ->andFilterWhere(['like', 'fax', $this->fax])
            ->andFilterWhere(['like', 'client_contacts.email', $this->email])
            ->andFilterWhere(['like', 'department', $this->department])
            ->andFilterWhere(['like', 'position', $this->position])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'user.username', $this->getAttribute('creUser.name')])
            ->andFilterWhere(['=', 'gender.genderName', $this->getAttribute('gender.genderName')])
            ->andFilterWhere(['like', 'client_data.name', $this->getAttribute('client.name')]);

        return $dataProvider;
    }
}
