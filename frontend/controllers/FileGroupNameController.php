<?php

namespace frontend\controllers;

use Yii;
use frontend\models\FileGroupName;
use frontend\models\search\FileGroupNameSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\ProjectAssembliesFiles;

/**
 * FileGroupNameController implements the CRUD actions for FileGroupName model.
 */
class FileGroupNameController extends Controller
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
     * Lists all FileGroupName models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FileGroupNameSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FileGroupName model.
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
     * Creates a new FileGroupName model.
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
                    $model->isNewRecord = true;
                    $model->groupName = $data['groupName'];
                    $model->projectId = $sygnature;
                    
                    if($model->save()){
                         $fileGroup = new FileGroupName;
                         $droptions = $fileGroup->getStatusList($sygnature);
                         \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                              return [
                                  'code' => 200,
                                  'droptions' => $droptions,
                                     ];               
                     } 
            }elseif($data['action'] == 'delete_name'){
                $remove = $model->find()->where(['groupId' => $data['groupId']])->one();
                if($remove->delete()){
                    $fileGroup = new ProjectAssembliesFiles;
                    
                    while($fileGroup->find()->where(['groupId' => $data['groupId']])->one()){
                        $remove2 = $fileGroup->find()->where(['groupId' => $data['groupId']])->one();
                        $remove2->groupId = 0;
                        $remove2->save();
                    }
                    $droptions = new FileGroupName;   
                    $droptions = $droptions->getStatusList($sygnature);
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                            return [
                                'code' => 200,
                                'droptions' => $droptions,
                                   ];               
                }
            }elseif($data['action'] == 'add_group'){
                $id = explode(',', $id);
                foreach($id as $file){
                    $model = new ProjectAssembliesFiles; 
                    $check = $model->find()->where(['id' => $file])->one();
                    
                    $check->groupId = $data['groupId'];
                    $check->save();                   
                }                
                    $fileGroup = new FileGroupName;
                    
                    $droptions = $fileGroup->getStatusList($sygnature);
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                            return [
                                'code' => 200,
                                'droptions' => $droptions,
                                   ];               
                }
            }
        }             

        $modelGroup = new FileGroupName();
        $droptions = $modelGroup->getStatusList($sygnature);
           
            return $this->renderAjax('_form', [
                'modelGroup' => $modelGroup,
                'sygnature' => $sygnature,
                'id' => $id,
                'droptions' => $droptions,
            ]);
    }

    /**
     * Updates an existing FileGroupName model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->groupId]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing FileGroupName model.
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
     * Finds the FileGroupName model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FileGroupName the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FileGroupName::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
