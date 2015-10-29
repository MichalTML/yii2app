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
    
     public function actionDownload($path, $name, $sygnature, $id)
    {   
        if(file_exists($path)){
            //die('adasd');
        return Yii::$app->response->sendFile($path);
        }
        Yii::$app->session->setFlash( 'error', 'File: ' . $name . ' not found.' );
        return $this->redirect( ['project/parts', 'sygnature' => $sygnature, 'id' => $id]);
        
    }
    
    public function actionDownloadzip()
    {   
        if(file_exists('/media/data/app_data/project_data/temp.zip')){
            //die('adasd');
        return Yii::$app->response->sendFile('/media/data/app_data/project_data/temp.zip');
        }
        return Yii::$app->session->setFlash( 'Server acces error, please contact system adnimistrator' );

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
                            $dft = ProjectAssembliesFiles::find()->select(['name', 'assemblieId' ])->where(['id' => $id])->one();
                            $files= ProjectAssembliesFiles::find()->select(['path'])
                                    ->andWhere(['name' => $dft->name])
                                    ->andWhere( ['assemblieId' => $dft->assemblieId])
                                    ->andFilterWhere(['or', ['ext' => 'dxf'], ['ext' => 'pdf']])
                                    ->all();
                                foreach($files as $file){
                                    $filesList[] = trim($file->path);
                                }                        
                        }
                        
                        if(file_exists('/media/data/app_data/project_data/temp.zip')){
                            $file = '/media/data/app_data/project_data/temp.zip';
                            shell_exec('rm /media/data/app_data/project_data/temp.zip');
                        }
                        $projectString = implode(' ', $filesList);
                        $zipList = 'zip -j /media/data/app_data/project_data/temp.zip '.$projectString;
                        shell_exec($zipList);
                        if(file_exists('/media/data/app_data/project_data/temp.zip')){
                            $file = '/media/data/app_data/project_data/temp.zip';
                            return Yii::$app->response->sendFile('/media/data/app_data/project_data/temp.zip');
                        }
                            Yii::$app->session->setFlash( 'Server acces error, please contact system adnimistrator' );
                            break;
                }
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'code' => 200,
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
    
}
