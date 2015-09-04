<?php

namespace frontend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\ProjectMainFiles;

/**
 * ProjectMainFilesSearch represents the model behind the search form about `frontend\models\ProjectMainFiles`.
 */
class ProjectMainFilesSearch extends ProjectMainFiles
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'projectId'], 'integer'],
            [['ext', 'size', 'createdAt', 'updatedAt', 'path', 'name'], 'safe'],
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
        $query = ProjectMainFiles::find();

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
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ]);

        $query->andFilterWhere(['like', 'ext', $this->ext])
            ->andFilterWhere(['like', 'size', $this->size])
            ->andFilterWhere(['like', 'path', $this->path])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
