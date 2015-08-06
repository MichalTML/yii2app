<?php

namespace frontend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\OClientContacts;

/**
 * OClientContactsSearch represents the model behind the search form about `frontend\models\OClientContacts`.
 */
class OClientContactsSearch extends OClientContacts
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
            [['client.name', 'firstName', 'lastName', 'gender.genderName', 'phone', 'email', 'department', 'position', 'creUser.username','creTime'], 'safe'],
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
        $query = OClientContacts::find();
        $query->joinWith(['creUser', 'client', 'gender']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $dataProvider->sort->attributes['creUser.username'] =
                [
                    'asc' => ['user.username' => SORT_ASC],
                    'desc' => ['user.username' => SORT_DESC],
                ];
        
        $dataProvider->sort->attributes['client.name'] =
                [
                    'asc' => ['o_client_data.name' => SORT_ASC],
                    'desc' => ['o_client_data.name' => SORT_DESC],
                ];
                
        $dataProvider->sort->attributes['gender.genderName'] =
                [
                    'asc' => ['gender.genderName' => SORT_ASC],
                    'desc' => ['gender.genderName' => SORT_DESC],
                ];
                        


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'firstName', $this->firstName])
            ->andFilterWhere(['like', 'lastName', $this->lastName])
            ->andFilterWhere(['like', 'o_client_contacts.creTime', $this->creTime])
            ->andFilterWhere(['like', 'o_client_contacts.phone', $this->phone])
            ->andFilterWhere(['like', 'fax', $this->fax])
            ->andFilterWhere(['like', 'o_client_contacts.email', $this->email])
            ->andFilterWhere(['like', 'department', $this->department])
            ->andFilterWhere(['like', 'position', $this->position])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'user.username', $this->getAttribute( 'creUser.username')])
            ->andFilterWhere(['=', 'gender.genderName', $this->getAttribute( 'gender.genderName')])
            ->andFilterWhere(['like', 'o_client_data.name', $this->getAttribute( 'client.name')]);

        return $dataProvider;
    }
}
