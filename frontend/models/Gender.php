<?php

namespace frontend\models;

use Yii;

use frontend\models\Profile;
use frontend\models\ClientContacts;

/**
 * This is the model class for table "gender".
 *
 * @property integer $id
 * @property string $genderName
 *
 * @property ClientContacts[] $clientContacts
 * @property Profile[] $profiles
 */
class Gender extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gender';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['genderName'], 'required'],
            [['genderName'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'genderName' => 'Gender Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientContacts()
    {
        return $this->hasMany(ClientContacts::className(), ['genderId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles()
    {
        return $this->hasMany(Profile::className(), ['gender_id' => 'id']);
    }
}
