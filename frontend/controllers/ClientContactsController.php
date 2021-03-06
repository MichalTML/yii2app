<?php

namespace frontend\controllers;

use Yii;
use frontend\models\ClientContacts;
use frontend\models\ClientData;
use frontend\models\search\ClientContactsSearch;
use common\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ClientContactsController implements the CRUD actions for ClientContacts model.
 */
class ClientContactsController extends Controller {

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
     * Lists all ClientContacts models.
     * @return mixed
     */
    public function actionIndex() {
        $this->layout = 'action';
        $searchModel = new ClientContactsSearch();
        $dataProvider = $searchModel->search( Yii::$app->request->queryParams );

        return $this->render( 'index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                ] );
    }

    /**
     * Displays a single ClientContacts model.
     * @param integer $id
     * @return mixed
     */
    public function actionView( $id ) {
        return $this->renderPartial( 'view', [
                    'model' => $this->findModel( $id ),
                ] );
    }

    /**
     * Creates a new ClientContacts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $this->layout = 'action';
        $model = new ClientContacts();

         if ($model->load(Yii::$app->request->post())) {
            $number = $model->phone;
            $fax = $model->fax;
            $numberFormatted = explode(' ', trim($number));
            $faxFormatted = explode(' ', trim($fax));
            if(count($numberFormatted) > 1){
            $numberFormatted = trim(implode('', $numberFormatted));
            } 
            if(count($faxFormatted) > 1){
            $faxFormatted = trim(implode('', $faxFormatted));
            } 
            $model->phone = $numberFormatted;
            $model->fax = $faxFormatted;
            if($model->save()){
            if(isset($_POST['add'])){
                return $this->redirect(['client-contacts/create']);
            } else {
            return $this->redirect(['client-contacts/index']);
            }
            }
        } else {
            return $this->render( 'create', [
                        'model' => $model,
                    ] );
        }
    }

    public function actionAdd() {
        $this->layout = 'action';
        $model = new ClientContacts();

        $clientData = new ClientData();

        if ( $model->load( Yii::$app->request->post() ) ) {
            $client = $clientData->find()->select( 'id' )->orderBy( ['id' => SORT_DESC ] )->one();
            $clientid = $client->id;            
            $model->clientId = $clientid;
            
            $number = $model->phone;
            $fax = $model->fax;
            $numberFormatted = explode(' ', trim($number));
            $faxFormatted = explode(' ', trim($fax));
            if(count($numberFormatted) > 1){
            $numberFormatted = trim(implode('', $numberFormatted));
            } 
            if(count($faxFormatted) > 1){
            $faxFormatted = trim(implode('', $faxFormatted));
            } 
            $model->phone = $numberFormatted;
            $model->fax = $faxFormatted;
            
            if ( $model->save() ) {
            
                if ( isset( $_POST[ 'create' ] ) ) {
                    return $this->redirect( ['project/create']);
                }
                if ( isset( $_POST[ 'add' ] ) ) {
                    return $this->redirect( ['client-contacts/add']);
            } else {
            return $this->render( 'add', [
                        'model' => $model,
            ] );}
        }
        } else {
            return $this->render( 'add', [
                        'model' => $model,
                    ] );
        }
    }
    
    public function actionAddn(){
       $this->layout = 'action';
        $model = new ClientContacts();

        $clientData = new ClientData();

        if ( $model->load( Yii::$app->request->post() ) ) {

            $client = $clientData->find()->select( 'id' )->orderBy( ['id' => SORT_DESC ] )->one();

            $clientid = $client->id;
            
            $model->clientId = $clientid;
            
            $number = $model->phone;
            $fax = $model->fax;
            $numberFormatted = explode(' ', trim($number));
            $faxFormatted = explode(' ', trim($fax));
            if(count($numberFormatted) > 1){
            $numberFormatted = trim(implode('', $numberFormatted));
            } 
            if(count($faxFormatted) > 1){
            $faxFormatted = trim(implode('', $faxFormatted));
            } 
            $model->phone = $numberFormatted;
            $model->fax = $faxFormatted;
            var_dump($faxFormatted);
            if ( $model->save() ) {
            
                if ( isset( $_POST[ 'create' ] ) ) {
                    return $this->redirect( ['client/index']);
                }
                if ( isset( $_POST[ 'add' ] ) ) {
                    return $this->redirect( ['client-contacts/addn']);
                }
                } else {
            return $this->render( 'addn', [
                        'model' => $model,
            ] );}
        } else {
            return $this->render( 'addn', [
                        'model' => $model,
                    ] );
        } 
    }

    /**
     * Updates an existing ClientContacts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate( $id ) {
        $this->layout = 'action';
        $model = $this->findModel( $id );

        if ( $model->load( Yii::$app->request->post() ) && $model->save() ) {
            return $this->redirect( [ 'index' ] );
        } else {
            return $this->render( 'update', [
                        'model' => $model,
                    ] );
        }
    }

    /**
     * Deletes an existing ClientContacts model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete( $id ) {
        $this->findModel( $id )->delete();

        return $this->redirect( ['index' ] );
    }

    /**
     * Finds the ClientContacts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ClientContacts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel( $id ) {
        if ( ($model = ClientContacts::findOne( $id )) !== null ) {
            return $model;
        } else {
            throw new NotFoundHttpException( 'The requested page does not exist.' );
        }
    }

}
