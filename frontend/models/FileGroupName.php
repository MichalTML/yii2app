<?php

namespace frontend\models;

use Yii;

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
}
