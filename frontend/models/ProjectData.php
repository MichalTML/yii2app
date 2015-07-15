<?php

namespace app\models;

use Yii;

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
            [['id', 'projectId', 'clientId', 'deadline', 'creUserId', 'updUserId'], 'required'],
            [['id', 'clientId', 'creUserId', 'updUserId'], 'integer'],
            [['creDate', 'deadline', 'endDate', 'updDate'], 'safe'],
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
            'clientId' => 'Client ID',
            'creDate' => 'Cre Date',
            'deadline' => 'Deadline',
            'endDate' => 'End Date',
            'creUserId' => 'Cre User ID',
            'updUserId' => 'Upd User ID',
            'updDate' => 'Upd Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreUser()
    {
        return $this->hasOne(User::className(), ['id' => 'creUserId']);
    }
}
