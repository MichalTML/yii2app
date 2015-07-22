<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\User;
use frontend\models\Profile;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\AttributeBehavior;
use frontend\models\ClientData;

/**
 * This is the model class for table "project_data".
 *
 * @property integer $id
 * @property string $projectName
 * @property integer $clientId
 * @property string $creTime
 * @property string $deadline
 * @property string $endDate
 * @property integer $creUserId
 * @property integer $updUserId
 * @property string $updTime
 * @property string $projectStatus
 * 
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
            'projectName' => 'Project Name',
            'clientData.name' => 'Client Name',
            'creTime' => 'Creation Time',
            'deadline' => 'Deadline',
            'endTime' => 'End Time',
            'creUserId' => 'Created by',
            //'user.firstlastName' => 'Created by',
            'updUserId' => 'Updated by',
            'updTime' => 'Update Time',
            'projectStatus' => 'Project Status',
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
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientId() {
        return $this->hasOne( ClientData::className(), ['clientNumber' => 'clientId' ] );
    }

    public function getClientList() {
        $droptions = ClientData::find()->asArray()->all();
        return ArrayHelper::map( $droptions, 'clientNumber', 'name' );
    }

    public function getStatusName() {
        return $this->hasOne( ProjectStatus::className(), ['statusName' => 'projectStatus' ] );
    }

    public function getStatusList() {

        $droptions = ProjectStatus::find()->asArray()->all();
        return ArrayHelper::map( $droptions, 'statusName', 'statusName' );
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
       $userFirstName = $userProfile->first_name;
       $userLastName = $userProfile->last_name;
       $userCombine = $userFirstName.' '.$userLastName;
       $constructorList[$user['id']] = $userCombine;
       
        }
        
        return $constructorList;     
    }

    public function getCreUser() {
        return $this->hasMany( User::className(), ['id' => 'creUserId' ] );
    }

    public function getCreUserName() {
        return $this->user->username;
    }

    public function getCreUserLink() {
        $url = Url::to( ['user/view', 'id' => $this->userId ] );
        $options = [ ];
        return Html::a( $this->getUserName(), $url, $options );
    }

    /**
     * get client relationship
     */
    public function getClientData() {
        return $this->hasOne( ClientData::className(), ['clientNumber' => 'clientId' ] );
    }

    /*
     * get client name
     */

    public function getClientDataName() {
        return $this->clientData ? $this->clientData->name : '- no client name -';
    }

    /**
     * get user relationshi
     */
    public function getUser() {
        return $this->hasOne( User::className(), ['id' => 'creUserId' ] );
    }

    //public function getUserfirstlastName() {
      //  return $this->user ? $this->user->firstlastName : '- no user name -';
   // }

}
