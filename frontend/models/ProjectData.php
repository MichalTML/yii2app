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
 * @property integer $updUserId
 * @property string $updDate
 * @property string $projectStatus
 *
 * @property User $creUser
 */
class ProjectData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['projectId', 'projectName', 'clientId', 'deadline', 'projectStatus'], 'required'],
            [['projectId'], 'unique'],
            [['id', 'clientId', 'creUserId', 'updUserId'], 'integer'],
            [['projectId'], 'string', 'max' => 45],
            [['projectName'], 'string', 'max' => 100]
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
            'projectName' => 'Project Name',
            'clientId' => 'Client Name',
            'creDate' => 'Creation Date',
            'deadline' => 'Deadline',
            'endDate' => 'End Date',
            'creUserId' => 'Created by',
            'updUserId' => 'Updated by',
            'updDate' => 'Update date',
            'projectStatus' => 'Project Status',
        ];
    }
    
    public function behaviors() {
                
        return [            
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                ActiveRecord::EVENT_BEFORE_INSERT => ['creDate', 'updDate'],
                ActiveRecord::EVENT_BEFORE_UPDATE => ['updDate'],
                ],
                'value' => new Expression( 'NOW()'),
            ],
            'userstamp' => [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                ActiveRecord::EVENT_BEFORE_INSERT => ['creUserId', 'updUserId'],
                ActiveRecord::EVENT_BEFORE_UPDATE => ['updUserId'],
                ],
                'value' => function ($event) {
                   return Yii::$app->user->identity->id;
                }
            ],
               
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreUser()
    {
        return $this->hasMany(User::className(), ['id' => 'creUserId']);
    }
    
    public function getCreUserName()
    {
        return $this->user->username;
    }
    
    public function getCreUserLink()
    {
        $url = Url::to(['user/view', 'id'=>$this->userId]);
        $options = [];
        return Html::a($this->getUserName(), $url, $options);
    }
    
    public function getStatusList()
    {
        return $statusList = ['Active' => 'Active','Pending' => 'Pending','Complete' => 'Complete'];
    }
    
    public function getClientList()
    {
        return $clientList = ['a', 'b', 'c'];
        // link to client list table
    }
}
