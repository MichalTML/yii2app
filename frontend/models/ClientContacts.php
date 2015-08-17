<?php

namespace frontend\models;

use Yii;
use frontend\models\Gender;
use frontend\models\ClientData;
use common\models\User;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "client_contacts".
 *
 * @property integer $clientId
 * @property string $firstName
 * @property string $lastName
 * @property string $genderId
 * @property string $phone
 * @property string $fax
 * @property string $email
 * @property string $department
 * @property string $position
 * @property string $creTime
 * @property integer $creUserId
 * @property string $updTime
 * @property integer $updUserId
 * @property string $description
 *
 * @property User $updUser
 * @property ClientData $client
 * @property User $creUser
 */
class ClientContacts extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'client_contacts';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [[ 'clientId', 'firstName', 'lastName', 'genderId', 'phone', 'email' ], 'required' ],
            [[ 'clientId', 'creUserId', 'updUserId' ], 'integer' ],
            [[ 'creTime', 'updTime' ], 'safe' ],
            ['email', 'email'],
            [[ 'description' ], 'string', 'max' => 255 ],
            
            ///VALIDATION
            ['firstName', 'match', 'pattern' => '/^[A-ZŻŹĆĄŚĘŁÓŃ]{1}[a-zżźćńółęąś]*$/', 'message' => 'valid example: John'],
            ['lastName', 'match', 'pattern' => '/^[A-ZŻŹĆĄŚĘŁÓŃ]{1}[a-zżźćńółęąś]*$/', 'message' => 'valid example: Johnson'],
            [ 'phone', 'match', 'pattern' => '/^[0-9-+\(\)]*$/', 'message' => 'Phone number can only contain numbers and + ( ) -' ],
            [ 'fax', 'match', 'pattern' => '/^[0-9-+\(\)]*$/', 'message' => 'Fax number can only contain numbers and + ( ) -' ],
            ['email', 'email' , 'message' => 'Has to be valid email address'],
            [ 'department', 'match', 'pattern' => '/^[A-Za-z\s]*$/', 'message' => 'Only letters allowed' ],
            [ 'position', 'match', 'pattern' => '/^[A-Za-z\s]*$/', 'message' => 'Only letters allowed' ],
            ];            
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'clientId' => 'Client Name',
            'firstName' => 'First Name',
            'lastName' => 'Last Name',
            'gender.genderName' => 'Gender',
            'phone' => 'Phone',
            'fax' => 'Fax',
            'email' => 'Email',
            'department' => 'Department',
            'position' => 'Position',
            'creTime' => 'Created at',
            'creUser.username' => 'Created by',
            'updTime' => 'Updated at',
            'updUser.username' => 'Updated by',
            'description' => 'Description',
            'client.name' => 'Client Name',
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
    public function getUpdUser() {
        return $this->hasOne( User::className(), ['id' => 'updUserId' ] );
    }

    public function getCreUser() {
        return $this->hasOne( User::className(), ['id' => 'creUserId' ] );
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient() {
        return $this->hasOne( ClientData::className(), ['id' => 'clientId' ] );
    }
    public function getClientName() 
    {
        return $this->client->name;
    }

    public function getClientList() {
        $droptions = ClientData::find()->asArray()->all();
        return ArrayHelper::map( $droptions, 'id', 'name' );
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGender() {
        return $this->hasOne( Gender::className(), ['id' => 'genderId' ] );
    }

    public function getGenderList() {
        $droptions = Gender::find()->asArray()->all();
        return ArrayHelper::map( $droptions, 'id', 'genderName' );
    }

}
