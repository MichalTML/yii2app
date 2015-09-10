<?php
namespace frontend\models;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class LogCreator {
    
    public $path = '/logs/';
    
    public function createLog($data) {

        $path = $_SERVER['DOCUMENT_ROOT'].$this->path.date('y-m-d').'_log.txt';
        file_put_contents($path, '|||'.json_encode($data), FILE_APPEND);
        
    }
    
    public function createError($data){
        
        $path = $_SERVER['DOCUMENT_ROOT'].$this->path.date('y-m-d').'_error.txt';
        file_put_contents($path, '|||'.json_encode($data), FILE_APPEND);
        
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
