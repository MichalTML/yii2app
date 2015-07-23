<?php

namespace frontend\models;

use Yii;

use frontend\models\ProjectData;

/**
 * This is the model class for table "project_status".
 *
 * @property integer $id
 * @property string $status_name
 */
class ProjectStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['statusName'], 'required'],
            [['statusName'], 'string', 'max' => 45],
            [['statusName'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'statusName' => 'Status Name',
        ];
    }
    
    /**
     * get Project data relation
     */

    public function getProjectDatas()
    {
        return $this->hasMany(ProjectData::className(), ['projectStatus' => 'id']);
    }
}
