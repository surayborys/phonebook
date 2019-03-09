<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Abonent;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use frontend\models\UploadForm;
use yii\web\UploadedFile;

/**
 * AbonentController implements the CRUD actions for Abonent model.
 */
class AbonentController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Abonent models.
     * @return mixed
     */
    public function actionIndex($group_id = false)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(Url::to('/user/login'));
        }
        
        $currentUser = Yii::$app->user->identity;
        $userID = Yii::$app->user->id;
        
        $groups = $currentUser->getGroups();
        
        //check if the $group_id param is passed to the action and customize WHERE condition depends on it
        $condition = ($group_id == false) ? ['user_id' => $userID] : ['user_id' => $userID, 'group_id' => $group_id];
        $query = Abonent::find()->where($condition);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 9,
            ],
        ]);
        
        
        
        return $this->render('index', [
            'currentUser' => $currentUser,
            'dataProvider' => $dataProvider,
            'groups' => $groups,
        ]);
    }
    
    /**
     * Displays a single Abonent model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        
        $this->checkPermissionByModelsUserId($model->user_id);
                
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Abonent model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Abonent();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Abonent model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        
        $model = $this->findModel($id);
        $this->checkPermissionByModelsUserId($model->user_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Abonent model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $this->checkPermissionByModelsUserId($model->user_id);
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Abonent model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Abonent the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Abonent::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    /**
     * Checks if the model's user_id is equal to current logged-in user's id.
     * If not - redirects to index.
     * 
     * @param integer $user_id
     * @return mixed|void
     */
    protected function checkPermissionByModelsUserId($user_id){
        if($user_id != Yii::$app->user->id){
            return $this->redirect(['index']);
        }
    }
    
    /**
     * handles picture uploading 
     * 
     * @param integer $id
     * @return mixed
     */
    public function actionUpload($id)
    {
         if (Yii::$app->user->isGuest) {
            return $this->redirect(Url::to('/user/login'));
        }
        
        $abonent = $this->findModel($id);
        if(isset($abonent->photo) & !empty($abonent->photo)){
            $oldPhoto = $abonent->photo;
        }
        
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($photo = $model->upload(Yii::$app->user->id, $id)) {
                // file is uploaded successfully
                $abonent->photo = $photo;
                if($abonent->save()&& isset($oldPhoto)) {
                    $this->deleteFile($oldPhoto);
                }
                return $this->redirect(['abonent/view', 'id'=>$id]);
            }
        }

        return $this->render('upload', ['model' => $model]);
    }
    
    /**
     * deletes abonent's photo
     * 
     * @param type $id
     * @return type
     */
    public function actionRemovePhoto($id){
        if (Yii::$app->user->isGuest) {
            return $this->redirect(Url::to('/user/login'));
        }
        
        $abonent = $this->findModel($id);
        if(isset($abonent->photo) & !empty($abonent->photo)){
            $this->deleteFile($abonent->photo);
            $abonent->photo = '';
            $abonent->save();
        }
        return $this->redirect(['abonent/view', 'id'=>$id]);
    }


    /**
     * deletes file
     * 
     * @param type $file
     * @return boolean
     */
    protected function deleteFile(string $file) {
        
        $filename = '/' . $file;
        
        if(file_exists($filename)) {
            return unlink($filename);
        }
        return true;
    }
}
