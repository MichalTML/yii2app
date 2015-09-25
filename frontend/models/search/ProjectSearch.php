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
    
    public function attributes() {
        return array_merge(parent::attributes(), ['projectStatus0.statusName', 'client.name', 'creUser.username', 'ProjectName']);
    }
    public function rules()
    {
        return [
            [['projectStart', 'projectName', 'creTime', 'deadline', 'endTime', 'sygnature', 'updTime', 'projectStatus0.statusName', 'client.name', 'ProjectName','creUser.username'], 'safe'],
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
        
        $query->joinWith(['projectStatus0', 'client', 'creUser']);
                
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $dataProvider->sort->attributes['projectStatus0.statusName'] =
                [
                    'asc' => ['project_status.statusName' => SORT_ASC],
                    'desc' => ['project_status.statusName' => SORT_DESC],
                ];
        $dataProvider->sort->attributes['client.name'] =
                [
                    'asc' => ['client_data.name' => SORT_ASC],
                    'desc' => ['client_data.name' => SORT_DESC],
                ];
        $dataProvider->sort->attributes['creUser.username'] =
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

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'deadline', $this->deadline])
            ->andFilterWhere(['like', 'projectStart', $this->projectStart])
            ->andFilterWhere(['like', 'sygnature', $this->sygnature])
            ->andFilterWhere(['like', 'projectName', $this->projectName])
            ->andFilterWhere(['like', 'project_data.creTime', $this->creTime])
            ->andFilterWhere(['like', 'project_status.statusName', $this->getAttribute('projectStatus0.statusName')])
            ->andFilterWhere(['like', 'client_data.name', $this->getAttribute('client.name')])
            ->andFilterWhere(['like', 'user.username', $this->getAttribute('creUser.username')]);
        return $dataProvider;
    }
}
