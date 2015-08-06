<?php

namespace frontend\models;

use Yii;

use frontend\models\OClientData;
use frontend\models\ClientContacts;
use frontend\models\Gender;
use common\models\User;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\AttributeBehavior;
use frontend\controllers\OClientContactsController;

/**
 * This is the model class for table "o_client_contacts".
 *
 * @property integer $id
 * @property integer $clientId
 * @property string $firstName
 * @property string $lastName
 * @property integer $genderId
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
 * @property Gender $gender
 * @property User $creUser
 * @property User $updUser
 * @property OClientData $client
 */
class OClientContacts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'o_client_contacts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['clientId', 'firstName', 'lastName', 'genderId', 'phone', 'email'], 'required'],
            [['clientId', 'genderId', 'creUserId', 'updUserId'], 'integer'],
            [['creTime', 'updTime'], 'safe'],
            ['email', 'email'],
            [['firstName', 'lastName', 'phone', 'fax', 'department', 'position'], 'string', 'max' => 45],
            [['email'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client.name' => 'Client Name',
            'gender.genderName' => 'Gender',
            'firstName' => 'First Name',
            'lastName' => 'Last Name',
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
    
    public function moveContacts( $clientId ) {
        $contacts = $this->find()->where( ['clientId' => $clientId])->all();
        $clientContacts = new ClientContacts;
        
        foreach($contacts as $contact){
            $clientContacts->clientId = $clientId;
            $clientContacts->firstName = $contact->firstName;
            $clientContacts->lastName = $contact->lastName;
            $clientContacts->genderId = $contact->genderId;
            $clientContacts->phone = $contact->phone;
            $clientContacts->fax = $contact->fax;
            $clientContacts->email = $contact->email;
            $clientContacts->department = $contact->department;
            $clientContacts->position = $contact->position;
            $clientContacts->creTime = $contact->creTime;
            $clientContacts->creUserId = $contact->creUserId;
            $clientContacts->updTime = $contact->updTime;
            $clientContacts->updUserId = $contact->updUserId;
            $clientContacts->description = $contact->description;
            $clientContacts->isNewRecord = true;
            $clientContacts->id = null;
            
            if($clientContacts->save()){
            $delete = $this->find()->where(['id' => $contact->id])->one();
            
            
            $delete->delete();
       }
        }
       return true;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGender()
    {
        return $this->hasOne(Gender::className(), ['id' => 'genderId']);
    }
    public function getGenderList()
    {
        $droptions = Gender::find()->asArray()->all();
        return ArrayHelper::map( $droptions, 'id', 'genderName');
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
    public function getUpdUser()
    {
        return $this->hasOne(User::className(), ['id' => 'updUserId']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(OClientData::className(), ['id' => 'clientId']);
    }
    
    public function getClientName()
    {
        return $this->client->name;
    }
    public function getClientList()
    {
        $droptions = OClientData::find()->asArray()->all();
        return ArrayHelper::map( $droptions, 'id', 'name');
    }
    
}
