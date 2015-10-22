<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "project_assemblies_files_status".
 *
 * @property integer $statusId
 * @property string $statusName
 *
 * @property ProjectAssembliesFilesData[] $projectAssembliesFilesDatas
 */
class ProjectAssembliesFilesStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_assemblies_files_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['statusName'], 'required'],
            [['statusName'], 'string', 'max' => 40]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'statusId' => 'Status ID',
            'statusName' => 'Status Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectAssembliesFilesDatas()
    {
        return $this->hasMany(ProjectAssembliesFilesData::className(), ['statusId' => 'statusId']);
    }
}
