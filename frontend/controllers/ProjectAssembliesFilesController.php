<?php

namespace frontend\controllers;

use Yii;
use frontend\models\ProjectAssembliesFiles;
use frontend\models\search\ProjectAssembliesFilesSearch;
use frontend\models\ProjectAssembliesFilesNotes;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\ProjectAssembliesFilesData;
use frontend\models\FileGroup;
use frontend\models\FileGroupName;
use yii\web\UploadedFile;
use frontend\models\ProjectAssembliesMainFiles;

/**
 * ProjectAssembliesFilesController implements the CRUD actions for ProjectAssembliesFiles model.
 */
class ProjectAssembliesFilesController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all ProjectAssembliesFiles models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProjectAssembliesFilesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProjectAssembliesFiles model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ProjectAssembliesFiles model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProjectAssembliesFiles();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ProjectAssembliesFiles model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ProjectAssembliesFiles model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProjectAssembliesFiles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProjectAssembliesFiles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProjectAssembliesFiles::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
     public function actionDownload($sygnature, $id, $fileSygnature, $extension, $fileName)
    {   
        // get all files
        $filesPathContainer = '';
        $files = ProjectAssembliesFiles::find()
                ->andFilterWhere(['and',
                 ['=','projectId',$sygnature],
                 ['=','sygnature',$fileSygnature],
                 ['=','ext', $extension],      
                 ['!=','statusId', '8']
                 ])
                ->asArray()
                ->all();
        
        // check if u have single file to download
        if(count($files) == 1){                
            return Yii::$app->response->sendFile($files[0]['path']);
        } elseif(count($files) > 1){
            foreach($files as $file){
                $filesPathContainer.= ' "'.$file['path'].'"';
            }
            $zipPath = '/media/data/app_data/project_data/' . $fileName .'.zip';
            $zipList = 'zip -j ' . $zipPath . $filesPathContainer;
//            var_dump($zipList);
//            die();
            shell_exec($zipList);
            return Yii::$app->response->sendFile($zipPath);
        }
        
        Yii::$app->session->setFlash( 'error', 'File not found.' );
        return $this->redirect( ['project/parts', 'sygnature' => $sygnature, 'id' => $id]);
        
    }
    
    public function actionDownloadzip($fileName)
    {   
            
        if(file_exists($fileName)){
            return Yii::$app->response->sendFile($fileName);
        }
 
        Yii::$app->session->setFlash( 'Server acces error, please contact system adnimistrator' );
        return $this->redirect( ['project/parts', 'sygnature' => 'a', 'id' =>'a']);

    }
    
        public function actionSendtreatment($action)
    {
           if (Yii::$app->request->isAjax) {
           $data = Yii::$app->request->post();
           $model = $this->findModel($data['id']);
           if($action == 1 & $model->destinationId != 0 & $model->statusId != 2){
              $model->statusId = $action;
           }
           if($action == 2 ){
               $model->statusId = $action;
           }
           if($action == 3 ){
               $notesCheck = ProjectAssembliesFilesNotes::find()
                                ->andWhere(['fileId' => $data['id']] )
                                ->andWhere(['typeId' => 3])
                                ->all();
                        if($notesCheck){
               $model->statusId = $action;
                        }
           }
           }
           if($model->save()){
           \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'code' => 200,
        ];
           } else {
               \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'code' => 100,
        ];
           }
    }
           
    
    public function actionPriorup()
    {
           if (Yii::$app->request->isAjax) {
           $data = Yii::$app->request->post();
           $model = $this->findModel($data['id']);
           $model->priorityId += 1;
           $model->save();
           if($model->save()){
           \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'code' => 200,
        ];
           } else {
               \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'code' => 100,
        ];
           }
    }
           
    }
    
    public function actionPriordown()
    {
           if (Yii::$app->request->isAjax) {
           $data = Yii::$app->request->post();
           $model = $this->findModel($data['id']);
           $model->priorityId -= 1;
           $model->save();
           if($model->save()){
           \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'code' => 200,
        ];
           } else {
               \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'code' => 100,
        ];
           }
    }
           
    }
    
    public function actionDesttma()
    {
           if (Yii::$app->request->isAjax) {
           $data = Yii::$app->request->post();
           $model = $this->findModel($data['id']);
           $model->destinationId = 1;
           $model->save();
           if($model->save()){
           \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'code' => 200,
        ];
           } else {
               \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'code' => 100,
        ];
           }
    }
           
    }
    
    public function actionDestout()
    {
           if (Yii::$app->request->isAjax) {
           $data = Yii::$app->request->post();
           $model = $this->findModel($data['id']);
           $model->destinationId = 2;
           $model->save();
           if($model->save()){
           \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'code' => 200,
        ];
           } else {
               \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'code' => 100,
        ];
           }
    }
           
    }
    
    public function actionMdesttma()
    {
            if (Yii::$app->request->isAjax) {
                $data = Yii::$app->request->post();
                foreach($data['id'] as $id){
           
                $model = $this->findModel($id);
                $model->destinationId = 1;
                $model->save();
                }
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'code' => 200,
            ];
    }
    }
    
     public function actionMdestout()
    {
            if (Yii::$app->request->isAjax) {
                $data = Yii::$app->request->post();
                foreach($data['id'] as $id){
           
                $model = $this->findModel($id);
                $model->destinationId = 2;
                $model->save();
                }
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'code' => 200,
            ];
    }
    }
    
     public function actionLowprio()
    {
            if (Yii::$app->request->isAjax) {
                $data = Yii::$app->request->post();
                foreach($data['id'] as $id){
           
                $model = $this->findModel($id);
                $model->priorityId = 0;
                $model->save();
                }
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'code' => 200,
            ];
    }
    }
      
     public function actionMedprio()
    {
            if (Yii::$app->request->isAjax) {
                $data = Yii::$app->request->post();
                foreach($data['id'] as $id){
           
                $model = $this->findModel($id);
                $model->priorityId = 1;
                $model->save();
                }
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'code' => 200,
            ];
    }
    }
      
    
     public function actionHighprio()
    {
            if (Yii::$app->request->isAjax) {
                $data = Yii::$app->request->post();
                foreach($data['id'] as $id){
           
                $model = $this->findModel($id);
                $model->priorityId = 2;
                $model->save();
                }
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'code' => 200,
            ];
    }
    }
     
     public function actionMtreat()
    {
            if (Yii::$app->request->isAjax) {
                $data = Yii::$app->request->post();
                foreach($data['id'] as $id){
           
                $model = $this->findModel($id);
                if($model->destinationId != 0){
                $model->statusId = 1;
                $model->save();
                }
                }
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'code' => 200,
            ];
    }
    }
    
    public function actionMassaction($action = null){
        if (Yii::$app->request->isAjax) {           
                $data = Yii::$app->request->post();
                switch ($data['action']){
                    case 'program':
                        foreach($data['id'] as $id){
                            $fileStatus = ProjectAssembliesFilesData::find()->select(['id']
                                    )->where(['fileId' => $id, 'statusId' => '1'])->one();
                            if($fileStatus){
                                $model = new ProjectAssembliesFilesData;
                                $model->isNewRecord = 1;
                                $model->fileId = $id;
                                $model->statusId = 2;
                                $model->save();
                            }
                        }
                        break;
                        case 'cnc':
                        foreach($data['id'] as $id){
                            $fileStatus = ProjectAssembliesFilesData::find()->select(['id']
                                    )->where(['fileId' => $id, 'statusId' => '1'])->one();
                            if($fileStatus){
                                $model = new ProjectAssembliesFilesData;
                                $model->isNewRecord = 1;
                                $model->fileId = $id;
                                $model->statusId = 3;
                                $model->save();
                            }
                        }
                        break;
                        case 'ct':
                        foreach($data['id'] as $id){
                            $fileStatus = ProjectAssembliesFilesData::find()->select(['id']
                                    )->where(['fileId' => $id, 'statusId' => '1'])->one();
                            if($fileStatus){
                                $model = new ProjectAssembliesFilesData;
                                $model->isNewRecord = 1;
                                $model->fileId = $id;
                                $model->statusId = 4;
                                $model->save();
                            }
                        }
                        break;
                        case 'anodizing':
                        foreach($data['id'] as $id){
                            $fileStatus = ProjectAssembliesFilesData::find()->select(['id']
                                    )->where(['fileId' => $id, 'statusId' => '1'])->one();
                            if($fileStatus){
                                $model = new ProjectAssembliesFilesData;
                                $model->isNewRecord = 1;
                                $model->fileId = $id;
                                $model->statusId = 5;
                                $model->save();
                            }
                        }
                        break;
                        case 'accept':
                        foreach($data['id'] as $id){
                                $model = new ProjectAssembliesFilesData;
                                $model->isNewRecord = 1;
                                $model->fileId = $id;
                                $model->statusId = 1;
                                $model->save();
                                
                                $model = $this->findModel($id);
                                $model->statusId = 4;
                                $model->save();
                        }
                        break;
                    case 'desttma':
                        foreach($data['id'] as $id){
                        $model = $this->findModel($id);
                            if($model->statusId == 0){                                
                                $model->destinationId = 1;
                                $model->save();
                            }
                        }
                        break;
                    case 'destout':
                        foreach($data['id'] as $id){
                        $model = $this->findModel($id);
                            if($model->statusId == 0){                                
                                $model->destinationId = 2;
                                $model->save();
                            }
                        }
                        break;
                    case 'lowprio':
                        foreach($data['id'] as $id){  
                        $model = $this->findModel($id);
                        $fileStatus = $model->statusId;
                            if($fileStatus != '3'){
                                $model->priorityId = 0;
                                $model->save();
                            }
                        }
                        break;
                    case 'normprio':
                        foreach($data['id'] as $id){   
                        $model = $this->findModel($id);
                        $fileStatus = $model->statusId;
                            if($fileStatus != '3'){
                                $model->priorityId = 1;
                                $model->save();
                            }
                        }
                        break;
                    case 'highprio':
                        foreach($data['id'] as $id){      
                        $model = $this->findModel($id);
                        $fileStatus = $model->statusId;
                            if($fileStatus != '3'){
                                $model->priorityId = 2;
                                $model->save();
                            }
                        }
                        break;
                    case 'treatfile':
                        foreach($data['id'] as $id){
                        $fileStatus = ProjectAssembliesFilesData::find()->select(['id']
                                    )->where(['fileId' => $id, 'statusId' => '1'])->one();
                            if($fileStatus){
                                $model = $this->findModel($id);

                                if($action == 1 & $model->destinationId != 0 & $model->statusId != 2){
                                    $model->statusId = $action;
                                    $model->save();

                                    $model = new ProjectAssembliesFilesData;
                                    $model->isNewRecord = 1;
                                    $model->fileId = $id;
                                    $model->statusId = 6;
                                    $model->save();
                                } elseif($action == 2 & $model->quanity == $model->quanityDone){
                                        $model->statusId = $action;
                                        $model->save();

                                        $model = new ProjectAssembliesFilesData;
                                        $model->isNewRecord = 1;
                                        $model->fileId = $id;
                                         $model->statusId = 8;
                                        $model->save();
                                }
                            }
                        }
                        break;
                        case 'sendtotreatment':
                        foreach($data['id'] as $id){
                                $model = $this->findModel($id);
                                if($model->destinationId != 0 & $model->statusId != 2 & $model->statusId != 4){
                                    $model->statusId = $action;
                                    $model->save();

                                    $model = new ProjectAssembliesFilesData;
                                    $model->isNewRecord = 1;
                                    $model->fileId = $id;
                                    $model->statusId = 6;
                                    $model->save();
                                } 
                        }
                        break;
                    case 'add':
                        foreach($data['id'] as $id){ 
                        $fileStatus = ProjectAssembliesFilesData::find()->select(['id']
                                    )->where(['fileId' => $id, 'statusId' => '1'])->one();
                            if($fileStatus){
                            $model = $this->findModel($id);
                                if($model->quanity != $model->quanityDone){
                                    $model->quanityDone+=1;
                                    $model->save();    
                                }
                            }
                        }
                        break;
                    case 'deduct':
                        foreach($data['id'] as $id){   
                        $fileStatus = ProjectAssembliesFilesData::find()->select(['id']
                                    )->where(['fileId' => $id, 'statusId' => '1'])->one();
                            if($fileStatus){
                            $model = $this->findModel($id);
                                if($model->quanityDone != 0){
                                    $model->quanityDone-=1;
                                    $model->save();    
                                }
                        }
                        }
                        break;
                        case 'rejectfile':
                        foreach($data['id'] as $id){  
                        $notesCheck = ProjectAssembliesFilesNotes::find()
                                ->andWhere(['fileId' => $id] )
                                ->andWhere(['typeId' => 3])
                                ->all();
                            $model = new ProjectAssembliesFilesData;
                            $model->isNewRecord = 1;
                            $model->fileId = $id;
                            $model->statusId = 9;
                            $model->save();
                        if($notesCheck){
                            $model = $this->findModel($id);
                            $model->statusId = 3;
                            $model->save();    
                            $model = new ProjectAssembliesFilesData;
                            $model->isNewRecord = 1;
                            $model->fileId = $id;
                            $model->statusId = 9;
                            $model->save();
                        }
                        }
                        break;
                        case 'download':
                        foreach($data['id'] as $id){                             
                            $dft = ProjectAssembliesFiles::find()
                                   ->select(['sygnature', 'name', 'assemblieId', 'projectId' ])->where(['id' => $id])->one();
                            $files= ProjectAssembliesFiles::find()->select(['path'])                            
                                    ->andWhere(['sygnature' => $dft->sygnature])
                                    ->andWhere(['assemblieId' => $dft->assemblieId])
                                    ->andFilterWhere(['or', ['ext' => 'dxf'], ['ext' => 'pdf']])
                                    ->all();
                            $fileGroup = FileGroup::find()->select(['groupId'])->where(['fileId' => $id])->asArray()->one();
                            if($fileGroup['groupId']){
                                if(isset($groupId)){
                                    if($groupId[0] == $fileGroup['groupId']){                                       
                                    } else {
                                        $groupId[] = $fileGroup['groupId'];
                                    }
                                } else {
                                $groupId[] = $fileGroup['groupId'];      
                                }
                            } else {
                                $groupId[] = 'none';
                            }
                                foreach($files as $file){
                                    $filesList[] = trim($file->path);
                                }                        
                        }
                        if(isset($groupId)){
                            if(count($groupId) > 1){
                                $fileName = 'P' . $dft['projectId'] . '_' . date("d.m.y_G:i:s") . '.zip';
                            } else {
                                $fileGroupName = FileGroupName::find()
                                                ->select(['groupName'])->where(['groupId' => $groupId[0]])->asArray()->one();
                                $fileName = 'P' . $dft['projectId'] . '_' . $fileGroupName['groupName']. '_' . date("d.m.y_G:i:s") . '.zip';
                            }
                        } else {
                            $fileName = 'P' . $dft['projectId'] . '_' . date("d.m.y_G:i:s") . '.zip';
                        }
                        if(file_exists('/media/data/app_data/project_data/' . $fileName)){
                            $file = '/media/data/app_data/project_data/' . $fileName;
                            shell_exec('rm /media/data/app_data/project_data/' . $fileName);
                        }
                        
                        $projectString = implode(' ', $filesList);
                        $zipList = 'zip -j /media/data/app_data/project_data/' . '"' . $fileName .'" ' . $projectString;
                        shell_exec($zipList);
                        //die($zipList);
                        if(file_exists('/media/data/app_data/project_data/' . $fileName)){
                            $file = '/media/data/app_data/project_data/' . $fileName;
                            //return Yii::$app->response->sendFile('/media/data/app_data/project_data/' . $fileName);
                            
                            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                            return [
                                'code' => 200,
                                'fileLink' => $file,
                            ];
                            
                        }
                            Yii::$app->session->setFlash( 'Server acces error, please contact system adnimistrator' );
                            break;
                }
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'code' => 100,
        ];
    }
    }
    
    public function actionPagination($target = null){
        if (Yii::$app->request->isAjax) {
                $data = Yii::$app->request->post();
                $data['pagination'];
                $data['sygnature'];
                $data['id'];
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if($target == 'treatmenta'){
        return $this->redirect(['project/treatmentmanagera', 
            'sygnature' => $data['sygnature'], 'id' => $data['id'], 'pagination' => $data['pagination']]);
        }
        if($target){
        return $this->redirect(['project/treatmentmanager', 
            'sygnature' => $data['sygnature'], 'id' => $data['id'], 'pagination' => $data['pagination']]);
        }
        return $this->redirect(['project/ctreatment', 
            'sygnature' => $data['sygnature'], 'id' => $data['id'], 'pagination' => $data['pagination']]);
        }
    }
    
    public function actionAdd(){
           if (Yii::$app->request->isAjax) {
           $data = Yii::$app->request->post();
           $model = $this->findModel($data['id']);
           if($model->quanity !=$model->quanityDone){
               $model->quanityDone+=1;
           } else {
               $model->quanityDone;
           }   
           if($model->save()){
           \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'code' => 200,
        ];
           } else {
               \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'code' => 100,
        ];
           }
        }
    }
           

    
    public function actionDeduct(){
           if (Yii::$app->request->isAjax) {
           $data = Yii::$app->request->post();
           $model = $this->findModel($data['id']);
           if($model->quanityDone !=0 ){
               $model->quanityDone-=1;
           } else {
               $model->quanityDone;
           }     
           if($model->save()){
           \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'code' => 200,
        ];
           } else {
               \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'code' => 100,
        ];
           }
        }
    }
    
    public function actionUpdateele($sygnature, $id){
            
             $element = ProjectAssembliesFiles::find()->where(['id' => $id, 'projectId' => $sygnature])->one();
             
             $elementsList = ProjectAssembliesFiles::find()
                     ->select(['ext', 'path', 'createdAt', 'name'])
                     ->where(['sygnature' => $element->sygnature, 'projectId' => $sygnature])
                     ->asArray()
                     ->all();
             
             $asmList = \frontend\models\ProjectAssembliesMainFiles::find()
                     ->select(['ext', 'path', 'createdAt', 'name'])
                     ->where(['assemblieId' => $element->assemblieId, 'projectId' => $sygnature, 'ext' => 'asm'])
                     ->andFilterWhere(['!=', 'statusId', 0])
                     ->asArray()
                     ->all();
             
             return $this->renderAjax('__update', [
                    'element' => $element,
                    'elementsList' => $elementsList,
                    'fileId' => $id,
                    'projectId' => $sygnature,
                    'asmList' => $asmList,
             ]);
             
        
    }
    
    public function actionUpload(){
        
        // gathering data
        $file = UploadedFile::getInstancesByName('attachment_48');
        
        if($file){
            
            $data = Yii::$app->request->post();
            $fileId = $data['fileId'];
            $projectId = $data['projectId'];
            $nameParts = explode('.', $file[0]->name);
            $fileName = $nameParts[0];
            $fileExt = $nameParts[1];

            // validating file
            $FileCheck = ProjectAssembliesFiles::find()
                    ->select(['sygnature', 'assemblieId'])
                    ->where(['id' => $fileId ])
                    ->one();
            
            $checkFile = ProjectAssembliesFiles::find()
                    ->where(['projectId' => $projectId, 'name' => $fileName, 'ext' => $fileExt])
                    ->one();
            $asmSygnature = explode('_', $fileName);
            $checkAsm = ProjectAssembliesMainFiles::find()
                        ->where(['projectId' => $projectId, 'assemblieId' => $FileCheck->assemblieId, 
                        'sygnature' => $asmSygnature[0], 'ext' => $fileExt])
                        ->one();
        
                if(!empty($checkFile)){
                    
                    if($FileCheck->sygnature == $checkFile->sygnature){  
                     

                        // clonning old file into new one
                        $fileClone = $checkFile;

                        // setting all needed data for backup purpose
                        $newFileName = 'RJ(' . date('YmdHis') . ')_' . $fileName;
                        $oldPath = $checkFile->path;
                        $oldId = $checkFile->id;
                        $newPathParts = explode('/', $oldPath); // '\\' for testing
                        $newPathParts[count($newPathParts) - 1] = $newFileName . '.' . $fileExt;
                        $newPath = implode('/', $newPathParts); // '\\' for testing
                        // check if new Id is already taken if so generating new on
                        $id = 0;
                        $newFileId = $checkFile->id . '0' . $id;
                        $idCheck = ProjectAssembliesFiles::find()
                        ->where(['id' => $newFileId ])
                        ->one();

                            while($idCheck){
                                $id++;
                                $newFileId = $checkFile->id . '0' . $id;

                                $idCheck = ProjectAssembliesFiles::find()
                                ->where(['id' => $newFileId ])
                                ->one();
                            }
                            
                            
                        // backuping file
                        rename($oldPath, $newPath);
                        $checkFile->name = $newFileName;
                        $checkFile->path = $newPath;
                        $checkFile->id = $newFileId;
                        $checkFile->updatedAt = date('Y-m-d H:i:s');
                        $checkFile->statusId = 8;

                            if($checkFile->save()){
                                // passing all attributes from old to new file
                                move_uploaded_file($file[0]->tempName, $oldPath);
                                $fileClone->isNewRecord = true;
                                $fileClone->id = $oldId;
                                $fileClone->name = $fileName;
                                $fileClone->path = $oldPath;
                                $fileClone->updatedAt = date('Y-m-d H:i:s');
                                $fileClone->statusId = 0;

                                $fileClone->save();

                                // whole package status
                                $statusChange = new ProjectAssembliesFiles;
                                $statusChange->find()
                                ->where(['id' => $fileId ])
                                ->one();
                                $statusChange->statusId = '0';
                                $statusChange->save();


                                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                                return [
                                    'code' => 200,
                                    'name' => $file[0]->name,
                                ];
                            }
                    }
                }
                
                if(!empty($checkAsm)){
                    // clonning old file into new one
                        $fileClone = $checkAsm;

                        // setting all needed data for backup purpose
                        $newFileName = 'RJ(' . date('YmdHis') . ')_' . $fileName;
                        $oldPath = $checkAsm->path;
                        $oldId = $checkAsm->id;
                        $oldFileName = $checkAsm->name;
                        $newPathParts = explode('/', $oldPath); // '\\' for testing
                        $newPathParts[count($newPathParts) - 1] = $newFileName . '.' . $fileExt;
                        $newPath = implode('/', $newPathParts); // '\\' for testing
                        // check if new Id is already taken if so generating new on
                        $id = 0;
                        $newFileId = $checkAsm->id . '0' . $id;
                        $idCheck = ProjectAssembliesMainFiles::find()
                        ->where(['id' => $newFileId ])
                        ->one();

                            while($idCheck){
                                $id++;
                                $newFileId = $checkAsm->id . '0' . $id;

                                $idCheck = ProjectAssembliesFiles::find()
                                ->where(['id' => $newFileId ])
                                ->one();
                            }
                            
                        // backuping file
                        rename($oldPath, $newPath);
                        $checkAsm->name = $newFileName;
                        $checkAsm->path = $newPath;
                        $checkAsm->id = $newFileId;
                        $checkAsm->statusId = 0;
                        $checkAsm->updatedAt = date('Y-m-d H:i:s');
                    
                        if($checkAsm->save()){
                                // passing all attributes from old to new file
                                move_uploaded_file($file[0]->tempName, $oldPath);
                                $fileClone->isNewRecord = true;
                                $fileClone->id = $oldId;
                                $fileClone->name = $oldFileName;
                                $fileClone->path = $oldPath;
                                $fileClone->statusId = 1;
                                $fileClone->updatedAt = date('Y-m-d H:i:s');

                                $fileClone->save();

                                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                                return [
                                    'code' => 200,
                                    'name' => $file[0]->name,
                                ];
                            }
                }

           \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
           return [
                  'code' => 100,
                  ];     
        }
        
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
           return [
                  'code' => 100,
                  ];  
    }
   
}
