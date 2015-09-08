<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "project_assemblies_data".
 *
 * @property integer $id
 * @property integer $projectId
 * @property string $name
 * @property string $path
 *
 * @property ProjectData $project
 * @property ProjectAssembliesFiles[] $projectAssembliesFiles
 * @property ProjectAssembliesMainFiles[] $projectAssembliesMainFiles
 */
class ProjectAssembliesData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_assemblies_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['projectId'], 'integer'],
            [['name', 'path'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'projectId' => 'Project ID',
            'name' => 'Name',
            'path' => 'Path',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(ProjectData::className(), ['sygnature' => 'projectId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectAssembliesFiles()
    {
        return $this->hasMany(ProjectAssembliesFiles::className(), ['assemblieId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectAssembliesMainFiles()
    {
        return $this->hasMany(ProjectAssembliesMainFiles::className(), ['assemblieId' => 'id']);
    }
}
