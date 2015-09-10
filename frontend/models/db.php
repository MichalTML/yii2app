<?php
namespace frontend\models;
  /*
   * DB class
   * Singletone
   * Use PDO
   */

  class DB {
      
      private $host = '127.0.0.1';
      private $dbname = 'yii2app';
      private $user = 'root';
      private $password = '';
      
      private static $_db;

      private function __construct() {
          try {
              // assign PDO object to db variable
              self::$_db = new \PDO("mysql:host=$this->host; dbname=$this->dbname;", $this->user, $this->password);
              self::$_db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
          } catch (PDOException $e) {
              //Output error - would normally log this to error file rather than output to user.
              echo "Connection Error: " . $e->getMessage();
          }
      }

      private function __clone() {
          
      }

      // get connection function. Static method - accessible without instantiation
      public static function getConnection() {
          //Guarantees single instance, if no connection object exists then create one.
          
          if (!self::$_db) {
              //new connection object.
              new DB();
          }
          //return connection.
          return self::$_db;
      }

  }
  