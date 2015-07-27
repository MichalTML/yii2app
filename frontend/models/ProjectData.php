<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\User;
use frontend\models\Profile;
use frontend\models\ClientData;
use frontend\models\ProjectStatus;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\AttributeBehavior;


/**
 * This is the model class for table "project_data".
 *
 * @property integer $id
 * @property string $projectName
 * @property integer $clientId
 * @property string $deadline
 * @property integer $projectStatus
 * @property string $creTime
 * @property integer $creUserId
 * @property string $updTime
 * @property integer $updUserId
 * @property string $endTime
 *
 * @property ProjectStatus $projectStatus0
 * @property ClientData $client
 * @property User $creUser
 * @property User $updUser
 * @property ProjectPermissions[] $projectPermissions
 */
class ProjectData extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'project_data';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [[ 'projectName', 'clientId', 'deadline', 'projectStatus' ], 'required' ],
            [[ 'id', 'clientId' ], 'integer' ],
            [[ 'projectName' ], 'string', 'max' => 100 ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [

            'id' => 'ID',
            'clientId' => 'Client Name',
            'projectName' => 'Project Name',
            'ClientName' => 'Client',
            'creTime' => 'Creation Time',
            'deadline' => 'Deadline',
            'endTime' => 'End Time',
            'updUserName' => 'Updated by',
            'creUserName' => 'Created by',
            'updTime' => 'Update Time',
            'projectStatus0Name' => 'Status',
            'constructorNames' => 'Project Constructors',
        ];
    }

    public function behaviors() {

        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['creTime', 'updTime' ],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updTime' ],
                ],
                'value' => new Expression( 'NOW()' ),
            ],
            'createstamp' => [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['creUserId' ],                    
                ],
                'value' => function ($event) {
            return Yii::$app->user->identity->id;
        }
            ],
            'updatestamp' => [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['updUserId'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updUserId'],
                ],
                'value' => function ($event) {
            return Yii::$app->user->identity->id;
        }
            ],
        ];
    }
    /**
     * set project name
     */
    public function setProjectName($id, $projectName) {
        $projectName = 'P'.$id.'_'.$projectName;
        $this->projectName = $projectName;
        if($this->save()){
            return true;
        }
        
        return false;
    }
    
    public function getStatusList() {

        $droptions = ProjectStatus::find()->asArray()->all();
        return ArrayHelper::map( $droptions, 'id', 'statusName' );
    }

    /**
     * get constructor first and last name
     * from the profile
     *@return array array that containst 'firstname lastname'
     */
    public function getConstructorList() {
        
       $userIdList = User::find()->where( ['role_id' => 1])->all();
       $constructorList = [ ];
        
       foreach($userIdList as $users => $user){
       
       $userProfile = Profile::find()->where(['user_id' => $user['id']])->one();
//       var_dump($userProfile->first_name);
//       die();
       $userFirstName = $userProfile->first_name;
       $userLastName = $userProfile->last_name;
       $userCombine = $userFirstName.' '.$userLastName;
       $constructorList[$user['id']] = $userCombine;
       
        }
        
        return $constructorList;     
    }

    /**
     * All user raltions
     * @return \yii\db\ActiveQuery
     * 
     * !!!!!!!! TODO LINK Z PROFILEM I WYWALEINIE IMIENIA I NAZWISKA
     */
    public function getCreUser()
    {
        return $this->hasOne(User::className(), ['id' => 'creUserId']);
    }
  
    public function getUpdUser()
    {
        return $this->hasOne(User::className(), ['id' => 'updUserId']);
    }
    

    public function getCreUserName()
    {
        return $this->creUser ? $this->creUser->username : ' - no user name -';
    }
    
    public function getUpdUserName()
    {
        return $this->updUser ? $this->updUser->username : ' - no user name -';
    }
    
    
     /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectPermissions()
    {
        return $this->hasMany(ProjectPermissions::className(), ['projectId' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     * 
     * All client_data table related methods
     * 
     */
    public function getClient()
    {
        return $this->hasOne(ClientData::className(), ['id' => 'clientId']);
    }
    
     
    public function getClientName()
    {
        return $this->client ? $this->client->name : '- no client name -';
    }
    
    public function getClientList() {
        $droptions = ClientData::find()->asArray()->all();
        return ArrayHelper::map( $droptions, 'id', 'name' );
    }

     /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectStatus0()
    {
        return $this->hasOne(ProjectStatus::className(), ['id' => 'projectStatus']);
    }
    
    public function getProjectStatus0Name()
    {
        return $this->projectStatus0->statusName;
    }

}
