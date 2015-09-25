<?php

namespace frontend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\AttributeBehavior;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use common\models\User;
/**
 * This is the model class for table "project_assemblies_files_notes".
 *
 * @property integer $id
 * @property integer $fileId
 * @property string $note
 * @property integer $typeId
 * @property integer $creUserId
 * @property string $creTime
 *
 * @property ProjectAssembliesFiles $file
 * @property ProjectFilesNotesType $type
 * @property User $creUser
 */
class ProjectAssembliesFilesNotes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_assemblies_files_notes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fileId', 'note'], 'required'],
            [['fileId', 'typeId', 'creUserId'], 'integer'],
            [['creTime'], 'safe'],
            [['note'], 'string', 'max' => 255]
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
            'note' => 'Note content',
            'typeId' => 'Destination',
            'creUserId' => 'Created by',
            'creTime' => 'Created at',
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
    public function getFile()
    {
        return $this->hasOne(ProjectAssembliesFiles::className(), ['id' => 'fileId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(ProjectFilesNotesType::className(), ['id' => 'typeId']);
    }
    
    public function getTypeList()
    {
        $droptions = ProjectFilesNotesType::find()->asArray()->all();
        return ArrayHelper::map( $droptions, 'id', 'type' );
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreUser()
    {
        return $this->hasOne(User::className(), ['id' => 'creUserId']);
    }
}
