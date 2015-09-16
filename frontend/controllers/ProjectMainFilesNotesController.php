<?php

namespace frontend\controllers;

use Yii;
use frontend\models\ProjectMainFilesNotes;
use frontend\models\search\ProjectMainFilesNotesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProjectMainFilesNotesController implements the CRUD actions for ProjectMainFilesNotes model.
 */
class ProjectMainFilesNotesController extends Controller
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
     * Lists all ProjectMainFilesNotes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProjectMainFilesNotesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProjectMainFilesNotes model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
         $searchModel = new ProjectMainFilesNotesSearch();
         $searchModel->fileId = $id;
         $dataProvider = $searchModel->search( Yii::$app->request->queryParams );
         $dataProvider->pagination->pageSize = 5;
                            return Yii::$app->controller->renderPartial( 'view', [
                                        'searchModel' => $searchModel,
                                        'dataProvider' => $dataProvider,
                                    ] );
    }

    /**
     * Creates a new ProjectMainFilesNotes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProjectMainFilesNotes();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ProjectMainFilesNotes model.
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
     * Deletes an existing ProjectMainFilesNotes model.
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
     * Finds the ProjectMainFilesNotes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProjectMainFilesNotes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProjectMainFilesNotes::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionNote($id)
{
    $model = new ProjectMainFilesNotes();
    if ($model->load(Yii::$app->request->post())) {
        
        $model->fileId = intval($id);
        
        
     if ( $model->save() )
            {
                 //Yii::$app->end();
            }
        } else
        {
            
            return $this->renderAjax( '__note', [
                        'model' => $model,
                        'projectId' => $id,
            ] );
        }
    
}

}
