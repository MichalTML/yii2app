<?php

namespace frontend\models;

use Yii;

use frontend\models\OClientDataStatus;
use common\models\User;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\AttributeBehavior;

/**
 * This is the model class for table "o_client_data".
 *
 * @property integer $id
 * @property integer $statusId
 * @property string $clientNumber
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
 * @property OClientContacts[] $oClientContacts
 * @property OClientDataStatus $status
 */
class OClientData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'o_client_data';
    }
    /**
     * @inheritdoc
     */
    
    
    public function rules()
    {
        return [
            [['name', 'phone', 'email', 'postal', 'city', 'adress'], 'required'], // normal scenario
            [[ 'name', 'adress', 'city', 'postal', 'phone', 'email', 'nip', 'krs', 'regon', 'www', 'clientNumber'], 'required', 'on' => 'promotion'], // promotion scenario
            [['creTime', 'updTime'], 'safe'],
            [['name', 'nip', 'krs'], 'unique', 'targetAttribute' => ['name', 'nip', 'krs'], 'message' => 'The combination of Name, Nip and Krs has already been taken.'],
            /// VALIDATION
            [ 'clientNumber', 'match', 'pattern' => '/^[0-9]{4}$/', 'message' => '( min. 4 digits ) Only numbers allowed', 'on' => 'promotion'], // promotion scenario],
            [ 'name', 'match', 'pattern' => '/^[a-zA-Z\s]*$/', 'message' => 'Name can only contain letters' ],
            [ 'abr', 'match', 'pattern' => '/^[a-zA-Z\s\.\-]*$/', 'message' => 'Abrevation can only contain letters and . -' ],
            [ 'city', 'match', 'pattern' => '/^[a-z0-9\s\.\-]*$/', 'message' => 'City can only contain aplhanumeric signs and . -' ],
            [ 'postal', 'match', 'pattern' => '/^[a-zA-Z0-9\-]{1,10}$/', 'message' => '(max 10 signs) Postal code can only contain aplhanumeric and -' ],
            [ 'phone', 'match', 'pattern' => '/^[0-9\-\+\(\)]*$/', 'message' => 'Phone number can only contain numbers and + ( ) -' ],
            [ 'fax', 'match', 'pattern' => '/^[0-9\-\+\(\)]*$/', 'message' => 'Fax number can only contain numbers and + ( ) -' ],
            ['email', 'email' , 'message' => 'Has to be valid email address'],
            [ 'nip', 'match', 'pattern' => '/^[A-Z0-9]{7,14}$/', 'message' => 'NIP can only contain numbers' ],
            [ 'krs', 'match', 'pattern' => '/^[0-9]{10}$/', 'message' => '( min. 10 digits ) KRS can only contain numbers' ],
            [ 'regon', 'match', 'pattern' => '/^[0-9]{7,14}$/', 'message' => '( min. 7, max. 14 ) REGON can only contain numbers' ],
            [ 'www', 'match', 'pattern' => '@^(http\:\/\/|https\:\/\/|www\.)?([a-z0-9][a-z0-9\-]*\.)+[a-z0-9][a-z0-9\-]*$@i', 'message' => 'Has to be valid www address' ],
            ];        
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'statusId' => 'Status ID',
            'status.statusName' => 'Status',
            'clientNumber' => 'Client Number',
            'name' => 'Name',
            'abr' => 'Abrevation',
            'adress' => 'Address',
            'city' => 'City',
            'postal' => 'Postal',
            'phone' => 'Phone',
            'fax' => 'Fax',
            'email' => 'Email',
            'nip' => 'Nip',
            'krs' => 'Krs',
            'regon' => 'Regon',
            'www' => 'Website',
            'description' => 'Description',
            'creTime' => 'Created at',
            'creUser.username' => 'Created by',
            'updTime' => 'Updated at',
            'updUser.username' => 'Updated by',
        ];
    }
    
    public function behaviors() {

        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['creTime', 'updTime' ],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updTime' ],
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
            ],
            'updatestamp' => [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['updUserId' ],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updUserId' ],
                ],
                'value' => function ($event)
        {
            return Yii::$app->user->identity->id;
        }
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOClientContacts()
    {
        return $this->hasMany(OClientContacts::className(), ['clientId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(OClientDataStatus::className(), ['id' => 'statusId']);
    }
    
    public function getStatusList()
    {
        $droptions = OClientDataStatus::find()->asArray()->all();
        return ArrayHelper::map( $droptions, 'id', 'statusName');
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdUser()
    {
        return $this->hasOne(User::className(), ['id' => 'updUserId']);
    }
    public function getUpdUserName()
    {
        return $this->updUser ? $this->updUser->username : '--not set--';
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreUser()
    {
        return $this->hasOne(User::className(), ['id' => 'creUserId']);
    }    
}
