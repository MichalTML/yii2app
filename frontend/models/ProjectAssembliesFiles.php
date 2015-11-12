<?php

namespace frontend\models;

use frontend\models\ProjectAssembliesFilesData;
use frontend\models\ProjectAssembliesFilesStatus;
use frontend\models\FileGroupName;

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
            [['projectId', 'assemblieId', 'typeId', 'flag', 'quanity', 'quanityDone'], 'integer'],
            //[['thickness'], 'float'],
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
       return $this->hasOne(  ProjectAssembliesFilesStatus::className(), ['statusId' => 'statusId']);
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
    
    public function getDestination()
    {
        return $this->hasOne(FileDestination::className(), ['id' => 'destinationId']);
    }
    
    public static function getFile($sygnature, $name, $ext){
        $filesData = new ProjectAssembliesFiles;
        $result = $filesData->find()
                        ->andFilterWhere(['sygnature' => $sygnature])
                        ->andFilterWhere(['name' => $name])
                        ->andFilterWhere(['ext' => $ext])
                        ->one();
        if($result){
            return $result->path;
        }
        return false;
    }
    
    public function getProgramming(){
        return $this->hasMany(ProjectAssembliesFilesData::classname(), ['fileId' => 'id'])->from(['programming' => ProjectAssembliesFilesData::tableName()]);   
    }
    
    public function getCnc(){
        return $this->hasMany(ProjectAssembliesFilesData::classname(), ['fileId' => 'id'])->from(['cnc' => ProjectAssembliesFilesData::tableName()]);    
    }
    
    public function getCt(){
        return $this->hasMany(ProjectAssembliesFilesData::classname(), ['fileId' => 'id'])->from(['ct' => ProjectAssembliesFilesData::tableName()]);   
    }
    
    public function getAnod(){
        return $this->hasMany(ProjectAssembliesFilesData::classname(), ['fileId' => 'id'])->from(['anod' => ProjectAssembliesFilesData::tableName()]);    
    }
    
    public function getFileStatus($id, $statusId){
        $model = ProjectAssembliesFilesData::find()
                ->andWhere(['fileId' => $id])
                ->andWhere(['statusId' => $statusId])
                ->select(['timeStamp'])
                ->one();
        if($model){
            $statusName = ProjectAssembliesFilesStatus::find()
                    ->where(['statusId' => $statusId])
                    ->select(['statusName'])
                    ->one();
            return $statusName->statusName;
        }
          
    }
    
    public function getFilegroup()
    {
        return $this->hasOne(FileGroupName::className(), ['groupId' => 'groupId']);
    }
    
}
