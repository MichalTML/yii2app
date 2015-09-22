<?php

namespace frontend\controllers;

use Yii;
use frontend\models\ProjectAssembliesFiles;
use frontend\models\search\ProjectAssembliesFilesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
        return $this->renderPartial('view', [
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
    
        public function actionSendtreatment()
    {
           if (Yii::$app->request->isAjax) {
           $data = Yii::$app->request->post();
           $model = $this->findModel($data['id']);
           $model->statusId = 1;
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
          
}
