<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "project_file_data".
 *
 * @property integer $projectId
 * @property string $path
 * @property string $root
 * @property integer $files
 * @property string $createdAt
 * @property integer $assembliesMainFiles
 * @property integer $projectMainFiles
 * @property integer $assembliesFiles
 *
 * @property ProjectData $project
 */
class ProjectFileData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_file_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['projectId', 'assembliesMainFiles', 'projectMainFiles', 'assembliesFiles'], 'required'],
            [['projectId', 'files', 'assembliesMainFiles', 'projectMainFiles', 'assembliesFiles'], 'integer'],
            [['createdAt'], 'safe'],
            [['path', 'root'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'projectId' => 'Project ID',
            'path' => 'Path',
            'root' => 'Root',
            'files' => 'Files',
            'createdAt' => 'Created At',
            'assembliesMainFiles' => 'Assemblies Main Files',
            'projectMainFiles' => 'Project Main Files',
            'assembliesFiles' => 'Assemblies Files',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(ProjectData::className(), ['sygnature' => 'projectId']);
    }
}
