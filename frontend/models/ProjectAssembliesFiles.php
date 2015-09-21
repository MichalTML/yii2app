<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "project_assemblies_files".
 *
 * @property integer $id
 * @property integer $projectId
 * @property integer $assemblieId
 * @property integer $typeId
 * @property string $sygnature
 * @property string $name
 * @property string $path
 * @property string $size
 * @property string $ext
 * @property integer $flag
 * @property integer $thickness
 * @property integer $quanity
 * @property string $material
 * @property integer $quanityDone
 * @property string $status
 * @property string $priority
 * @property string $feedback
 * @property string $createdAt
 * @property string $updatedAt
 *
 * @property ProjectAssembliesData $assemblie
 * @property ProjectAssembliesFilesTypes $type
 * @property ProjectData $project
 */
class ProjectAssembliesFiles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_assemblies_files';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['projectId', 'assemblieId', 'typeId', 'flag', 'thickness', 'quanity', 'quanityDone'], 'integer'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['sygnature'], 'string', 'max' => 8],
            [['name', 'path', 'feedback'], 'string', 'max' => 255],
            [['size'], 'string', 'max' => 11],
            [['ext'], 'string', 'max' => 5],
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
            'typeId' => 'Type ID',
            'sygnature' => 'Sygnature',
            'name' => 'Name',
            'path' => 'Path',
            'size' => 'Size',
            'ext' => 'Ext',
            'flag' => 'Flag',
            'thickness' => 'Thickness',
            'quanity' => 'Quanity',
            'material' => 'Material',
            'quanityDone' => 'Quanity Done',
            'statusId' => 'Status',
            'priorityId' => 'Priority',
            'feedback' => 'Feedback',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssemblie()
    {
        return $this->hasOne(ProjectAssembliesData::className(), ['id' => 'assemblieId']);
    }
    
    public function getAssemblieName()
    {
        return $this->assemblie->name;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(ProjectAssembliesFilesTypes::className(), ['id' => 'typeId']);
    }
    
    public function getTypeName()
    {
        return $this->type->name;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(ProjectData::className(), ['sygnature' => 'projectId']);
    }
    
    public function getStatus()
    {
       return $this->hasOne(FileStatus::className(), ['id' => 'statusId']);
    }
    
    public function getStatusName()
    {
        return $this->status->statusName;
    }
    
    public function getPriority()
    {
        return $this->hasOne(  FilePriority::className(), ['id' => 'priorityId']);
    }
    
    public function getPriorityName()
    {
        return $this->priority->name;
    }
}
