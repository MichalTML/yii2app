<?php

namespace frontend\controllers;

use Yii;
use frontend\models\ClientData;
use frontend\models\search\ClientSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\ClientKrsFiles;
use yii\web\UploadedFile;

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
        
        $dataProvider->pagination->pageSize = 10;
        
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
        return $this->renderPartial('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    public function actionDetail($id)
    {
        $this->layout = 'action';
        return $this->renderPartial('detailView', [
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
        
        $newClientNumber = $model->setNewClientNumber();
        
        if ($model->load(Yii::$app->request->post())) {
            $number = $model->phone;
            $fax = $model->fax;
            $numberFormatted = explode(' ', trim($number));
            $faxFormatted = explode(' ', trim($fax));
            if(count($numberFormatted) > 1){
                $numberFormatted = trim(implode('', $numberFormatted));
            } else {
                $numberFormatted = $number;    
            }
            if(count($faxFormatted) > 1){
                $faxFormatted = trim(implode('', $faxFormatted));
            } else {
                $faxFormatted = $fax;
            }
            $model->phone = $numberFormatted;
            $model->fax = $faxFormatted;
            if($model->save()){
                if(isset($_POST['add'])){
                    return $this->redirect(['client-contacts/addn']);     
                } else {
                    return $this->redirect(['index']);
                }
            } else {
              return $this->render('create', [
              'model' => $model,
              'newClientNumber' => $newClientNumber,
           ]);  
            }
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
        
        if ($model->load(Yii::$app->request->post())) {
            $number = $model->phone;
            $fax = $model->fax;
            $numberFormatted = explode(' ', trim($number));
            $faxFormatted = explode(' ', trim($fax));
            if(count($numberFormatted) > 1){
                $numberFormatted = trim(implode('', $numberFormatted));
            } else {
                $numberFormatted = $number;    
            }
            if(count($faxFormatted) > 1){
                $faxFormatted = trim(implode('', $faxFormatted));
            } else {
                $faxFormatted = $fax;
            }
            $model->phone = $numberFormatted;
            $model->fax = $faxFormatted;
            if($model->save()){
            return $this->redirect(['index']);
            }
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
        
        $newClientNumber = $model->setNewClientNumber();
        
        if ($model->load(Yii::$app->request->post())) {
            $number = $model->phone;
            $fax = $model->fax;
            $numberFormatted = explode(' ', trim($number));
            $faxFormatted = explode(' ', trim($fax));
            if(count($numberFormatted) > 1){
                $numberFormatted = trim(implode('', $numberFormatted));
            } else {
                $numberFormatted = $number;    
            }
            if(count($faxFormatted) > 1){
                $faxFormatted = trim(implode('', $faxFormatted));
            } else {
                $faxFormatted = $fax;
            }
            $model->phone = $numberFormatted;
            $model->fax = $faxFormatted;            
            if($model->save()){
            if(isset($_POST['add'])){
            return $this->redirect(['client-contacts/add']);     
            } else {
                return $this->redirect(['project/create']);
            }
            }
        } else {            
            return $this->render('add', [
              'model' => $model,
              'newClientNumber' => $newClientNumber,
           ]);
        }
    }

    public function actionUploadkrs($id){
        $model = new ClientKrsFiles;
        $root = $_SERVER['DOCUMENT_ROOT'];
        //below code is where you will do your own stuff. This is just a sample code need to do work on saving files
        if ($model->load(Yii::$app->request->post())){
            $file = UploadedFile::getInstances($model, 'path');
             $date = date('y-h-i-s');
             $target = $root.'/krs-pdf/'.date('y-h-i-s').$date.$file[0]->name;
             $imageName = explode('.', $file[0]);
             $imagePath = $root.'/krs-pdf/'.$date.$imageName[0].'.jpg';
             
    
            if(move_uploaded_file($file[0]->tempName, $target)) {
                
                $imagick = new \Imagick();
                $imagick->readImage($target.'[0]');
                $imagick->setImageFormat('jpg');
                $imagick->setCompressionQuality(97);
                
                $imagick->writeImage($imagePath);
                
                $result = $model->find()->where(['clientId' => $id])->one();
                if(!empty($result)){
                    $model = $model->find()->where(['id'=>($result->id)])->one();
                    $model->name = $date.$file[0]->name;
                    $model->path = $target;
                    $model->imagePath = $imagePath;
                } else {
                    $model->clientId = $id;
                    $model->path = $target;
                    $model->name = $file[0]->name;
                    $model->imagePath = $imagePath;
                    $model->isNewRecord = true;
                }
                if($model->save()){
                   $client = new ClientData;
                   $clientModel = $client->find()->where(['id'=>$id])->one();
                   $clientModel->krsFile = 1;
                   $clientModel->save();
                   return $this->redirect(['client/index']);  
        }}
        }else{
            return $this->renderAjax('uploadkrs', [
                'model' => $model,
            ]);
    }
    }
    
    public function actionViewkrs( $path, $name) {
        $fileName = $name . '.pdf';
        header( 'Content-type: application/pdf' );
        header( 'Content-Disposition: inline; filename="' . $fileName . '"' );
        //header('Content-Length: ' . filesize($filename));
        //header('Content-Transfer-Encoding: binary');
        //header('Accept-Ranges: bytes');
        echo '<head><title>Page Title</title></head>';
        return readfile( $path );
    }
}
