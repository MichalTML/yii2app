<?php

namespace frontend\controllers;

use Yii;
use frontend\models\UserAttendance;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use frontend\models\Profile;
use frontend\models\PdfGenerator;

/**
 * UserAttendanceController implements the CRUD actions for UserAttendance model.
 */
class UserAttendanceController extends Controller
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
     * Lists all UserAttendance models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new \frontend\models\search\ProfileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $this->layout = 'action';
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserAttendance model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new UserAttendance model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserAttendance();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing UserAttendance model.
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
     * Deletes an existing UserAttendance model.
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
     * Finds the UserAttendance model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserAttendance the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserAttendance::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
/*
 * Insterting fake data to attendances
 */   
    
//    public function actionInsert(){
//        $model = new UserAttendance;
//        for($i = 1; $i <= 30; $i++){
//            $model->id = $i;
//            $model->userId = 2;
//            $model->date = '2015-08-'.$i;
//            $model->isNewRecord = true;
//            $model->save();
//        }
//    }
    
    
     public function actionAttendances($id)
    {
        $this->layout = 'action';
        
        $model = new PdfGenerator;
        
        $userData = Profile::find()->where(['userId' => $id])->one();
        
        $dataProvider = UserAttendance::find()->Where(['userId' => $id])->all();
        $dataProvider = ArrayHelper::map($dataProvider, 'date', 'userId');

        $events = [];
        
        
        foreach($dataProvider as $key => $value){
            $Event = new \yii2fullcalendar\models\Event();
            $Event->id = $key . ' => ' . $value;
            $Event->start = $key;
            $Event->allDay = true;
            $Event->className = 'calendar-day';
            $events[] = $Event;   
        }
        
        if ($model->load(Yii::$app->request->post())) {        
        return $this->redirect(['pdf-generator/create', 'userId' => $id, 'month' => $model->month, 'year' => $model->year ]);
        }
        
        return $this->render('attendance', [
            'events' => $events,
            'user' => $userData,
            'model' => $model,
        ]);
        }
        


}
