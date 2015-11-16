<?php

namespace frontend\controllers;

use Yii;
use frontend\models\ProjectData;
use frontend\models\search\ProjectSearch;
use frontend\models\ProjectPermissions;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\search\ProjectFileDataSearch;
use frontend\models\search\ProjectAssembliesDataSearch;
use frontend\models\search\ProjectAssembliesFilesSearch;
use frontend\models\ProjectFileData;
use frontend\models\FilesImages;
use frontend\models\ProjectAssembliesFiles;

/**
 * ProjectController implements the CRUD actions for ProjectData model.
 */
class ProjectController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post' ],
                ],
            ],
        ];
    }

    /**
     * Lists all ProjectData models.
     * @return mixed
     */
    public function actionIndex() {       

        $this->layout = 'action';
        $searchModel = new ProjectSearch();
        $order = ['defaultOrder' => ['sygnature' => 'DESC']];        
        $dataProvider = $searchModel->search( Yii::$app->request->queryParams, $order);
        return $this->render( 'index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,     
                ] );      
    }
    
    public function actionListme() {
        $filter = 'active';
        $searchModel = new ProjectSearch();
        $order = ['defaultOrder' => ['projectStatus0.statusName' => SORT_ASC, 'sygnature' => SORT_DESC]];        
        $dataProvider = $searchModel->search( Yii::$app->request->queryParams, $order, $filter);
        return $this->renderAjax( 'project-list', [
                    'projectSearch' => $searchModel,
                    'projectData' => $dataProvider,     
                ] );  
    }

    /**
     * Displays a single ProjectData model.
     * @param integer $id
     * @return mixed
     */
    public function actionView( $id ) {
        return $this->renderPartial( 'view', [
                    'model' => $this->findModel( $id ),
                    'id' => $id,
                ] );
    }
    
    public function actionCview( $id ) {
        $this->layout = 'action';
        return $this->renderPartial( 'cview', [
                    'model' => $this->findModel( $id ),
                ] );
    }
    /**
     * Creates a new ProjectData model.
     * Instert into Project_Permission id and userId and setting default permissions
     * to view 1 delete 0 update 0 edit 0
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $this->layout = 'action';
        $model = new ProjectData();
        $projectPermissions = new ProjectPermissions();
        $lastId = $model->find()->select('sygnature')->orderBy(['sygnature' => SORT_DESC])->one();
        if(isset($lastId->sygnature)){
            $freeId = $lastId->sygnature + 1;
        } else {
            $freeId = 1;
        }     
        if ( $model->load( Yii::$app->request->post() )) {
            $weeks = $model->deadline;
            $days = $weeks * 7;
            $date = $model->projectStart;
            $deadline = date("Y-m-d", strtotime("+".$days." days", strtotime($date)));
            $model->deadline = $deadline;
            if($model->save()){
                $projectId = $model->id;                
                if ( $projectPermissions->load( Yii::$app->request->post() ) ) {
                    $userIds = $projectPermissions->userId;
                    foreach ( $userIds as $userId ) {
                        $projectPermissions->userId = intval( $userId );
                        $projectPermissions->projectId = $projectId;
                        if ( $projectPermissions->checkPermissionsExists( $projectId, $userId ) ) {
                            $projectPermissions->isNewRecord = true;
                            $projectPermissions->id = null;
                            $projectPermissions->save();
                        }
                    }
                }
                $model->setProjectName( $model->sygnature, $model->projectName );
                return $this->redirect( ['index' ] );
            }
        } else {
            return $this->render( 'create', [
                        'model' => $model,
                        'projectPermissions' => $projectPermissions,
                        'freeId' => $freeId,
                        'projectStatus' => 3,
                    ] );
        }
    }

    /**
     * Updates an existing ProjectData model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate( $id ) {
        $this->layout = 'action';
        $model = $this->findModel( $id );
        $projectName = preg_replace( '/.*_/', '', $model->projectName );
        $model->projectName = $projectName;
        $projectPermissions = new ProjectPermissions();
        //$lastId = $model->find()->select('sygnature')->orderBy(['sygnature' => SORT_DESC])->one();
        $freeId = $model->sygnature;
            if ( $model->load( Yii::$app->request->post() )){
                    $weeks = $model->deadline;
                    $days = $weeks * 7;
                    $date = $model->projectStart;
                    $deadline = date("Y-m-d", strtotime("+".$days." days", strtotime($date)));
                    $model->deadline = $deadline;
                    if($model->save() ) {
                        if ( $projectPermissions->load( Yii::$app->request->post() ) ) {
                            $projectPermissions->deleteAll( 'projectId ="' . $id . '"' );
                            $userIds = $projectPermissions->userId;
                            foreach ( $userIds as $user ) {
                                $projectPermissions->userId = intval( $user );
                                $projectPermissions->projectId = $id;
                                $projectPermissions->isNewRecord = true;
                                $projectPermissions->id = null;
                                $projectPermissions->save();
                            }
                        }
                            $model->setProjectName( $model->id, $model->projectName );    
                            return $this->redirect( ['index' ] );
                    }
                        } else {
                            return $this->render( 'update', [
                                        'model' => $model,
                                        'projectPermissions' => $projectPermissions,
                                        'freeId' => $freeId,
                                    ] );
                        }
           }

                
    

    /**
     * Deletes an existing ProjectData model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete( $id ) {
        $this->findModel( $id )->delete();
        //$this->deleteUserProjectStatus( $model->id );
        return $this->redirect( ['index' ] );
    }

    /**
     * Finds the ProjectData model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProjectData the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel( $id ) {
        if ( ($model = ProjectData::findOne( $id )) !== null ) {
            return $model;
        } else {
            throw new NotFoundHttpException( 'The requested page does not exist.' );
        }
    }
    
   public function actionNotes($id) {
        $project = User::findOne($id);
        return $this->render('__detailView', [
            'project' => $project,
        ]);
    }
    
    public function actionParts($sygnature, $id){
        $this->layout = 'action';
        $searchProject = $this->findModel($id);
        $searchModel = new ProjectFileDataSearch();        
        $searchAssemblies = new ProjectAssembliesDataSearch();                
        $dataProvider = $searchModel->search( Yii::$app->request->queryParams, $sygnature );
        $assemliesData = $searchAssemblies->search( Yii::$app->request->queryParams, $sygnature );              
         return $this->render( 'files', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,  
                    'project' => $searchProject,
                    'assemblieData' => $assemliesData,
                    'id' => $id,
                    'sygnature' => $sygnature,
                ] );
    }
    
    public function actionCparts($sygnature, $id){
        $this->layout = 'action';
        $searchProject = $this->findModel($id);
        $searchModel = new ProjectFileDataSearch();        
        $searchAssemblies = new ProjectAssembliesDataSearch();                
        $dataProvider = $searchModel->search( Yii::$app->request->queryParams, $sygnature );
        $assemliesData = $searchAssemblies->search( Yii::$app->request->queryParams, $sygnature );              
        return $this->render( 'cfiles', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,  
                    'project' => $searchProject,
                    'assemblieData' => $assemliesData,
                    'id' => $id,
                    'sygnature' => $sygnature,
                ] );
    }
    
    public function actionCtreatment($sygnature, $id, $pagination = 20, $elementName = null){   
        if(Yii::$app->user->isGuest){
            return $this->redirect(['site/login']);
        }
        $assemblieFiles = ProjectAssembliesFiles::find()->select(['id', 'path', 'name'])->asArray()->where(['and', ['projectId' => $sygnature, 'ext' => 'pdf']])->all();
 
        if($assemblieFiles){
           foreach($assemblieFiles as $file => $ids){
               
               $assemblieFilesImages = FilesImages::find()->select(['imagePath'])->where(['fileId' => $ids['id']])->one();    
               if(!$assemblieFilesImages){
                $serverpath = '/var/www/yii2app/frontend/web/images/files_images/P_' . $sygnature . '/';
                $ids['name'] = substr($ids['name'], 0, 15);
                $imagePath = $serverpath.$ids['name'] . '.jpg';
                $viewImagePath = '/images/files_images/P_' . $sygnature . '/'.$ids['name'] . '.jpg';
                
                exec('mkdir -p ' . $serverpath);
                exec('convert "' . $ids['path'].'"[0]'. ' "' . $imagePath.'"', $output, $return);
                    if (!$return) {
                        $fileImage = new FilesImages;
                        $fileImage->isNewRecord = true;
                        $fileImage->fileId = $ids['id'];
                        $fileImage->imagePath = $viewImagePath;
                        $fileImage->save(); 
                    }

               }
           } 
          
        }
        $this->layout = 'action';        
        $searchModel = new ProjectAssembliesFilesSearch();
        $dataProvider = $searchModel->search( Yii::$app->request->queryParams, $sygnature, 'tindex');
        $dataProvider->pagination->pageSize = $pagination;
        return $this->render( 'cassembliesFiles',
                            [
                               'searchModel' => $searchModel,
                               'dataProvider' => $dataProvider,
                               'id' => $id,
                               'sygnature' => $sygnature,
                            ] 
                            );
    }

     public function actionUpload(){ // getting project list for upload
         $path = '/media/data/app_data/project_data/';
         $projects = [];
         $prjectScan = new \FilesystemIterator($path);
         foreach($prjectScan as $project){
             $projects[] = $project->getFilename();
         }
         $this->layout = 'menu';
         return $this->render( 'upload', [
             'project' => $projects,
         ]);
     }
     
     public function actionFileindex(){ // constructuros INDEX
        $this->layout = 'action';
        $searchModel = new ProjectSearch();
        $order = ['defaultOrder' => ['sygnature' => 'DESC']];
        $filter = 'active';
        $dataProvider = $searchModel->search( Yii::$app->request->queryParams, $order, $filter );      
        return $this->render( 'fileindex', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,     
                ] );
    }
    
    public function actionFileindexc(){ // constructuros INDEX
        $this->layout = 'action';
        $searchModel = new ProjectSearch();
        $order = ['defaultOrder' => ['sygnature' => 'DESC']];
        $filter = 'completed';
        $dataProvider = $searchModel->search( Yii::$app->request->queryParams, $order, $filter );      
        return $this->render( 'fileindexc', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,     
                ] );
    }
    
    public function actionTreatmentindex(){ // treatment index
        $projectList = new ProjectFileData;
        $projectSygs = $projectList->find()->asArray()->select(['projectId'])->all();
        foreach($projectSygs as $project){
            $filter[] = $project['projectId'];
        }
        if(!isset($filter)){
            $filter = [0 => 0];
        }
        $this->layout = 'action';
        $searchModel = new ProjectSearch();
        $order = ['defaultOrder' => ['sygnature' => 'DESC']];
        $dataProvider = $searchModel->search( Yii::$app->request->queryParams, $order, $filter);
        return $this->render( 'treatmentindex', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,     
                ] ); 
    }
    
    public function actionTreatmentmanager($sygnature, $id, $pagination = 20){
        $this->layout = 'action';        
        $searchModel = new ProjectAssembliesFilesSearch();
        $order = ['defaultOrder' => ['date' => 'DESC', 'priorityId' => 'DESC']];
        $dataProvider = $searchModel->search( Yii::$app->request->queryParams, $sygnature, 'treatmanager-pending', $order);
        $dataProvider->pagination->pageSize = $pagination;
        return $this->render( 'treatmentfiles',
                            [
                               'searchModel' => $searchModel,
                               'dataProvider' => $dataProvider,
                               'id' => $id,
                               'sygnature' => $sygnature,
                            ] 
                            );
    }
    
    public function actionTreatmentmanagera($sygnature, $id, $pagination = 20){
       
        $this->layout = 'action';        
        $searchModel = new ProjectAssembliesFilesSearch();
        $order = ['defaultOrder' => ['priorityId' => 'DESC', 'name' => 'DESC']];
        $dataProvider = $searchModel->search( Yii::$app->request->queryParams, $sygnature, 'treatmanager-accepted', $order);
        $dataProvider->pagination->pageSize = $pagination;
        return $this->render( 'treatmentfilesa',
                            [
                               'searchModel' => $searchModel,
                               'dataProvider' => $dataProvider,
                               'id' => $id,
                               'sygnature' => $sygnature,
                            ] 
                            );
    }
}
