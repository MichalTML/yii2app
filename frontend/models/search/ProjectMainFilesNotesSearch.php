<?php

namespace frontend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\ProjectMainFilesNotes;

/**
 * ProjectMainFilesNotesSearch represents the model behind the search form about `frontend\models\ProjectMainFilesNotes`.
 */
class ProjectMainFilesNotesSearch extends ProjectMainFilesNotes
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'fileId', 'note', 'typeId', 'creUserId'], 'integer'],
            [['creTime'], 'safe'],
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
        $query = ProjectMainFilesNotes::find();

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
            'fileId' => $this->fileId,
            'note' => $this->note,
            'typeId' => $this->typeId,
            'creUserId' => $this->creUserId,
            'creTime' => $this->creTime,
        ]);

        return $dataProvider;
    }
}
