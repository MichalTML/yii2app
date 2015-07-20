<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "client_contacts".
 *
 * @property integer $clientId
 * @property string $firstlastName
 * @property string $gender
 * @property string $phone
 * @property string $fax
 * @property string $email
 * @property string $department
 * @property string $position
 * @property string $creTime
 * @property string $creUser
 * @property string $updTime
 * @property string $updUser
 * @property string $description
 */
class Contacts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client_contacts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['clientId', 'firstlastName', 'gender', 'phone', 'fax', 'email', 'department', 'position', 'creUser', 'updTime', 'updUser', 'description'], 'required'],
            [['clientId'], 'integer'],
            [['creTime', 'updTime'], 'safe'],
            [['firstlastName', 'gender', 'phone', 'fax', 'department', 'position'], 'string', 'max' => 45],
            [['email', 'creUser', 'updUser'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'clientId' => 'Client ID',
            'firstlastName' => 'Firstlast Name',
            'gender' => 'Gender',
            'phone' => 'Phone',
            'fax' => 'Fax',
            'email' => 'Email',
            'department' => 'Department',
            'position' => 'Position',
            'creTime' => 'Cre Time',
            'creUser' => 'Cre User',
            'updTime' => 'Upd Time',
            'updUser' => 'Upd User',
            'description' => 'Description',
        ];
    }
}
