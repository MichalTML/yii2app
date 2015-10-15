<?php

namespace frontend\controllers;

use Yii;
use frontend\models\ProjectAssembliesFilesNotes;
use frontend\models\search\ProjectAssembliesFilesNotesSearch;
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
    public function actionView($id)
    {
         $searchModel = new ProjectAssembliesFilesNotesSearch();
         $searchModel->fileId = $id;
         $dataProvider = $searchModel->search( Yii::$app->request->queryParams );
         $dataProvider->pagination->pageSize = 5;
                            return Yii::$app->controller->renderPartial( 'view', [
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
    
    public function actionNote($id)
{
    $model = new ProjectAssembliesFilesNotes();
    if ($model->load(Yii::$app->request->post())) {
        
        $model->fileId = intval($id);
        
     if ( $model->save() )
            {
            }
        } else
        {
            
            return $this->renderAjax( '__note', [
                        'model' => $model,
                        'projectId' => $id,
            ] );
        }
    
}

    public function actionNotet($id)
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
}
