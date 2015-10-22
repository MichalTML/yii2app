<?php

namespace frontend\models;

use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "project_assemblies_files_data".
 *
 * @property integer $fileId
 * @property integer $statusId
 * @property string $tiemStamp
 *
 * @property ProjectAssembliesFilesStatus $status
 * @property ProjectAssembliesFiles $file
 */
class ProjectAssembliesFilesData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_assemblies_files_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fileId', 'statusId'], 'required'],
            [['fileId', 'statusId'], 'integer'],
            [['timeStamp'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {       
        return [
            'fileId' => 'File ID',
            'statusId' => 'Status ID',
            'timeStamp' => 'Time Stamp',
        ];
    }
    
    public function behaviors() {

        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['timeStamp'],
                ],
                'value' => new Expression( 'NOW()' ),
            ],
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(ProjectAssembliesFilesStatus::className(), ['statusId' => 'statusId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(ProjectAssembliesFiles::className(), ['id' => 'fileId']);
    }
}
