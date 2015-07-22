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
 * @property string $postal 
 * @property string $city 
 * @property integer $phone
 * @property integer $fax
 * @property string $email
 * @property string $nip
 * @property integer $krs
 * @property integer $regon
 * @property string $www
 * @property string $creTime
 * @property string $updTime
 * @property integer $creUser
 * @property integer $updUserId
 * @property integer $contactIdc
 */
class ClientData extends \yii\db\ActiveRecord {

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
            [[ 'clientNumber', 'name', 'abr', 'adress', 'phone', 'fax', 'email', 'nip', 'krs', 'regon', 'www', 'contactId' ], 'required' ],
            [[ 'clientNumber', 'phone', 'fax', 'krs', 'regon', 'creUser', 'updUserId', 'contactId' ], 'integer' ],
            [[ 'creTime', 'updTime' ], 'safe' ],
            [[ 'name' ], 'string', 'max' => 45 ],
            [[ 'abr' ], 'string', 'max' => 10 ],
            [[ 'adress', 'www' ], 'string', 'max' => 255 ],
            [[ 'email' ], 'string', 'max' => 60 ],
            [[ 'nip' ], 'string', 'max' => 12 ],
            [[ 'clientNumber', 'name', 'nip', 'krs' ], 'unique', 'targetAttribute' => ['clientNumber', 'name', 'nip', 'krs' ], 'message' => 'The combination of Client Number, Name, Nip and Krs has already been taken.' ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'clientNumber' => 'Client Number',
            'name' => 'Name',
            'abr' => 'Abbrevation',
            'adress' => 'Adress',
            'phone' => 'Phone',
            'fax' => 'Fax',
            'email' => 'Email',
            'nip' => 'Nip',
            'krs' => 'Krs',
            'regon' => 'Regon',
            'www' => 'Site',
            'creTime' => 'Create Time',
            'updTime' => 'Update Time',
            'creUser' => 'Created by',
            'updUserId' => 'Updated by',
            'contactId' => 'Contacts',
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
            'userstamp' => [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['creUser', 'updUser' ],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updUser' ],
                ],
                'value' => function ($event) {
            return Yii::$app->user->identity->firstlastName;
        }
            ],
        ];
    }

    /**
     * get client relationship
     */
    public function getProjects() {
        return $this->hasMany( ProjectData::className(), ['clientId' => 'clientNumber' ] );
    }

}
