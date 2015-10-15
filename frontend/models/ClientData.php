<?php

namespace frontend\models;

use Yii;

use frontend\models\ProjectData;
use common\models\User;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\AttributeBehavior;

/**
 * This is the model class for table "client_data".
 *
 * @property integer $id
 * @property int $clientNumber 
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
    public static function tableName() {
        return 'client_data';
    }

    /**
     * @inheritdoc
     */
     public function rules() {
        return [
            [[ 'name', 'adress', 'city', 'postal', 'nip', 'regon', 'www', 'clientNumber', 'abr' ], 'required' ],
            [[ 'creTime', 'updTime' ], 'safe' ],
            [[ 'clientNumber', 'name', 'regon', 'nip', 'krs','regon'  ], 'unique'],
        
           /// VALIDATION
            [ 'clientNumber', 'match', 'pattern' => '/^[0-9]{4}$/', 'message' => '( min. 4 digits ) Only numbers allowed' ],
            [ 'name', 'match', 'pattern' => '/^[a-zA-ZżźćńółęąśŻŹĆĄŚĘŁÓŃ\s\.\-]*$/', 'message' => 'Name can only contain letters and .' ],
            [ 'abr', 'match', 'pattern' => '/^[a-zA-ZżźćńółęąśŻŹĆĄŚĘŁÓŃ\s\.\-]*$/', 'message' => 'Abrevation can only contain letters and . -' ],
            [ 'city', 'match', 'pattern' => '/^[a-zżźćńółęąśŻŹĆĄŚĘŁÓŃ0-9\s\.\-]*$/i', 'message' => 'City can only contain aplhanumeric signs and . -' ],
            [ 'postal', 'match', 'pattern' => '/^[a-zżźćńółęąśŻŹĆĄŚĘŁÓŃA-Z0-9\-]{1,10}$/', 'message' => '(max 10 signs) Postal code can only contain aplhanumeric and -' ],
            [ 'phone', 'match', 'pattern' => '/^[0-9\-+\s\(\)]*$/', 'message' => 'Phone number can only contain numbers and + ( ) -' ],
            [ 'fax', 'match', 'pattern' => '/^[0-9-+\s\(\)]*$/', 'message' => 'Fax number can only contain numbers and + ( ) -' ],
            ['email', 'match' , 'pattern' => '/^[a-zA-Z0-9\_\.\+\-]+@[a-zA-Z0-9\-\_]+\.[a-zA-Z0-9\-\\_\.]+$/', 'message' => 'Has to be valid email address'],
            [ 'nip', 'match', 'pattern' => '/^[A-Z0-9]{7,14}$/', 'message' => 'Has to be valid NIP number' ],
            [ 'krs', 'match', 'pattern' => '/^[0-9]{10}$/', 'message' => 'Has to be valid KRS number' ],
            [ 'regon', 'match', 'pattern' => '/^[0-9]{7,14}$/', 'message' => 'Has to be valid NIP number REGON number' ],
            [ 'www', 'match', 'pattern' => '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/', 'message' => 'Has to be valid website address']
       ];     
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'id',
            'clientNumber' => 'Client Number',
            'name' => 'Full Name',
            'abr' => 'Name',
            'adress' => 'Adress',
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
            'updUser.username' => 'Updated by',
            'updTime' => 'Updated at',
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
    public function getClientContacts() {
        return $this->hasOne( ClientContacts::className(), ['clientId' => 'id' ] );
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdUser()
    {
        return $this->hasOne(User::className(), ['id' => 'updUserId']);
    }
    public function getCreUser(){
        return $this->hasOne(User::className(), ['id' => 'creUserId']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectDatas() {
        return $this->hasMany( ProjectData::className(), ['clientId' => 'id' ] );
    }

    public function setClientNumber() {
        $currentYear = date( 'Y' );
        $companyYears = (string)substr( $currentYear, 3 );
        $companyYears = '0' . $companyYears;

        $stmt = "SELECT * FROM client_data WHERE YEAR(creTime) =" . $currentYear;

        $stmt = Yii::$app->db->createCommand( $stmt )->execute();
        if ( $stmt < 10 )
        {
            $stmt = substr_replace( $stmt, '0', -1 ) . $stmt;
        }
        $newClientNumber = $companyYears . $stmt;
        return $newClientNumber;
    }
    
    public function setNewClientNumber() {
        $newNumber = $this->setClientNumber() + 1;
        $newNumber = (string)'0' . $newNumber;
        return $newNumber;
    }
}
