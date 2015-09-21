<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "project_files_notes_type".
 *
 * @property integer $id
 * @property string $type
 *
 * @property ProjectAssembliesFilesNotes[] $projectAssembliesFilesNotes
 * @property ProjectAssembliesMainFilesNotes[] $projectAssembliesMainFilesNotes
 * @property ProjectMainFilesNotes[] $projectMainFilesNotes
 */
class ProjectFilesNotesType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_files_notes_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type'], 'required'],
            [['id'], 'integer'],
            [['type'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectAssembliesFilesNotes()
    {
        return $this->hasMany(ProjectAssembliesFilesNotes::className(), ['typeId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectAssembliesMainFilesNotes()
    {
        return $this->hasMany(ProjectAssembliesMainFilesNotes::className(), ['typeId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectMainFilesNotes()
    {
        return $this->hasMany(ProjectMainFilesNotes::className(), ['typeId' => 'id']);
    }
}
