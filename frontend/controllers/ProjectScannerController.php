<?php

namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\ProjectData;

class ProjectScannerController extends Controller {

    public $projectsData = [ ];
    
    public function actionUpload(){
        
         $model = new ProjectData();
         
         $path = '/media/data/NAS/TMA/TMA_KONST_TEMP/';
         //$path = '/media/data/app_data/project_data/';
         $prjectScan = new \FilesystemIterator($path);

        foreach($prjectScan as $project){
            $sygnatureParts = explode('_', $project->getFilename());
                if(count($sygnatureParts) > 1){
                    $sygnature = preg_replace('/p/i', '', $sygnatureParts[1]);
                    if(\preg_match( '/^[0-9]*$/', $sygnature)){
                        $projectData = $model->find()->where(['sygnature' => $sygnature ])->one();
                        if($projectData){
                            $this->projectsData[] =
                            ['name' => $project->getFilename(), 'id' => $projectData->id, 'sygnature' => $projectData->sygnature];
                        }  
                    }
                }
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
