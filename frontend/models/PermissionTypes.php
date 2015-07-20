<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "permission_types".
 *
 * @property integer $id
 * @property integer $permissionType
 */
class PermissionTypes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'permission_types';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'permissionType'], 'required'],
            [['id', 'permissionType'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'permissionType' => 'Permission Type',
        ];
    }
}
