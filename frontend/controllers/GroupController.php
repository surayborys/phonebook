<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Group;
use frontend\models\Abonent;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\filters\AccessControl;

/**
 * GroupController implements the CRUD actions for Group model.
 */
class GroupController extends Controller
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
                        'actions' => ['index', 'create', 'view', 'update', 'delete', 'addcontacts', 'removecontacts'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Group models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Group::find()->where(['user_id' => Yii::$app->user->id])
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Group model.
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
     * Creates a new Group model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Group();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Group model.
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
     * Deletes an existing Group model.
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
     * Finds the Group model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Group the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Group::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    /**
     * adds contacts (frontend/models/Abonent) to user group
     * 
     * @param integer $id
     * @return mixed  
     **/
    public function actionAddcontacts($id) {
        $model = $this->findModel($id);
        $this->checkPermissionByModelsUserId($model->user_id);
         
        //select all non-group contacts from the database
        $nonGroupContacts = Abonent::find()->where(['user_id'=>$model->user_id])->andWhere('group_id != :id or group_id IS NULL', ['id' => $id])->all();
        
        //optimize data for displaying in view
        foreach ($nonGroupContacts as $contact) {
            $contact->setFullName();
        }
        
        //check if the form has been submitted and if the form is not empty 
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if(!isset($_POST['abonents'])){
                return $this->redirect(['index']);
            }
            $ids = $_POST['abonents'];
            //update contacts (frontendmodels/Abonent) 
            foreach ($ids as $abonent_id) {
                $abonent = Abonent::findOne(['id' => $abonent_id]);
                $abonent->group_id = $id;
                $abonent->save();   
            }
            return $this->redirect(['index']);
        }
        
        return $this->render('contacts', [
            'mode' => 'add',
            'nonGroupContacts' => $nonGroupContacts,
            'model' => $model,
        ]);
        
    }
    
    /**
     * removes contacts (frontend/models/Abonent from the group)
     * 
     * @param integer $id
     * @return mixed
     */
    public function actionRemovecontacts($id) {
        $model = $this->findModel($id);
        $this->checkPermissionByModelsUserId($model->user_id);
        
        //select all group's contacts(frontend/models/Abonent)
        $contacts = $model->getAbonents();
        //optimize data for displaying in view
        foreach ($contacts as $contact) {
            $contact->setFullName();
        }
        
        //check if the form has been submitted and if the $_POST has form data
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if(!isset($_POST['abonents'])){
                return $this->redirect(['index']);
            }
            $ids = $_POST['abonents'];
            //update contacns unset group_id
            foreach ($ids as $abonent_id) {
                $abonent = Abonent::findOne(['id' => $abonent_id]);
                $abonent->group_id = '';
                $abonent->save();   
            }
            return $this->redirect(['index']);
        }
        
        return $this->render('contacts', [
            'contacts' => $contacts,
            'mode' => 'remove',
            'model' => $model,
        ]);
        
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
}
