<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "project_permissions".
 *
 * @property integer $id
 * @property integer $projectId
 * @property integer $userId
 * @property integer $permissionName
 */
class projectPermissions extends \yii\db\ActiveRecord
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
            [['id', 'projectId', 'userId', 'permissionName'], 'required'],
            [['id', 'projectId', 'userId'], 'integer']
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
            'userId' => 'User ID',
            'permissionName' => 'Permission Name',
        ];
    }
}
