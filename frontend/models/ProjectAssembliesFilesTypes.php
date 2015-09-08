<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "project_assemblies_files_types".
 *
 * @property integer $id
 * @property string $name
 *
 * @property ProjectAssembliesFiles[] $projectAssembliesFiles
 */
class ProjectAssembliesFilesTypes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_assemblies_files_types';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
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
        return $this->hasMany(ProjectAssembliesFiles::className(), ['typeId' => 'id']);
    }
}
