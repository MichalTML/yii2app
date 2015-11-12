<?php

namespace frontend\controllers;

use Yii;
use frontend\models\ProjectAssembliesFilesNotes;
use frontend\models\search\ProjectAssembliesFilesNotesSearch;
use frontend\models\ProjectAssembliesFiles;
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
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
            $model->save();
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
            return $this->renderAjax( '__note', [
                            'model' => $model,
                            'projectId' => $id,
                            'searchModel' => $searchModel,
                            'dataProvider' => $dataProvider,
                            'option' => $data,
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
            $model->save();
            
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
        
     if ( $model->save() )
            {
     $file = ProjectAssembliesFiles::find()->where(['id' => $id])->one();
     $file->statusId = 3;
     $file->save();
            }
        } else
        {
            
            return $this->renderAjax( '__notet', [
                        'model' => $model,
                        'projectId' => $id,
            ] );
        }
    
    }
}
