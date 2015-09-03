<?php

namespace frontend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;
use frontend\models\Invoices;

/**
 * UserSearch represents the model behind the search form about `common\models\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
     public function attributes() {
        return array_merge(parent::attributes(), ['status.status_name', 'role.role_name']);
    }
    
    public function rules()
    {
        return [
   [['username', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'created_at', 'updated_at','status.status_name', 'role.role_name'], 'safe'],
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
        $query = User::find()->where( 
            'role_id != :id and role_id != :id2', ['id'=>1, 'id2'=>5]
            );
          $query->joinWith(['status']);
          $query->joinWith(['role']);
          
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
          $dataProvider->sort->attributes['role_id'] =
                [
                    'asc' => ['role.role_name' => SORT_ASC],
                    'desc' => ['role.role_name' => SORT_DESC],
                ];
        
        $dataProvider->sort->attributes['status_id'] =
                [
                    'asc' => ['status.status_name' => SORT_ASC],
                    'desc' => ['status.status_name' => SORT_DESC],
                ];
        
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status_id' => $this->status_id,
            'role_id' => $this->role_id,
            'user_type_id' => $this->user_type_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['=', 'role.role_name', $this->getAttribute( 'role.role_name')])
            ->andFilterWhere(['=', 'status.status_name', $this->getAttribute( 'status.status_name')]);

        return $dataProvider;
    }
}
