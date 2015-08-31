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
    public function rules()
    {
        return [
            [['id', 'supplierId', 'isAccepted', 'acceptedBy'], 'integer'],
            [['name', 'connection', 'ext', 'path', 'creTime'], 'safe'],
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
        $query = Invoices::find();

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
            'supplierId' => $this->supplierId,
            'isAccepted' => $this->isAccepted,
            'acceptedBy' => $this->acceptedBy,
            'creTime' => $this->creTime,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'connection', $this->connection])
            ->andFilterWhere(['like', 'ext', $this->ext])
            ->andFilterWhere(['like', 'path', $this->path]);

        return $dataProvider;
    }
}
