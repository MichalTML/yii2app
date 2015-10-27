<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "files_images".
 *
 * @property integer $id
 * @property integer $fileId
 * @property string $imagePath
 *
 * @property ProjectAssembliesFiles $file
 */
class FilesImages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'files_images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fileId', 'imagePath'], 'required'],
            [['fileId'], 'integer'],
            [['imagePath'], 'string', 'max' => 255]
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
            'imagePath' => 'Image Path',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(ProjectAssembliesFiles::className(), ['id' => 'fileId']);
    }
}
