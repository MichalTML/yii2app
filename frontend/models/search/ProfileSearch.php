<?php

namespace frontend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Profile;

/**
 * ProfileSearch represents the model behind the search form about `frontend\models\Profile`.
 */
class ProfileSearch extends Profile
{
    /**
     * @inheritdoc
     */
     public function attributes() {
        return array_merge(parent::attributes(), ['user.email', 'role.role_name']);
    }
   
    public function rules()
    {
        return [
            [['firstName', 'lastName', 'birthdate', 'created', 'updated', 'user.email', 'role.role_name'], 'safe'],
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
        $query = Profile::find();
        $query->joinWith(['user']);
        $query->joinWith(['role']);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $dataProvider->sort->attributes['user.email'] =
                [
                    'asc' => ['user.email' => SORT_ASC],
                    'desc' => ['user.email' => SORT_DESC],
                ];
        
        $dataProvider->sort->attributes['role.role_name'] =
                [
                    'asc' => ['role.role_name' => SORT_ASC],
                    'desc' => ['role.role_name' => SORT_DESC],
                ];
        
        $this->load($params);
        
      
        
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'userId' => $this->userId,
            'birthdate' => $this->birthdate,
            'genderId' => $this->genderId,
            'created' => $this->created,
            'updated' => $this->updated,
        ]);

        $query->andFilterWhere(['like', 'firstName', $this->firstName])
            ->andFilterWhere(['like', 'lastName', $this->lastName])
            ->andFilterWhere(['like', 'user.email', $this->getAttribute('user.email')])
            ->andFilterWhere(['=', 'role.role_name', $this->getAttribute( 'role.role_name')]);

        return $dataProvider;
    }
}
