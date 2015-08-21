<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use kartik\mpdf\Pdf;
use frontend\models\Profile;
use frontend\models\UserAttendance;

class PdfGeneratorController extends Controller {

    public function actionIndex()
    {
        return $this->render('index');
    }
    
     public function actionRaport()
    {
        return $this->render('_raport');
    }
    
    public function actionCreate($userId, $month, $year) {
        
       
        $currentUser = Yii::$app->user->id;
        $userData = Profile::find()->where(['userId' => $currentUser])->one();
        
        $date = $year. '-' . $month;
        
        $dataProvider = UserAttendance::find()
                ->andFilterWhere(['=', 'userId', $userId])
                ->andFilterWhere(['like', 'date', $date])
                ->all();
        
        
        
        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
        'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
        'destination' => Pdf::DEST_DOWNLOAD,
        'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.css',       
        'content' =>  $this->renderPartial('_raport', [
            'data' => $dataProvider,
            'user' => $userData,
            'month' => $month,
            'year' => $year,
        ]),
        'filename' => 'pdf report',
        'options' => [
            'title' => 'Attendance Raport Generator',
            'subject' => 'Attendance List',
            
            
        ],
        'methods' => [
            'SetHeader' => ['Created by: ' . $userData->firstName . ' ' . $userData->lastName . '||' . 'Generated On: ' . date("Y-m-d")],
            //'SetFooter' => ['|Page {PAGENO}|'],
        ]
    ]);    
    // return the pdf output as per the destination setting
    return $pdf->render();        
    }
    
}
