<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\User;
use frontend\models\Profile;
use frontend\models\ClientData;
use frontend\models\ProjectStatus;
use frontend\models\ProjectNotes;
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
 * @property string $sygnature 
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
class ProjectData extends \yii\db\ActiveRecord
{

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
            [[ 'projectName', 'clientId', 'deadline', 'projectStatus', 'sygnature', 'projectStart' ], 'required' ],
            [[ 'id', 'clientId'], 'integer' ],
            [[ 'id', 'sygnature' ], 'unique' ],
            [ 'projectName', 'match', 'pattern' => '/^[a-zA-Z0-9\s\|]*$/', 'message' => 'Project name can only contain letters and numbers.' ],
            [ 'sygnature', 'string', 'length' => [2, 3 ] ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [

            'id' => 'ID',
            'sygnature' => 'Porject Number',
            'clientId' => 'Client Name',
            'projectName' => 'Project Name',
            'ClientName' => 'Client',
            'creTime' => 'Created at',
            'deadline' => 'Deadline',
            'projectStart' => 'Started at',
            'endTime' => 'End Time',
            'creUser.username' => 'Created by',
            'updTime' => 'Updated at',
            'updUser.username' => 'Updated by',
            'client.name' => 'Client',
            'projectStatus' => 'Status',
            'projectStatus0.statusName' => 'Status',
            'projectPermissionsUsers' => 'Project Constructors',
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
                'value' => function ($event)
        {
            return Yii::$app->user->identity->id;
        }
            ],
            'updatestamp' => [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['updUserId' ],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updUserId' ],
                ],
                'value' => function ($event)
        {
            return Yii::$app->user->identity->id;
        }
            ],
        ];
    }

    /**
     * set project name
     */
    public function setProjectName( $sygnature, $projectName ) {
        $projectName = 'P' . $sygnature . '_' . $projectName;
        $this->projectName = $projectName;
        if ( $this->save() )
        {
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
     * @return array array that containst 'firstname lastname'
     */
    public function getConstructorList() {

        if ( $userIdList = User::find()->where( ['role_id' => 2 ] )->all() )
        {
            $constructorList = [ ];

            foreach ( $userIdList as $users => $user ) {

                $userProfile = Profile::find()->where( ['userId' => $user[ 'id' ] ] )->one();

                if ( isset( $userProfile->firstName ) && isset( $userProfile->lastName ) )
                {
                    $userFirstName = $userProfile->firstName;
                    $userLastName = $userProfile->lastName;
                    $userCombine = $userFirstName . ' ' . $userLastName;
                    $constructorList[ $user[ 'id' ] ] = $userCombine;
                } else
                {
                    $constructorList[ $user[ 'id' ] ] = $user[ 'username' ];
                }
            }
        } else
        {
            $constructorList = [ ];
        }


        return $constructorList;
    }

    /**
     * All user raltions
     * @return \yii\db\ActiveQuery
     * 
     * !!!!!!!! TODO LINK Z PROFILEM I WYWALEINIE IMIENIA I NAZWISKA
     */
    public function getCreUser() {
        return $this->hasOne( User::className(), ['id' => 'creUserId' ] );
    }

    public function getUpdUser() {
        return $this->hasOne( User::className(), ['id' => 'updUserId' ] );
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectPermissions() {
        return $this->hasMany( ProjectPermissions::className(), ['projectId' => 'id' ] );
    }
    
    public function getConstructor() {
        return $this->hasMany( Profile::className(), ['userId' => 'userId'])->viaTable('project_permissions', ['projectId' => 'id']);
    }
        
    public function getProjectPermissionsUsers() {
        $i = 1;
        if(!empty($this->projectPermissions)){        
            foreach ( $this->projectPermissions as $key ) {
                $username = Profile::find()->where( ['userId' => $key->userId ] )->one();
                if (count($username) == 1)
                {
                    $count = ArrayHelper::map( $username, 'firstName', 'lastName' );

                    $userNames[] = $i . '. ' . $username->firstName . ' ' . $username->lastName;
                    $i ++;
                }
            }

            return $userNames = implode( ' ', $userNames );

        }
            return $userNames = '-----------------------------';
        
    }
    
    public function getProjectPermissionsId() {
        if(!empty($this->projectPermissions)){        
            foreach ( $this->projectPermissions as $key ) {
                $userList[] = $key->userId;
            }
            return $userList;
        }        
    }

    /**
     * @return \yii\db\ActiveQuery
     * 
     * All client_data table related methods
     * 
     */
    
    public function getClient() {
        return $this->hasOne( ClientData::className(), ['id' => 'clientId' ] );
    }

    public function getClientList() {
        $droptions = ClientData::find()->asArray()->all();
        $droptionsArray = ArrayHelper::map( $droptions, 'id', 'name' );
        asort($droptionsArray);        
        return $droptionsArray;
    }
    
    public function getNote() {
        return $this->hasMany( ProjectNotes::className(), ['projectId' => 'id']);   
    }

    public function getProjectStatus0() {
        return $this->hasOne( ProjectStatus::className(), ['id' => 'projectStatus' ] );
    }
    
    public function getProjectStatus0Name() {
        return $this->projectStatus0->statusName;
    }

    public static function callClientData( $data ) {
        $clientData = new ClientData;
        $client = $clientData->find()->where( ['id' => $data ] )->one();
        return '<b>Phone:</b><span  style="padding-right: 20px;">' . $client->phone .
                '</span><b>Email:</b> ' . '<a href="mailto:' . $client->email . '"><span  style="padding-right: 20px;">' . $client->email . ' </span></a><b>Website:</b> ' . '<a href="' . $client->www . '"><span  style="padding-right: 20px;">' . $client->www . ' </span></a>';
        
    }

    public static function getClientName( $data ) {
        $clientData = new ClientData;
        $clientName = $clientData->find()->where( ['id' => $data ] )->one();
        return $clientName->abr;

    }
    
    public static function getSygnatures(){
        $sygnatures = ProjectData::find()->select('sygnature')->asArray()->all();
        foreach($sygnatures as $syg){
            foreach($syg as $sygId)
            {
                $sygnaturesList[$sygId] = $sygId;
            }            
        }
        return $sygnaturesList;
    }
    
    public static function getProjectStatusList(){
        $projectStatus = ProjectStatus::find()->asArray()->all();
        $projectStatusList = ArrayHelper::map($projectStatus, 'statusName', 'statusName');
        return $projectStatusList;
    }
   
    public static function getCreUserList(){
        $users = ProjectData::find()->select('creUserId')->asArray()->all();
        foreach ($users as $data ){
            foreach ($data as $userId){
                $userName = User::find()->where(['id' => $userId])->one();
                if($userName){
                    $usersNameList[$userName->username] = $userName->username;
                }
            }
        }
        return $usersNameList;
    }
    
    public static function getElemenetsList($sygnature, $priority = null){

        switch ( $priority) {
            case ('low'):
                $resultList = ProjectAssembliesFiles::find()->where(['projectId' => $sygnature, 'ext' => 'dft', 'priorityId' => '0', 'statusId' => '1'])->all();
                $resultListFinished = ProjectAssembliesFiles::find()->where(['projectId' => $sygnature, 'ext' => 'dft', 'priorityId' => '0', 'statusId' => '2'])->all();
                $resultListCount = count($resultList);
                $resultListFinishedCount = count($resultListFinished);
                $result = $resultListCount;
                $result.= ' | ' . $resultListFinishedCount;
                return $result;  
            case ('normal'):
                $resultList = ProjectAssembliesFiles::find()->where(['projectId' => $sygnature, 'ext' => 'dft', 'priorityId' => '1', 'statusId' => '1'])->all();
                $resultListFinished = ProjectAssembliesFiles::find()->where(['projectId' => $sygnature, 'ext' => 'dft', 'priorityId' => '1', 'statusId' => '2'])->all();
                $resultListCount = count($resultList);
                $resultListFinishedCount = count($resultListFinished);
                $result = $resultListCount;
                $result.= ' | ' . $resultListFinishedCount;
                return $result;     
            case ('high'):
                $resultList = ProjectAssembliesFiles::find()->where(['projectId' => $sygnature, 'ext' => 'dft', 'priorityId' => '2', 'statusId' => '1'])->all();
                $resultListFinished = ProjectAssembliesFiles::find()->where(['projectId' => $sygnature, 'ext' => 'dft', 'priorityId' => '2', 'statusId' => '2'])->all();
                $resultListCount = count($resultList);
                $resultListFinishedCount = count($resultListFinished);
                $result = $resultListCount;
                $result.= ' | ' . $resultListFinishedCount;
                return $result;     
            default:
                $resultList = ProjectAssembliesFiles::find()->where(['projectId' => $sygnature, 'ext' => 'dft', 'statusId' => '1'])->all();
                $resultListFinished = ProjectAssembliesFiles::find()->where(['projectId' => $sygnature, 'ext' => 'dft', 'statusId' => '2'])->all();
                $resultListCount = count($resultList);
                $resultListFinishedCount = count($resultListFinished);
                $result = $resultListCount;
                $result.= ' | ' . $resultListFinishedCount;
                return $result;  
        }          
        
    }

}
