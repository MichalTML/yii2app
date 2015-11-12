<?php

namespace frontend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "file_group_name".
 *
 * @property integer $groupId
 * @property string $groupName
 *
 * @property FileGroup[] $fileGroups
 */
class FileGroupName extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'file_group_name';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['groupName'], 'required'],
            [['groupName'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'groupId' => 'Group ID',
            'groupName' => 'Group Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFileGroups()
    {
        return $this->hasMany(FileGroup::className(), ['groupId' => 'groupId']);
    }
    
    public static function getStatusListV($projectId)
    {
            $model = FileGroupName::find()
                    ->andFilterWhere(['or', 
                            ['=', 'projectId', $projectId],
                            ['=', 'projectId', 0]
                            ])
                    ->select(['groupName', 'groupId'])
                    ->asArray()
                    ->all();
            
            $droptions = ArrayHelper::map( $model, 'groupName', 'groupName' );

            return $droptions;
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
}
