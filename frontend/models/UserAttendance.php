<?php

namespace frontend\models;

use Yii;

use common\models\User;

/**
 * This is the model class for table "user_attendance".
 *
 * @property integer $id
 * @property integer $userId
 * @property string $date
 *
 * @property User $user
 */
class UserAttendance extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'user_attendance';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [[ 'userId', 'date' ], 'required' ],
            [[ 'id', 'userId' ], 'integer' ],
            [[ 'date' ], 'safe' ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'userId' => 'User ID',
            'date' => 'Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne( User::className(), ['id' => 'userId' ] );
    }
    
    public function getUserName() {
        return $this->user->username;
    }

    /**
     * USER ATTENDANCE CHECK/WRITE
     */
    public function stampAttendance( $userId ) {
        
        $this->isNewRecord = true;
        $this->userId = $userId;
        $this->date = date( 'Y-m-d' );

        if ( $this->find()->where( 'userId = :id AND date = :date', ['id' => $userId, 'date' => $this->date ] )->all() )
        {
            return false;
        }
        $this->save(); 
    }
    
    public static function getCallendarInfo() {
       // return $days = date('t');
        return $day = date("l", mktime(0, 0, 0, date("m"), 1, date("Y")));
    }
    
}