<?php

namespace frontend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Invoices;

/**
 * InvoicesSearch represents the model behind the search form about `frontend\models\Invoices`.
 */
class InvoicesSearch extends Invoices
{
    /**
     * @inheritdoc
     */
    public function attributes() {
        return array_merge(parent::attributes(), ['user.username']);
    }
    public function rules()
    {
        return [
            [['name', 'connection', 'ext', 'path', 'creTime', 'acceptedAt', 'user.username', 'supplierId', 'signedBy'], 'safe'],
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
        $query = Invoices::find()->where( 
            'isAccepted != :id', ['id'=>1]
            );
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $query->joinWith(['user']);
        
        $dataProvider->sort->attributes['user.username'] =
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

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'connection', $this->connection])
            ->andFilterWhere(['like', 'ext', $this->ext])
            ->andFilterWhere(['like', 'path', $this->path])
            ->andFilterWhere(['like', 'acceptedAt', $this->acceptedAt])
            ->andFilterWhere(['like', 'creTime', $this->creTime])
            ->andFilterWhere(['like', 'supplierId', $this->supplierId])
             ->andFilterWhere(['like', 'signedBy', $this->signedBy])
            ->andFilterWhere(['like', 'user.username', $this->getAttribute('user.username')]);

        return $dataProvider;
    }
    
     public function searchAccepted($params)
    {
        $query = Invoices::find()->where( 
            'isAccepted != :id', ['id'=>0]
            );
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $query->joinWith(['user']);
        
        $dataProvider->sort->attributes['user.username'] =
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

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'connection', $this->connection])
            ->andFilterWhere(['like', 'ext', $this->ext])
            ->andFilterWhere(['like', 'path', $this->path])
            ->andFilterWhere(['like', 'acceptedAt', $this->acceptedAt])
            ->andFilterWhere(['like', 'creTime', $this->creTime])
            ->andFilterWhere(['like', 'supplierId', $this->supplierId])
            ->andFilterWhere(['like', 'signedBy', $this->signedBy])
            ->andFilterWhere(['like', 'user.username', $this->getAttribute('user.username')]);

        return $dataProvider;
    }
}
