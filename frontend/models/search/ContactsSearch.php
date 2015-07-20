<?php

namespace frontend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Contacts;

/**
 * ContactsSearch represents the model behind the search form about `frontend\models\Contacts`.
 */
class ContactsSearch extends Contacts
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['clientId'], 'integer'],
            [['firstlastName', 'gender', 'phone', 'fax', 'email', 'department', 'position', 'creTime', 'creUser', 'updTime', 'updUser', 'description'], 'safe'],
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
        $query = Contacts::find();

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
            'clientId' => $this->clientId,
            'creTime' => $this->creTime,
            'updTime' => $this->updTime,
        ]);

        $query->andFilterWhere(['like', 'firstlastName', $this->firstlastName])
            ->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'fax', $this->fax])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'department', $this->department])
            ->andFilterWhere(['like', 'position', $this->position])
            ->andFilterWhere(['like', 'creUser', $this->creUser])
            ->andFilterWhere(['like', 'updUser', $this->updUser])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
