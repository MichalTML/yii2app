<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "project_assemblies_files_notes_labels".
 *
 * @property integer $labelId
 * @property string $labelName
 *
 * @property ProjectAssembliesFilesNotes[] $projectAssembliesFilesNotes
 */
class ProjectAssembliesFilesNotesLabels extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_assemblies_files_notes_labels';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['labelName'], 'required'],
            [['labelName'], 'string', 'max' => 255],
            [['labelName'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'labelId' => 'Label ID',
            'labelName' => 'Label Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectAssembliesFilesNotes()
    {
        return $this->hasMany(ProjectAssembliesFilesNotes::className(), ['label' => 'labelId']);
    }
}
