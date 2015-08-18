<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\User;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "profile".
 *
 * @property string $id
 * @property string $userId
 * @property string $firstName
 * @property string $lastName
 * @property string $birthdate
 * @property integer $genderId
 * @property string $created
 * @property string $updated
 *
 * @property Gender $gender
 */
class Profile extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'profile';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [[ 'userId', 'firstName', 'lastName'], 'required' ],
            [[ 'userId', 'genderId' ], 'integer' ],
            ['firstName', 'match', 'pattern' => '/^[A-ZŻŹĆĄŚĘŁÓŃ]{1}[a-zżźćńółęąś]*$/', 'message' => 'valid example: John'],
            ['lastName', 'match', 'pattern' => '/^[A-ZŻŹĆĄŚĘŁÓŃ]{1}[a-zżźćńółęąś]*$/', 'message' => 'valid example: Johnson'],
            [[ 'birthdate', 'created', 'updated' ], 'safe' ],
            [[ 'birthdate' ], 'date', 'format' => 'Y-m-d' ],
            //[['birthdate'], 'date', 'format' => 'php:Y-m-d'];
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'userId' => 'User ID',
            'firstNme' => 'First Name',
            'lastName' => 'Last Name',
            'birthdate' => 'Birthdate',
            'genderId' => 'Gender ID',
            'created' => 'Created At',
            'updated' => 'Updated At',
            'genderName' => Yii::t( 'app', 'Gender' ),
            'userLink' => Yii::t( 'app', 'User' ),
            'profileLink' => Yii::t( 'app', 'Profile' ),
            'user.last_log' => 'Saw At',
        ];
    }

    /**
     * behaviors to control time stampm don`t forget to use statement for expression
     */
    public function behaviors() {
        return [

            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created', 'updated' ],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated' ],
                ],
                'value' => new Expression( 'NOW()' ),
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGender() {
        return $this->hasOne( Gender::className(), ['id' => 'genderId' ] );
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    
    public function getGenderName()
    {
        return $this->gender->genderName;
    }
    
    /**
     * get list of genders for drop down
     */
    
    public static function getGenderList()
    {
        
        $droptions = Gender::find()->asArray()->all();
        return ArrayHelper::map($droptions, 'id', 'genderName');
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userId'])->from(User::tableName() . ' us');
    }
    
    public function getRole()
    {
        return $this->hasOne(Role::className(), ['id' => 'role_id'])->viaTable('user', ['id' => 'userId']);
    }
    
    /**
     * @get Username
     */
    public function getUserEmail()
    {
        return $this->user->email;
        
    }
    public function getUsername()
    {
        return $this->user->username;
        
    }    
    
    /**
     * @getUserId
     */
    
    public function getUserId()
    {
        return $this->user ? $this->user->id : 'none';
        
    }
    
    /**
     * @getUserLink
     */
    
    public function getUserLink()
    {
        $url = Url::to(['user/view', 'id'=>$this->UserId]);
        $options = [];
        return Html::a($this->getUserName(), $url, $options);
    }
    
    /**
     * @getProfink
     */
    
    public function getProfileIdLink()
    {
        $url = Url::to(['profile/update', 'id'=>$this->id]);
        $options = [];
        return Html::a($this->id, $url, $options);
    }
    
//    public function beforeValidate()
//            {
//        if($this->birthdate != null){
//            $new_date_format = date('Y-m-d', strtotime($this->birthdate));
//            $this->birthdate = $new_date_format;
//        }
//        
//        return parent::beforeValidate();
//    }
//    
    public function signup()
    {
        if ($this->validate()) {
            $user = new Profile();
            //$user->first_name = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }
    
    
}
