<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "file_destination".
 *
 * @property integer $id
 * @property string $destination
 *
 * @property ProjectAssembliesFiles[] $projectAssembliesFiles
 */
class FileDestination extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'file_destination';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['destination'], 'required'],
            [['destination'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'destination' => 'Destination',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectAssembliesFiles()
    {
        return $this->hasMany(ProjectAssembliesFiles::className(), ['destinationId' => 'id']);
    }
}
