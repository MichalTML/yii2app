<?php

namespace frontend\controllers;

use Yii;
use frontend\models\OClientData;
use frontend\models\search\OClientDataSearch;
use frontend\models\ClientData;
use frontend\models\OClientContacts;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OClientDataController implements the CRUD actions for OClientData model.
 */
class OClientDataController extends Controller
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
     * Lists all OClientData models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'action';
        $searchModel = new OClientDataSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionPromote()
    {
        
        $this->layout = 'action';
        $searchModel = new OClientDataSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('promote', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    
    
    public function actionPromotion($id)
    {      
        //$scenario->scenario = 'promotion';
        
        $this->layout = 'action';
        $model = $this->findModel($id);
        $model->scenario = 'promotion';
        
        $clientData = new ClientData; 
        $newClientNumber = $clientData->setNewClientNumber();
        
        $clientContacts = new OClientContacts;
        
        
        if ($model->load(Yii::$app->request->post()) /*&& $model->save()*/) {
            if($this->moveToClients(Yii::$app->request->post(), $model->id) & $clientContacts->moveContacts($id)){
                return $this->redirect(['project/create']);
            } else {
                return $this->render('promprep', [
                'model' => $model,
                'newClientNumber' => $newClientNumber,
            ]);
            }
            
        } else {
            return $this->render('promprep', [
                'model' => $model,
                'newClientNumber' => $newClientNumber,
            ]);
        }
    }
    
    public function moveToClients($post, $id){
        $ClientData = new ClientData;
        
        $ClientData->name = $post['OClientData']['name'];
        $ClientData->clientNumber = $post['OClientData']['clientNumber'];
        $ClientData->abr= $post['OClientData']['abr'];
        $ClientData->adress = $post['OClientData']['adress'];
        $ClientData->city = $post['OClientData']['city'];
        $ClientData->postal = $post['OClientData']['postal'];
        $ClientData->phone = $post['OClientData']['phone'];
        $ClientData->fax = $post['OClientData']['fax'];
        $ClientData->email = $post['OClientData']['email'];
        $ClientData->nip = $post['OClientData']['nip'];
        $ClientData->krs = $post['OClientData']['krs'];
        $ClientData->regon = $post['OClientData']['regon'];
        $ClientData->www = $post['OClientData']['www'];
        $ClientData->description = $post['OClientData']['description'];
        $ClientData->isNewRecord = true;
        $ClientData->id = null;
        
        if($ClientData->save()){
           $this->actionDelete($id);
            return true;
        }
       return false;

    }
    /**
     * Displays a single OClientData model.
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
     * Creates a new OClientData model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'action';
        $model = new OClientData();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing OClientData model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->layout = 'action';
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
     * Deletes an existing OClientData model.
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
     * Finds the OClientData model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OClientData the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OClientData::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
