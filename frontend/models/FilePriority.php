<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "file_priority".
 *
 * @property integer $id
 * @property string $name
 *
 * @property ProjectAssembliesFiles[] $projectAssembliesFiles
 */
class FilePriority extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'file_priority';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectAssembliesFiles()
    {
        return $this->hasMany(ProjectAssembliesFiles::className(), ['priorityId' => 'id']);
    }
}
