<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "project_main_files".
 *
 * @property integer $id
 * @property integer $projectId
 * @property string $ext
 * @property string $size
 * @property string $createdAt
 * @property string $updatedAt
 * @property string $path
 * @property string $name
 *
 * @property ProjectData $project
 */
class ProjectMainFiles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_main_files';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['projectId'], 'required'],
            [['projectId'], 'integer'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['ext'], 'string', 'max' => 4],
            [['size'], 'string', 'max' => 10],
            [['path', 'name'], 'string', 'max' => 255]
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
            'ext' => 'Ext',
            'size' => 'Size',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
            'path' => 'Path',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(ProjectData::className(), ['sygnature' => 'projectId']);
    }
}
