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
            [[ 'name', 'adress', 'city', 'postal', 'phone', 'email', 'nip', 'krs', 'regon', 'www', 'clientNumber' ], 'required' ],
            [[ 'phone', 'fax', 'krs', 'regon', 'creUserId', 'updUserId' ], 'integer' ],
            [[ 'creTime', 'updTime' ], 'safe' ],
            [[ 'name', 'city', 'postal' ], 'string', 'max' => 45 ],
            [[ 'abr' ], 'string', 'max' => 10 ],
            [[ 'adress', 'www', 'description' ], 'string', 'max' => 255 ],
            [[ 'email' ], 'string', 'max' => 60 ],
            [[ 'nip' ], 'string', 'max' => 12 ],
            [[ 'name', 'regon', 'nip', 'krs', 'clientNumber' ], 'unique', 'targetAttribute' => ['name', 'regon', 'nip', 'krs' ], 'message' => 'The combination of client number, name,regon, nip and krs has already been taken.' ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'Client Number',
            'clientNumber' => 'Client Number',
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
            'creUser.username' => 'Created by',
            'updUserName' => 'Updated by',
            'updTime' => 'Update Time',
            'updUserId' => 'Updated by',
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
     public function getCreUserName()
    {
        return $this->creUser ? $this->creUser->username : '---';
    }
    
    public function getUpdUserName()
    {
        return $this->updUser ? $this->updUser->username : '---';
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
