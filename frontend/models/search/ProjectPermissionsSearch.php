<?php

namespace frontend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\ProjectPermissions;

/**
 * ProjectPermissionsSearch represents the model behind the search form about `frontend\models\ProjectPermissions`.
 */
class ProjectPermissionsSearch extends ProjectPermissions
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'userId', 'create', 'edit', 'view', 'delete'], 'integer'],
            [['projectId', 'creTime'], 'safe'],
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
        $query = ProjectPermissions::find();

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
            'userId' => $this->userId,
            'create' => $this->create,
            'edit' => $this->edit,
            'view' => $this->view,
            'delete' => $this->delete,
            'creTime' => $this->creTime,
        ]);

        $query->andFilterWhere(['like', 'projectId', $this->projectId]);

        return $dataProvider;
    }
}
