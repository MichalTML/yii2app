<?php

namespace frontend\controllers;

use Yii;
use frontend\models\ProjectData;
use frontend\models\search\ProjectSearch;
use frontend\models\ProjectPermissions;
use frontend\models\search\ProjectPermissionsSearch;
use common\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

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
        $searchModel = new ProjectSearch();
        $dataProvider = $searchModel->search( Yii::$app->request->queryParams );      
        


        return $this->render( 'index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,                    
                ] );
        
        
    }

    /**
     * Displays a single ProjectData model.
     * @param integer $id
     * @return mixed
     */
    public function actionView( $id ) {

        return $this->render( 'view', [
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

        $model = new ProjectData();
        $projectPermissions = new ProjectPermissions();

        if ( $model->load( Yii::$app->request->post() ) && $model->save() ) {

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
            $model->setProjectName( $model->id, $model->projectName );
            return $this->redirect( ['index' ] );
        } else {
            return $this->render( 'create', [
                        'model' => $model,
                        'projectPermissions' => $projectPermissions,
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
        $model = $this->findModel( $id );
        $projectName = preg_replace( '/.*_/', '', $model->projectName );
        $model->projectName = $projectName;
        $projectPermissions = new ProjectPermissions();


        if ( $model->load( Yii::$app->request->post() ) && $model->save() ) {

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
        } else {

            return $this->render( 'update', [
                        'model' => $model,
                        'projectPermissions' => $projectPermissions,
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
        $model = $this->findModel( $id );
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

    /**
     * Update User function with ProjectStatus
     * @param string $firstlastName string grabbed from post, name of construsctor
     * check if Project Status already exists if N then add it
     */
    //protected function updateUserProjectStatus( $userName, $projectId ) {
    //$user = User::find()->where( ['firstlastName' => $userName ] )->one();
    //$projectList = explode('|', $user->projectStatus);
    //if(!in_array( $projectId, $projectList ) ){  
    // $user->projectStatus.= '|' . $projectId;
    // $user->projectStatus = trim($user->projectStatus, '|');      
    // $user->save();        
    // } 
    // }
    // protected function deleteUserProjectStatus( $projectId ) {
    //$users = User::find()->where( ['role_id' => 1 ] )->all();
    // foreach ( $users as $user ) {
    //  $projectList = explode( '|', $user->projectStatus );
    //  if ( array_search( $projectId, $projectList ) !== false ) {
    //    $idToDelte = array_search( $projectId, $projectList );
    //     unset( $projectList[ $idToDelte ] );
//            var_dump($projectList);
//            die();
    //$updatedProjectList = implode( '|', $projectList );
    //$updatedProjectList = trim( $updatedProjectList, '|' );
    // $user->projectStatus = $updatedProjectList;
    // $user->save();
    //  }
    //  }
    //}
}
