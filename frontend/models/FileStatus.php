<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "file_status".
 *
 * @property integer $id
 * @property string $statusName
 *
 * @property ProjectAssembliesFiles[] $projectAssembliesFiles
 */
class FileStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'file_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['statusName'], 'required'],
            [['statusName'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'statusName' => 'Status Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectAssembliesFiles()
    {
        return $this->hasMany(ProjectAssembliesFiles::className(), ['statusId' => 'id']);
    }
}
