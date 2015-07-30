<?php

namespace frontend\controllers;

use Yii;
use frontend\models\ClientData;
use frontend\models\search\ClientSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ClientController implements the CRUD actions for ClientData model.
 */
class ClientController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'addContact' => ['#'],
                ],
            ],
        ];
    }

    /**
     * Lists all ClientData models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'action';
        $searchModel = new ClientSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ClientData model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->layout = 'action';
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ClientData model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'action';
        $model = new ClientData();
        
        $newClientNumber = $model->setClientNumber();

        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->id]);
            return $this->redirect(['index']);
        } else {
            
            return $this->render('create', [
              'model' => $model,
              'newClientNumber' => $newClientNumber,
           ]);
        }
    }

    /**
     * Updates an existing ClientData model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->layout = 'action';
        $model = $this->findModel($id);
        
        $newClientNumber = $model->setClientNumber();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'newClientNumber' => $newClientNumber,
            ]);
        }
    }

    /**
     * Deletes an existing ClientData model.
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
     * Finds the ClientData model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ClientData the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ClientData::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionAdd()
    {
        $this->layout = 'action';
        $model = new ClientData();
        
        $newClientNumber = $model->setClientNumber();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if(isset($_POST['add'])){
            return $this->redirect(['client-contacts/add']);     
            } else {
                return $this->redirect(['project/create']);
            }
        } else {            
            return $this->render('add', [
              'model' => $model,
              'newClientNumber' => $newClientNumber,
           ]);
        }
    }
}
