<?php

namespace frontend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\ProjectAssembliesFilesNotes;

/**
 * ProjectAssembliesFilesNotesSearch represents the model behind the search form about `frontend\models\ProjectAssembliesFilesNotes`.
 */
class ProjectAssembliesFilesNotesSearch extends ProjectAssembliesFilesNotes
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'fileId', 'typeId', 'creUserId'], 'integer'],
            [['note', 'creTime'], 'safe'],
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
    public function search($params, $filter = null, $order = null)
    {
        $query = ProjectAssembliesFilesNotes::find();
        
        if($filter == 'constructor'){
            $query = ProjectAssembliesFilesNotes::find()
                    ->andFilterWhere(['or',
                        ['typeId' => 3],
                        ['typeId' => 0],
                            ]);
                    
        }
        
        if($filter == 'privnote'){
            $query = ProjectAssembliesFilesNotes::find()
                    ->where(['typeId' => 2, 'creUserId' => yii::$app->user->id]);           
        }
        
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
        
        
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'fileId' => $this->fileId,
            'typeId' => $this->typeId,
            'creUserId' => $this->creUserId,
            'creTime' => $this->creTime,
        ]);

        $query->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
