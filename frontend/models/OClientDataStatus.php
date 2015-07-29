<?php

namespace frontend\models;

use Yii;


/**
 * This is the model class for table "o_client_data_status".
 *
 * @property integer $id
 * @property string $statusName
 *
 * @property OClientData[] $oClientDatas
 */
class OClientDataStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'o_client_data_status';
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
    public function getOClientDatas()
    {
        return $this->hasMany(OClientData::className(), ['statusId' => 'id']);
    }
}
