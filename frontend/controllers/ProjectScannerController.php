<?php

namespace frontend\controllers;

use yii\web\Controller;

class ProjectScannerController extends Controller {

    public $projectsList = ['1' => 'project51'];
    
    public function actionUpload(){
         //$path = '/media/data/app_data/project_data/';
        // $prjectScan = new \FilesystemIterator($path);
        // 
        //foreach($prjectScan as $project){
             //$this->projectsList[] = $project->getFilename();
        // }
         $this->layout = 'menu';
         return $this->renderPartial( 'upload', [
             'projectList' => $this->projectsList,
         ]);
     }
    
     public function actionAjax(){
         return $this->render( 'ajax' );
     }
    
    
}
