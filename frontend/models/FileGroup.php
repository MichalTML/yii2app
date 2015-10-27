<?php

namespace frontend\models;

use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "file_group".
 *
 * @property integer $id
 * @property integer $fileId
 * @property integer $groupId
 *
 * @property FileGroupName $group
 * @property ProjectAssembliesFiles $file
 */
class FileGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'file_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fileId', 'groupId'], 'required'],
            [['fileId', 'groupId'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fileId' => 'File ID',
            'groupId' => 'Group ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(FileGroupName::className(), ['groupId' => 'groupId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(ProjectAssembliesFiles::className(), ['id' => 'fileId']);
    }
    
    
    public function getStatusList($projectId, $filter = null)
    {
        if($filter == 'filter'){
            $model = FileGroupName::find()->where(['projectId' => $projectId])->select(['groupName', 'groupId'])->asArray()->all();
            $model = ArrayHelper::map( $model, 'groupId', 'groupName' );
            foreach($model as $key => $value){
                
                $filter = FileGroup::find()->where(['groupId' => $key])->one();
                if(!$filter){
                    $dropList2[$key] = $value;
                }                   
            }
            if(!isset($dropList2)){
                $dropList2 = [];
            }
            return $dropList2;      
        }elseif($filter == 'view'){
            $model = FileGroupName::find()->where(['projectId' => $projectId])->select(['groupName', 'groupId'])->asArray()->all();
            $model = ArrayHelper::map( $model, 'groupId', 'groupName' );
            foreach($model as $key => $value){
                
                $filter = FileGroup::find()->where(['groupId' => $key])->one();
                if($filter){
                    $dropList2[$key] = $value;
                }                   
            }
            if(!isset($dropList2)){
                $dropList2 = [];
            }
            return $dropList2;
        }
        $model = FileGroupName::find()->where(['projectId' => $projectId])->select(['groupName', 'groupId'])->asArray()->all();
        $dropList = ArrayHelper::map( $model, 'groupId', 'groupName' );
        if(!isset($dropList)){
                $dropList = [];
            }
        return $dropList;   
    }
    
    
    public static function getStatusListV($projectId)
    {
            $model = FileGroupName::find()->where(['projectId' => $projectId])->select(['groupName', 'groupId'])->asArray()->all();
            $model = ArrayHelper::map( $model, 'groupId', 'groupName' );
            foreach($model as $key => $value){
                
                $filter = FileGroup::find()->where(['groupId' => $key])->one();
                if($filter){
                    $dropList[$key] = $value;
                }                   
            }
            if(!isset($dropList)){
                $dropList = [];
            }
            return $dropList;
    }
}