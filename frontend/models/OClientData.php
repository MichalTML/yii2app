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
            
            [['statusId', 'phone', 'fax', 'krs', 'regon', 'creUserId', 'updUserId'], 'integer'],
            [['name', 'phone', 'email'], 'required'], // normal scenario
            [[ 'name', 'adress', 'city', 'postal', 'phone', 'email', 'nip', 'krs', 'regon', 'www', 'clientNumber'], 'required', 'on' => 'promotion'], // promotion scenario
            [['creTime', 'updTime'], 'safe'],
            [['clientNumber'], 'string', 'max' => 6],
            [['name', 'city', 'postal'], 'string', 'max' => 45],
            [['abr'], 'string', 'max' => 10],
            [['adress', 'www', 'description'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 60],
            [['nip'], 'string', 'max' => 12],
            [['name', 'nip', 'krs'], 'unique', 'targetAttribute' => ['name', 'nip', 'krs'], 'message' => 'The combination of Name, Nip and Krs has already been taken.']
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
            'statusName' => 'Status',
            'clientNumber' => 'Client Number',
            'name' => 'Name',
            'abr' => 'Abr',
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
            'creTime' => 'Cre Time',
            'creUserId' => 'Cre User ID',
            'creUserName' => 'Created by',
            'updTime' => 'Upd Time',
            'updUserName' => 'Updated by',
            'updUserId' => 'Upd User ID',
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
    
    public function getStatusName()
    {
        return $this->status->statusName;
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
    public function getCreUserName()
    {
        return $this->creUser ? $this->creUser->username : '--not set--';
    }
    
}
