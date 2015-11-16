<?php

namespace frontend\controllers;

use Yii;
use frontend\models\ProjectAssembliesFilesNotes;
use frontend\models\ProjectAssembliesFilesData;
use frontend\models\search\ProjectAssembliesFilesNotesSearch;
use frontend\models\ProjectAssembliesFiles;
use frontend\models\ProjectData;
use frontend\models\ProjectAssembliesFilesNotesLabels;
use common\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProjectAssembliesFilesNotesController implements the CRUD actions for ProjectAssembliesFilesNotes model.
 */
class ProjectAssembliesFilesNotesController extends Controller
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
     * Lists all ProjectAssembliesFilesNotes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProjectAssembliesFilesNotesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProjectAssembliesFilesNotes model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id, $filter = null)
    {   
         $searchModel = new ProjectAssembliesFilesNotesSearch;
         $searchModel->fileId = $id;
         $dataProvider = $searchModel->search( Yii::$app->request->queryParams, $filter);
         $notesNumber = ProjectAssembliesFilesNotes::find()->select(['id'])->all();
         $pages = count($notesNumber);
         $dataProvider->pagination->pagesize = $pages;
                            return Yii::$app->controller->renderAjax( 'view', [
                                        'searchModel' => $searchModel,
                                        'dataProvider' => $dataProvider,
                                    ] );
    }
    /**
     * Creates a new ProjectAssembliesFilesNotes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProjectAssembliesFilesNotes();
        
        if ($data = $model->load(Yii::$app->request->post()) && $data['note-me'] == 'save-note' && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ProjectAssembliesFilesNotes model.
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
     * Deletes an existing ProjectAssembliesFilesNotes model.
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
     * Finds the ProjectAssembliesFilesNotes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProjectAssembliesFilesNotes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProjectAssembliesFilesNotes::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionNote($id, $filter = null, $data = null)
    {
        $model = new ProjectAssembliesFilesNotes();
   
        if ($model->load(Yii::$app->request->post())) {
            
                $findNote = ProjectAssembliesFilesNotes::find()
                    ->where(['statusId' => 0, 'fileId' => $id])
                    ->andFilterWhere(['or', 
                    ['typeId' => 0],
                    ['typeId' => 3], 
                            ])
                    ->one(); 

                while($findNote){
                    $findNote->statusId = 1;
                    $findNote->save();

                    $findNote = ProjectAssembliesFilesNotes::find()
                            ->where(['statusId' => 0, 'fileId' => $id])
                            ->andFilterWhere(['or', 
                            ['typeId' => 0],
                            ['typeId' => 3], 
                                    ])
                            ->one(); 
                }

                $model->fileId = intval($id);
                if(!empty(Yii::$app->request->post('noteMe'))){
                        $model->save();   
                        
                        $fileData = ProjectAssembliesFiles::find()->where(['id' => $id])->one();
                        $noteData = ProjectAssembliesFilesNotes::find()->where(['fileId' => $id])->one();
                        $userData = User::find()->select(['role_id', 'username'])->where(['id' => $noteData->creUserId])->one();
                        $projectData = ProjectData::find()->select(['id', 'sygnature'])->where(['sygnature' => $fileData->projectId])->one();
                        
                        if($userData->role_id == 8) {
                            
                            $constructorsMails = User::find()->select(['email'])->where(['role_id' => 2])->asArray()->all();
                                
                            $link = 'https://pm.tma-automation.com/index.php?ProjectAssembliesFilesSearch[name]=' . $fileData->name . '&ProjectAssembliesFilesSearch[assemblie.name]=&ProjectAssembliesFilesSearch[type.name]=&ProjectAssembliesFilesSearch[material]=&ProjectAssembliesFilesSearch[thickness]=&ProjectAssembliesFilesSearch[status.statusName]=&ProjectAssembliesFilesSearch[destination.destination]=&ProjectAssembliesFilesSearch[priority.name]=&r=project%2Fctreatment&sygnature='. $projectData->sygnature .'&id='. $fileData->projectId .'0&_pjax=%23pjax-data';
                                foreach($constructorsMails as $mail){                                
                                    Yii::$app->mailer->compose(
                                             ['html' => 'note-html', 'text' => 'note-text'],
                                             ['fileData' => $fileData, 'noteData'=> $noteData, 'userData' => $userData, 'link' => $link])
                                     ->setFrom('pm@tma-automation.com')
                                     ->setTo($mail['email'])
                                     ->setSubject('New comment for element: ' . $fileData->name)
                                     ->send();
                                }
                                
                                
                        }
                        
                        if($userData->role_id == 2) {
                        $treatmentMails = User::find()->select(['email'])->where(['role_id' => 8])->asArray()->all();
                        
                        if($fileData->statusId == 6){
                            
                            $link = "https://pm.tma-automation.com/index.php?ProjectAssembliesFilesSearch[date]=&ProjectAssembliesFilesSearch[name]=$fileData->name&ProjectAssembliesFilesSearch[material]=&ProjectAssembliesFilesSearch[thickness]=&ProjectAssembliesFilesSearch[Programming]=&ProjectAssembliesFilesSearch[CNC]=&ProjectAssembliesFilesSearch[ConvTreat]=&ProjectAssembliesFilesSearch[Anodizing]=&ProjectAssembliesFilesSearch[priority.name]=&r=project%2Ftreatmentmanager&sygnature=$projectData->sygnature&id=$fileData->projectId";
                            
                        } elseif($fileData->statusId == 1 || $fileData->statusId == 2 || $fileData->statusId == 3 || $fileData->statusId == 4 || $fileData->statusId == 5) {
                            $link = "https://pm.tma-automation.com/index.php?ProjectAssembliesFilesSearch[filegroup.groupName]=&ProjectAssembliesFilesSearch[name]=$fileData->name&ProjectAssembliesFilesSearch[material]=&ProjectAssembliesFilesSearch[thickness]=&ProjectAssembliesFilesSearch[Programming]=&ProjectAssembliesFilesSearch[CNC]=&ProjectAssembliesFilesSearch[ConvTreat]=&ProjectAssembliesFilesSearch[Anodizing]=&ProjectAssembliesFilesSearch[priority.name]=&r=project%2Ftreatmentmanagera&sygnature=$projectData->sygnature&id=$fileData->projectId"; 
                        }
                       
                        if($link){
                            foreach($treatmentMails as $mail){                                
                                    Yii::$app->mailer->compose(
                                             ['html' => 'note-html', 'text' => 'note-text'],
                                             ['fileData' => $fileData, 'noteData'=> $noteData, 'userData' => $userData, 'link' => $link])
                                     ->setFrom('pm@tma-automation.com')
                                     ->setTo($mail['email'])
                                     ->setSubject('New comment for element: ' . $fileData->name)
                                     ->send();
                                }
                            }
                        }
                    }
                    
                return;
            
        }

    $order = ['defaultOrder' => ['creTime' => SORT_DESC]];   
    $searchModel = new ProjectAssembliesFilesNotesSearch;
    $searchModel->fileId = $id;
    $dataProvider = $searchModel->search( Yii::$app->request->queryParams, $filter, $order);
    $notesNumber = ProjectAssembliesFilesNotes::find()->select(['id'])->all();
    
    $pages = count($notesNumber);
    $dataProvider->pagination->pagesize = $pages;   
    
        if($data == 'treatment'){
        
        $noteLabel = new ProjectAssembliesFilesNotesLabels();
            return $this->renderAjax( '__note', [
                            'model' => $model,
                            'projectId' => $id,
                            'searchModel' => $searchModel,
                            'dataProvider' => $dataProvider,
                            'option' => $data,
                            'noteLabel' => $noteLabel,
                ] );
        }
        
    return $this->renderAjax( '__note', [
                        'model' => $model,
                        'projectId' => $id,
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ] );
     
    }
    
    public function actionPrivnote($id, $filter = null)
    {
        $model = new ProjectAssembliesFilesNotes();
        
        if ($model->load(Yii::$app->request->post())) {
                $model->fileId = intval($id);
                    if(!empty(Yii::$app->request->post('noteMe'))){
                        $model->save();
                    }
                    
                return;
        }

    $order = ['defaultOrder' => ['creTime' => SORT_DESC]];   
    $searchModel = new ProjectAssembliesFilesNotesSearch;
    $searchModel->fileId = $id;
    $dataProvider = $searchModel->search( Yii::$app->request->queryParams, $filter, $order);
    $notesNumber = ProjectAssembliesFilesNotes::find()->select(['id'])->all();
    
    $pages = count($notesNumber);
    $dataProvider->pagination->pagesize = $pages;   
    
    return $this->renderAjax( '__note', [
                        'model' => $model,
                        'projectId' => $id,
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'privnote' => true,
            ] );
     
    }

    public function actionTnote($id)
    {
    $model = new ProjectAssembliesFilesNotes();
    if ($model->load(Yii::$app->request->post())) {
        
        $model->fileId = intval($id);
        
     if ( $model->save() )
            {
            }
        } else
        {
            
            return $this->renderAjax( '__notet', [
                        'model' => $model,
                        'projectId' => $id,
            ] );
        }
    
    }   

    public function actionRnote($id)
    {   
        $model = new ProjectAssembliesFilesNotes();
        if ($model->load(Yii::$app->request->post())) {

            $model->fileId = intval($id);

            if ( $model->save() ){
                
               $file = ProjectAssembliesFiles::find()->where(['id' => $id])->one();
               $file->statusId = 9;
               $file->save();
               
               $model = new ProjectAssembliesFilesData;
               $model->isNewRecord = 1;
               $model->fileId = $id;
               $model->statusId = 9;
               $model->save();
            }
            
        } else{

                return $this->renderAjax( '__notet', [
                            'model' => $model,
                            'projectId' => $id,
                ] );
        }
    
    }
    
     public function actionStopnote($id)
    {   
        $model = new ProjectAssembliesFilesNotes();
        if ($model->load(Yii::$app->request->post())) {

            $model->fileId = intval($id);
            
            $file = ProjectAssembliesFiles::find()->where(['id' => $id])->one();
            if($file->statusId < 9 || $file->statusId == 12) {
                if ( $model->save() ){


                   $file->statusId = 11; // stopped
                   $file->save();

                   $model = new ProjectAssembliesFilesData;
                   $model->isNewRecord = 1;
                   $model->fileId = $id;
                   $model->statusId = 11; // stopped
                   $model->save();
                }
            }
            
        } else {

                return $this->renderAjax( '__notes', [
                            'model' => $model,
                ] );
        }
    
    }
}
