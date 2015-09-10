<?php

namespace frontend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\ProjectAssembliesFiles;

/**
 * ProjectAssembliesFilesSearch represents the model behind the search form about `frontend\models\ProjectAssembliesFiles`.
 */
class ProjectAssembliesFilesSearch extends ProjectAssembliesFiles
{
    /**
     * @inheritdoc
     */
    public function attributes() {
        return array_merge(parent::attributes(), ['priority.name', 'type.name', 'assemblie.name', 'status.statusName']);
    }
    
    public function rules()
    {
        return [
            [['priority.name', 'type.name', 'assemblie.name', 'sygnature', 'name', 'path', 'size', 'ext', 'material', 'feedback', 'createdAt', 'updatedAt', 'status.statusName'], 'safe'],
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
        $query = ProjectAssembliesFiles::find()
                ->andFilterWhere( ['project_assemblies_files.projectId' => $sygnature]);
        
        $query->joinWith(['priority', 'type', 'assemblie', 'status']);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $dataProvider->sort->attributes['priority.name'] =
                [
                    'asc' => ['file_priority.name' => SORT_ASC],
                    'desc' => ['file_priority.name' => SORT_DESC],
                ];
        
         $dataProvider->sort->attributes['type.name'] =
                [
                    'asc' => ['project_assemblies_files_types.name' => SORT_ASC],
                    'desc' => ['project_assemblies_files_types.name' => SORT_DESC],
                ];
         
        $dataProvider->sort->attributes['assemblie.name'] =
                [
                    'asc' => ['project_assemblies_data.name' => SORT_ASC],
                    'desc' => ['project_assemblies_data.name' => SORT_DESC],
                ];
        
         $dataProvider->sort->attributes['status.statusName'] =
                [
                    'asc' => ['file_status.statusName' => SORT_ASC],
                    'desc' => ['file_status.statusName' => SORT_DESC],
                ];
        
         
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'projectId' => $this->projectId,
            'assemblieId' => $this->assemblieId,
            'typeId' => $this->typeId,
            'flag' => $this->flag,
            'thickness' => $this->thickness,
            'quanity' => $this->quanity,
            'quanityDone' => $this->quanityDone,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ]);

        $query->andFilterWhere(['like', 'sygnature', $this->sygnature])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'path', $this->path])
            ->andFilterWhere(['like', 'size', $this->size])
            ->andFilterWhere(['like', 'ext', $this->ext])
            ->andFilterWhere(['like', 'material', $this->material])
            ->andFilterWhere(['like', 'feedback', $this->feedback])
            ->andFilterWhere(['=', 'project_assemblies_data.name', $this->getAttribute('assemblie.name')])
            ->andFilterWhere(['=', 'file_status.statusName', $this->getAttribute('status.statusName')])
            ->andFilterWhere(['=', 'file_priority.name', $this->getAttribute('priority.name')])
            ->andFilterWhere(['=', 'project_assemblies_files_types.name', $this->getAttribute('type.name')]);

        return $dataProvider;
    }
}