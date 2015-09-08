<?php

namespace frontend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\ProjectAssembliesData;

/**
 * ProjectAssembliesDataSearch represents the model behind the search form about `frontend\models\ProjectAssembliesData`.
 */
class ProjectAssembliesDataSearch extends ProjectAssembliesData
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'projectId'], 'integer'],
            [['name', 'path'], 'safe'],
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
    public function search($params, $sygnature)
    {
        $query = ProjectAssembliesData::find()
                ->andFilterWhere( ['projectId' => $sygnature]);

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
            'projectId' => $this->projectId,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'path', $this->path]);

        return $dataProvider;
    }
}
