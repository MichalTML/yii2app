<?php

namespace frontend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;


/**
 * This is the model class for table "client_krs_files".
 *
 * @property integer $id
 * @property string $path
 * @property string $creTime
 * @property string $updTime
 * @property integer $creUser
 * @property integer $updUser
 *
 * @property User $updUser0
 * @property User $creUser0
 */
class ClientKrsFiles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client_krs_files';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['path', 'clientId'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'path' => 'Path',
            'creTime' => 'Cre Time',
            'updTime' => 'Upd Time',
            'creUser' => 'Cre User',
            'updUser' => 'Upd User',
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
                    ActiveRecord::EVENT_BEFORE_INSERT => ['creUser' ],
                ],
                'value' => function ($event)
        {
            return Yii::$app->user->identity->id;
        }
            ],
                'updatestamp' => [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['updUser' ],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updUser' ],
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
    public function getUpdUser0()
    {
        return $this->hasOne(User::className(), ['id' => 'updUser']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreUser0()
    {
        return $this->hasOne(User::className(), ['id' => 'creUser']);
    }
}
