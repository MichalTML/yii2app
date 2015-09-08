<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "project_assemblies_main_files".
 *
 * @property integer $id
 * @property integer $projectId
 * @property integer $assemblieId
 * @property string $sygnature
 * @property string $path
 * @property string $size
 * @property string $createdAt
 * @property string $updatedAt
 * @property string $ext
 * @property string $name
 *
 * @property ProjectAssembliesData $assemblie
 * @property ProjectData $project
 */
class ProjectAssembliesMainFiles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_assemblies_main_files';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['projectId', 'assemblieId'], 'integer'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['name'], 'required'],
            [['sygnature'], 'string', 'max' => 8],
            [['path', 'name'], 'string', 'max' => 255],
            [['size'], 'string', 'max' => 45],
            [['ext'], 'string', 'max' => 5]
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
            'assemblieId' => 'Assemblie ID',
            'sygnature' => 'Sygnature',
            'path' => 'Path',
            'size' => 'Size',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
            'ext' => 'Ext',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssemblie()
    {
        return $this->hasOne(ProjectAssembliesData::className(), ['id' => 'assemblieId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(ProjectData::className(), ['sygnature' => 'projectId']);
    }
}
