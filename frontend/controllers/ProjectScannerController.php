<?php

namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\ProjectData;

class ProjectScannerController extends Controller {

    public $projectsData = [ ];
    
    public function actionUpload(){
        
         $model = new ProjectData();
         
         $path = 'e:\tma_projekty\\';
         $prjectScan = new \FilesystemIterator($path);
         
        foreach($prjectScan as $project){
             $sygnatureParts = explode('_', $project->getFilename());
             $sygnature = preg_replace('/p/i', '', $sygnatureParts[1]);
             $projectData = $model->find()->where(['sygnature' => $sygnature ])->one();
             $this->projectsData[] = ['name' => $project->getFilename(), 'id' => $projectData->id, 'sygnature' => $projectData->sygnature];
             }
         $this->layout = 'menu';
         return $this->renderPartial( 'upload', [
             'projectData' => $this->projectsData,
         ]);
     }
    
     public function actionAjax(){
         return $this->renderPartial( 'ajax' );
     }
    
    
}
