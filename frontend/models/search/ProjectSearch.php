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
        return array_merge(parent::attributes(), ['projectStatus0.statusName', 'client.abr', 'updUser.username', 'ProjectName']);
    }
    public function rules()
    {
        return [
            [['projectStart', 'projectName', 'creTime', 'deadline', 'endTime', 'sygnature', 'updTime', 'projectStatus0.statusName', 'client.abr', 'ProjectName','updUser.username'], 'safe'],
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
    public function search($params, $order = null, $filter = null)
    {        
        $query = ProjectData::find();
        
        if($filter == 'active'){
            $query->andFilterWhere(['or',
                ['projectStatus' => '1'],
                ['projectStatus' => '3']
                ]);
        } elseif (is_array($filter)){
            foreach($filter as $sygnature){
                $query->orFilterWhere(['sygnature' => $sygnature]);
            }
        } elseif($filter == 'completed'){
            $query->andFilterWhere(['projectStatus' => '2']);
        }
         
        $query->joinWith(['projectStatus0', 'client', 'updUser']);
        if($order){        
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'sort' => $order,
            ]);
        } else {
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
            ]);
           
        }
        
        $dataProvider->sort->attributes['projectStatus0.statusName'] =
                [
                    'asc' => ['project_status.statusName' => SORT_ASC],
                    'desc' => ['project_status.statusName' => SORT_DESC],
                ];
        $dataProvider->sort->attributes['client.abr'] =
                [
                    'asc' => ['client_data.abr' => SORT_ASC],
                    'desc' => ['client_data.abr' => SORT_DESC],
                ];
        $dataProvider->sort->attributes['updUser.username'] =
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
            ->andFilterWhere(['=', 'project_status.statusName', $this->getAttribute('projectStatus0.statusName')])
            ->andFilterWhere(['like', 'client_data.abr', $this->getAttribute('client.abr')])
            ->andFilterWhere(['=', 'user.username', $this->getAttribute('updUser.username')]);
        return $dataProvider;
    }
}
