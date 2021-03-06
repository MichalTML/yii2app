<?php

namespace common\models;

use yii;

class RecordHelpers {

    public static function userHas( $model_name ) {
        $connection = \Yii::$app->db;

        $userid = yii::$app->user->identity->id;
        $sql = "SELECT id FROM $model_name WHERE userId=:userid";
        $command = $connection->createCommand( $sql );
        $command->bindValue( ":userid", $userid );
        $result = $command->queryOne();

        if ( $result == null ) {

            return false;
        } else {

            return $result[ 'id' ];
        }
    }

}
