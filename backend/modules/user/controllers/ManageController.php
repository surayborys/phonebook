<?php

namespace backend\modules\user\controllers;

use Yii;
use backend\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;
use backend\models\SignupForm;

/**
 * ManageController implements the CRUD actions for User model.
 */
class ManageController extends Controller
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
                            Yii::$app->session->setFlash('danger','Access denied...');
                            return $this->redirect(Url::to(['/site/index']));
                        },
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index','view', 'delete', 'create'],
                        'roles' => ['admin', 'moderator'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => ['admin'],
                    ],
                    
                ],
                                
            ]
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()){
            
            Yii::$app->session->setFlash('success', 'a new user created');                     
            
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            Yii::$app->session->setFlash('success', 'user successfully updated');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        /*user can't delete himself*/
        if($model->id == Yii::$app->user->id) {
            Yii::$app->session->setFlash('danger', 'non-permitted action. trying to delete himself');
            return $this->redirect(Url::to(['/user/manage/index']));
        }
        
        /*admin can't be removed*/
        if($model->role_id == User::USER_ADMIN_ROLE_ID){
            
            Yii::$app->session->setFlash('danger', 'permission denied');
            return $this->redirect(Url::to(['/user/manage/index']));
        } 
        //check current logged-in user role
        $role = Yii::$app->user->identity->role_id;
        
        /* only admin has permission to delete moderator*/
        if($model->role_id == User::USER_MODERATOR_ROLE_ID && $role != User::USER_ADMIN_ROLE_ID){
            
            Yii::$app->session->setFlash('danger', 'permission denied');
            
            return $this->redirect(Url::to(['/user/manage/index']));
        }
        
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
