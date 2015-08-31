<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "invoices".
 *
 * @property integer $id
 * @property string $name
 * @property integer $supplierId
 * @property string $connection
 * @property integer $isAccepted
 * @property string $ext
 * @property string $path
 * @property integer $acceptedBy
 * @property string $creTime
 */
class Invoices extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invoices';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name', 'ext', 'path', 'creTime'], 'required'],
            [['id', 'supplierId', 'isAccepted', 'acceptedBy'], 'integer'],
            [['creTime'], 'safe'],
            [['name', 'connection', 'path'], 'string', 'max' => 255],
            [['ext'], 'string', 'max' => 5]
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
            'supplierId' => 'Supplier ID',
            'connection' => 'Connection',
            'isAccepted' => 'Is Accepted',
            'ext' => 'Ext',
            'path' => 'Path',
            'acceptedBy' => 'Accepted By',
            'creTime' => 'Cre Time',
        ];
    }
}
