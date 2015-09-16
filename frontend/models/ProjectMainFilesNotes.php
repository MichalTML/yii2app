<?php

namespace frontend\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use common\models\User;
/**
 * This is the model class for table "project_main_files_notes".
 *
 * @property integer $id
 * @property integer $fileId
 * @property integer $note
 * @property integer $typeId
 * @property integer $creUserId
 * @property string $creTime
 *
 * @property User $creUser
 * @property ProjectMainFiles $file
 * @property ProjectFilesNotesType $type
 */
class ProjectMainFilesNotes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_main_files_notes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fileId', 'note', 'typeId'], 'required'],
            [['creTime'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fileId' => 'File ID',
            'note' => 'Note',
            'typeId' => 'Type ID',
            'creUserId' => 'Cre User ID',
            'creTime' => 'Cre Time',
        ];
    }
    
    public function behaviors() {

        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['creTime'],
                ],
                'value' => new Expression( 'NOW()' ),
            ],
            'createstamp' => [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['creUserId' ],
                ],
                'value' => function ($event)
        {
            return Yii::$app->user->identity->id;
        }
            ]
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreUser()
    {
        return $this->hasOne(User::className(), ['id' => 'creUserId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(ProjectMainFiles::className(), ['id' => 'fileId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(ProjectFilesNotesType::className(), ['id' => 'typeId']);
    }
}
