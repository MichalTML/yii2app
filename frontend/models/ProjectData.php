<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\User;
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
 * @property string $projectId
 * @property string $projectName
 * @property integer $clientId
 * @property string $creDate
 * @property string $deadline
 * @property string $endDate
 * @property integer $creUserId
 * @property integer $updUser
 * @property string $updDate
 * @property string $projectStatus
 * @property integer $constructorId
 * @property integer $contanctId
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
            [[ 'projectId', 'projectName', 'clientId', 'deadline', 'projectStatus', 'constructorId' ], 'required' ],
            [[ 'projectId' ], 'unique' ],
            [[ 'id', 'clientId' ], 'integer' ],
            [[ 'projectId' ], 'string', 'max' => 45 ],
            [[ 'projectName' ], 'string', 'max' => 100 ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [

            'id' => 'ID',
            'projectId' => 'Project ID',
            'projectName' => 'Project Name',
            'clientData.name' => 'Client Name',
            'creDate' => 'Creation Date',
            'deadline' => 'Deadline',
            'endDate' => 'End Date',
            'user.firstlastName' => 'Created by',
            'updUser' => 'Updated by',
            'updDate' => 'Update date',
            'projectStatus' => 'Project Status',
            'constructorId' => 'Project Constructors',
        ];
    }

    public function behaviors() {

        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['creDate', 'updDate' ],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updDate' ],
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
                    ActiveRecord::EVENT_BEFORE_INSERT => ['updUser' ],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updUser' ],
                ],
                'value' => function ($event) {
            return Yii::$app->user->identity->firstlastName;
        }
            ],
        ];
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

    public function getConstructorList() {
        $listoptions = User::find()->where( ['role_id' => 1 ] )->all();



        return ArrayHelper::map( $listoptions, 'firstlastName', 'firstlastName' );
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

    public function getUserfirstlastName() {
        return $this->user ? $this->user->firstlastName : '- no user name -';
    }

}
