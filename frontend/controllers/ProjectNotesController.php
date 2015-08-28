<?php

namespace frontend\controllers;

use Yii;
use frontend\models\ProjectNotes;
use frontend\models\search\ProjectNotesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProjectNotesController implements the CRUD actions for ProjectNotes model.
 */
class ProjectNotesController extends Controller
{

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
     * Lists all ProjectNotes models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ProjectNotesSearch();
        $dataProvider = $searchModel->search( Yii::$app->request->queryParams );

        return $this->render( 'index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ] );
    }

    /**
     * Displays a single ProjectNotes model.
     * @param integer $id
     * @param integer $projectId
     * @return mixed
     */
    public function actionView( $id, $projectId ) {
        return $this->render( 'view', [
                    'model' => $this->findModel( $id, $projectId ),
        ] );
    }

    /**
     * Creates a new ProjectNotes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new ProjectNotes();

        if ( $model->load( Yii::$app->request->post() ) && $model->save() )
        {
            return $this->redirect( ['view', 'id' => $model->id, 'projectId' => $model->projectId ] );
        } else
        {
            return $this->render( 'create', [
                        'model' => $model,
            ] );
        }
    }

    /**
     * Updates an existing ProjectNotes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $projectId
     * @return mixed
     */
    public function actionUpdate( $id, $projectId ) {
        $model = $this->findModel( $id, $projectId );

        if ( $model->load( Yii::$app->request->post() ) && $model->save() )
        {
            return $this->redirect( ['view', 'id' => $model->id, 'projectId' => $model->projectId ] );
        } else
        {
            return $this->render( 'update', [
                        'model' => $model,
            ] );
        }
    }

    /**
     * Deletes an existing ProjectNotes model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $projectId
     * @return mixed
     */
    public function actionDelete( $id, $projectId ) {
        $this->findModel( $id, $projectId )->delete();

        return $this->redirect( ['index' ] );
    }

    /**
     * Finds the ProjectNotes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $projectId
     * @return ProjectNotes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel( $id, $projectId ) {
        if ( ($model = ProjectNotes::findOne( ['id' => $id, 'projectId' => $projectId ] )) !== null )
        {
            return $model;
        } else
        {
            throw new NotFoundHttpException( 'The requested page does not exist.' );
        }
    }

    public function actionNote( $id ) {
        $model = new ProjectNotes();

        if ( $model->load( Yii::$app->request->post() ) )
        {
            $model->projectId = intval($id);
            
            if ( $model->save() )
            {
                 return $this->redirect( ['project/index' ] );
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
