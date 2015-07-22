<?php

namespace frontend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\ProjectData;

/**
 * ProjectSearch represents the model behind the search form about `frontend\models\ProjectData`.
 */
class ProjectSearch extends ProjectData
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'clientId', 'creUserId', 'updUserId'], 'integer'],
            [['projectName', 'creTime', 'deadline', 'endTime', 'updTime'], 'safe'],
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
        $query = ProjectData::find();

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
            'clientId' => $this->clientId,
            'creTime' => $this->creTime,
            'clientData.name' => $this->clientId,
            'deadline' => $this->deadline,
            'endTime' => $this->endTime,
            'creUserId' => $this->creUserId,
            'updUserId' => $this->updUserId,
            'updTime' => $this->updTime,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'projectName', $this->projectName]);

        return $dataProvider;
    }
}
