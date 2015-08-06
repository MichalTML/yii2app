<?php

namespace frontend\models;

use Yii;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "project_permissions".
 *
 * @property integer $id
 * @property integer $projectId
 * @property integer $userId
 * @property integer $create
 * @property integer $edit
 * @property integer $view
 * @property integer $delete
 * @property string $creTime
 * 
 * @property User $user 
 * @property ProjectData $project 
 */
class ProjectPermissions extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_permissions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['projectId', 'userId'], 'required'],
            [['id', 'projectId', 'userId', 'create', 'edit', 'view', 'delete'], 'integer'],
            [['creTime'], 'safe']
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
            'userId' => 'Constructors',
            'create' => 'Create',
            'edit' => 'Edit',
            'view' => 'View',
            'delete' => 'Delete',
            'creTime' => 'Cre Time',
        ];
    }
    
    /**
     * Checking if the permission is already granted if yes then returning false
     * @param int $userId
     * @param int $projectId
     */
    public function checkPermissionsExists($userId, $projectId)
    {
        $matchList = $this->find()->andWhere('userId = :userId',[':userId' => $userId])
                              ->andWhere('projectId = :project_id', [':project_id' => $projectId])
                              ->all();
        if($matchList) {
            
            return false;
            
        }
        
        return true;                            
                
    }
    
    /**
     * get user ralation
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }

    /**
     * get project relation
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(ProjectData::className(), ['id' => 'projectId']);
    }
}
