<?php

namespace frontend\models;

use Yii;

use frontend\models\ProjectData;

/**
 * This is the model class for table "client_data".
 *
 * @property integer $id
 * @property string $name
 * @property string $abr
 * @property string $adress
 * @property string $city
 * @property string $postal
 * @property integer $phone
 * @property integer $fax
 * @property string $email
 * @property string $nip
 * @property integer $krs
 * @property integer $regon
 * @property string $www
 * @property string $description
 * @property string $creTime
 * @property integer $creUserId
 * @property string $updTime
 * @property integer $updUserId
 *
 * @property ClientContacts $clientContacts
 * @property User $updUser
 * @property User $creUser
 * @property ProjectData[] $projectDatas
 */
class ClientData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'adress', 'city', 'postal', 'phone', 'email', 'nip', 'krs', 'regon', 'www'], 'required'],
            [['phone', 'fax', 'krs', 'regon', 'creUserId', 'updUserId'], 'integer'],
            [['creTime', 'updTime'], 'safe'],
            [['name', 'city', 'postal'], 'string', 'max' => 45],
            [['abr'], 'string', 'max' => 10],
            [['adress', 'www', 'description'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 60],
            [['nip'], 'string', 'max' => 12],
            [['name', 'regon', 'nip', 'krs'], 'unique', 'targetAttribute' => ['name', 'regon', 'nip', 'krs'], 'message' => 'The combination of name,regon, nip and krs has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Client Number',
            'name' => 'Name',
            'abr' => 'Abrevation',
            'adress' => 'Adress',
            'city' => 'City',
            'postal' => 'Postal',
            'phone' => 'Phone',
            'fax' => 'Fax',
            'email' => 'Email',
            'nip' => 'Nip',
            'krs' => 'Krs',
            'regon' => 'Regon',
            'www' => 'Www',
            'description' => 'Description',
            'creTime' => 'Creation Time',
            'creUserId' => 'Created by ',
            'updTime' => 'Update Time',
            'updUserId' => 'Updated by',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientContacts()
    {
        return $this->hasOne(ClientContacts::className(), ['clientId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdUser()
    {
        return $this->hasOne(User::className(), ['id' => 'updUserId']);
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
    public function getProjectDatas()
    {
        return $this->hasMany(ProjectData::className(), ['clientId' => 'id']);
    }
   
}
