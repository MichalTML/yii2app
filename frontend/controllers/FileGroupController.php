<?php

namespace frontend\controllers;

use Yii;
use frontend\models\FileGroup;
use frontend\models\search\FileGroupSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\FileGroupName;

/**
 * FileGroupController implements the CRUD actions for FileGroup model.
 */
class FileGroupController extends Controller
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
     * Lists all FileGroup models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FileGroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FileGroup model.
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
     * Creates a new FileGroup model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id, $sygnature)
    { 
        if (Yii::$app->request->isAjax) {
           $data = Yii::$app->request->post();
           if(isset($data['action'])){
               $model = new FileGroupName;
               if($data['action'] == 'save_name'){    
                    $model->isNewRecord;
                    $model->groupName = $data['groupName'];
                    $model->projectId = $sygnature;
                    
                    if($model->save()){
                         $fileGroup = new FileGroup;
                         $droptions = $fileGroup->getStatusList($sygnature);
                         $droptions2 = $fileGroup->getStatusList($sygnature, 'filter');
                         \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                              return [
                                  'code' => 200,
                                  'droptions' => $droptions,
                                  'droptions2' => $droptions2,
                                     ];               
                     } 
            }elseif($data['action'] == 'delete_name'){
                $remove = $model->find()->where(['groupId' => $data['groupId']])->one();
                if($remove->delete()){
                    $fileGroup = new FileGroup;
                    
                    while($fileGroup->find()->where(['groupId' => $data['groupId']])->one()){
                        $remove2 = $fileGroup->find()->where(['groupId' => $data['groupId']])->one();
                        $remove2->delete();
                    }
                         
                    $droptions = $fileGroup->getStatusList($sygnature);
                    $droptions2 = $fileGroup->getStatusList($sygnature, 'filter');
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                            return [
                                'code' => 200,
                                'droptions' => $droptions,
                                'droptions2' => $droptions2,
                                   ];               
                }
            }elseif($data['action'] == 'add_group'){
                $id = explode(',', $id);
                foreach($id as $file){
                    $model = new FileGroup; 
                    $check = $model->find()->where(['fileId' => $file])->one();
                        if($check){
                            $check->groupId = $data['groupId'];
                            $check->save();
                        }else{
                            $model = new FileGroup; 
                            $model->isNewRecord = true;
                            $model->fileId = $file;
                            $model->groupId = $data['groupId'];
                            $model->save();
                        }
                   
                }                
                    $fileGroup = new FileGroup;
                    
                    $droptions = $fileGroup->getStatusList($sygnature);
                    $droptions2 = $fileGroup->getStatusList($sygnature, 'filter');
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                            return [
                                'code' => 200,
                                'droptions' => $droptions,
                                'droptions2' => $droptions2,
                                   ];               
                }
            }
        }             

        $model = new FileGroup();
        $modelGroup = new FileGroupName();
        $fileGroup = new FileGroup;
        $droptions = $fileGroup->getStatusList($sygnature);
        $droptions2 = $fileGroup->getStatusList($sygnature, 'filter');
           
            return $this->renderAjax('_form', [
                'model' => $model,
                'modelGroup' => $modelGroup,
                'sygnature' => $sygnature,
                'id' => $id,
                'droptions' => $droptions,
                'droptions2' => $droptions2,
            ]);
    }

    /**
     * Updates an existing FileGroup model.
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
     * Deletes an existing FileGroup model.
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
     * Finds the FileGroup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FileGroup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FileGroup::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
