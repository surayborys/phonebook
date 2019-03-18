<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Abonent;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\UploadedFile;
use yii\helpers\Html;
use yii\filters\AccessControl;

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
            'access' => [
                'class' => AccessControl::className(),
                'denyCallback' => function($rule, $action) {
                            Yii::$app->session->setFlash('danger','Login to continue...');
                            return $this->redirect(Url::to(['/user/login']));
                        },
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'view', 'update', 'delete', 'search', 'remove-photo'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
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

        if ($model->load(Yii::$app->request->post())){
            
            /**
             * model saves file using event AFTER_INSERT 
             */
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
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

        if ($model->load(Yii::$app->request->post())) {
            /*check if the file is uploaded*/
            if($model->imageFile = UploadedFile::getInstance($model, 'imageFile')){
                /* check if the model has 'photo' attribute */
                $oldPhoto = $model->photo ? $model->photo : false;
            }
            if($model->save()) {
                if(isset($oldPhoto) && $oldPhoto != false) {
                    /* remove old photo */
                    $this->deleteFile($oldPhoto);
                } 
                return $this->redirect(['view', 'id' => $model->id]);
            }
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
     * deletes abonent's photo
     * 
     * @param type $id
     * @return type
     */
    public function actionRemovePhoto($id){
                
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
    protected function deleteFile($file) {
        
        if(file_exists($file)) {
            return unlink($file);
        }
        return true;
    }
    
    /**
     * performs search by keyword
     * 
     * @param $keyword
     */
    public function actionSearch($keyword) {
        
        $currentUser = Yii::$app->user->identity;
        $userID = Yii::$app->user->id;
        $groups = $currentUser->getGroups();
        
        $keyword = Html::encode($keyword);
        
        /*determine the search source based on kyword */
        $search_source = $this->determine_search_source($keyword);
        
        /*execute matching search case*/
        if($search_source == 'fullname') {
            $query = Abonent::find()->where(['user_id' => $userID])->andfilterWhere(['like','concat(name, patronymic, surname)', $keyword]);
        }
        
        if($search_source == 'phone') {
            
            /* 380(77)777-77-77 or 7)777-77-77 or 777-77-77 */
            $phone = $this->prepareStandardNumber($keyword);
            
            $query = Abonent::find()->where(['user_id' => $userID])->andfilterWhere(['like', 'abonent.phone', $phone]);
        }
        
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
     * analyses keyword and determines the source for search
     * 
     * @param $keyword
     * @return string
     */
    protected function determine_search_source($keyword){
        
        /* 380677777777 has 12 symbols */
        if(strlen($keyword) > 12) {
            return 'fullname';
        }
        
        /* check if the given keyword mathces with phone number */
        $pattern_number = "~[0-9]{7,12}~";
        
        if(preg_match($pattern_number, $keyword))
        {
            return 'phone';
        }
        
        //return fullname by default
        return 'fullname';
    }
    
    /**
     * formats phone number according to database requirements
     * 380(55)555-55-55
     * 
     * @param string $keyword
     */
    protected function prepareStandardNumber($keyword) {
        
        $length = strlen($keyword);
        
        switch ($length) {
            case 7:
                $keyword = substr_replace($keyword, '-', -2, 0); //now length is 8
                $keyword = substr_replace($keyword, '-', -5, 0); //now length is 9
                return $keyword;
            
            case ($length == 8 || $length == 9) :
                $keyword = substr_replace($keyword, '-', -2, 0); //now length is 8
                $keyword = substr_replace($keyword, '-', -5, 0); //now length is 9
                $keyword = substr_replace($keyword, ')', -9, 0); //now length is 10
                return $keyword;
            case ( $length > 9) :
                $keyword = substr_replace($keyword, '-', -2, 0); //now length is 8
                $keyword = substr_replace($keyword, '-', -5, 0); //now length is 9
                $keyword = substr_replace($keyword, ')', -9, 0); //now length is 10
                $keyword = substr_replace($keyword, '(', -12, 0); //now length is 10
                return $keyword;
        }
        
        
    }
}
