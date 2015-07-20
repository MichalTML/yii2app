<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\User;
use frontend\models\ProjectData;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\AttributeBehavior;


/**
 * This is the model class for table "client_data".
 *
 * @property integer $id
 * @property integer $clientNumber
 * @property string $name
 * @property string $abr
 * @property string $adress
 * @property integer $phone
 * @property integer $fax
 * @property string $email
 * @property string $nip
 * @property integer $krs
 * @property integer $regon
 * @property string $www
 * @property string $creDate
 * @property string $updDate
 * @property integer $creUserId
 * @property integer $updUserId
 * @property integer $contactId
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
            [['clientNumber', 'name', 'abr', 'adress', 'phone', 'fax', 'email', 'nip', 'krs', 'regon', 'www', 'updDate', 'creUserId', 'updUserId', 'contactId'], 'required'],
            [['clientNumber', 'phone', 'fax', 'krs', 'regon', 'creUserId', 'updUserId', 'contactId'], 'integer'],
            [['creDate', 'updDate'], 'safe'],
            [['name'], 'string', 'max' => 45],
            [['abr'], 'string', 'max' => 10],
            [['adress', 'www'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 60],
            [['nip'], 'string', 'max' => 12],
            [['clientNumber', 'name', 'nip', 'krs'], 'unique', 'targetAttribute' => ['clientNumber', 'name', 'nip', 'krs'], 'message' => 'The combination of Client Number, Name, Nip and Krs has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Client Number',
            'name' => 'Name',
            'abr' => 'Abbrevation',
            'adress' => 'Adress',
            'phone' => 'Phone number',
            'fax' => 'Fax number',
            'email' => 'Email',
            'nip' => 'Nip',
            'krs' => 'Krs',
            'regon' => 'Regon',
            'www' => 'www site',
            'creDate' => 'Creation Date',
            'updDate' => 'Update Date',
            'creUserId' => 'Created by',
            'updUserId' => 'Updated by',
            'contactId' => 'Contacts',
        ];
    }
    
    /**
     * get client relationship
     */
    
    public function getProjects()
    {
        return $this->hasMany(ProjectData::className(), ['clientId' => 'clientNumber']);
    }  
    
    
}
