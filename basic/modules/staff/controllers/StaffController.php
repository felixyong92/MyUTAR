<?php

namespace app\modules\staff\controllers;

use Yii;
use app\modules\staff\models\Staff;
use app\modules\staff\models\StaffSearch;
use app\modules\staff\models\ChangePasswordForm;
use app\modules\staff\models\UserChangePasswordForm;
use app\modules\announcement\models\Event;
use app\modules\announcement\models\EventSearch;
use app\modules\announcement\models\Notification;
use app\modules\announcement\models\NotificationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\data\Pagination;
use asinfotrack\yii2\audittrail\models\AuditTrailEntry;
use asinfotrack\yii2\audittrail\models\AuditTrailEntrySearch;
use asinfotrack\yii2\audittrail\models\AuditTrailEntryQuery;
use yii\data\SqlDataProvider;

/**
 * StaffController implements the CRUD actions for Staff model.
 */
class StaffController extends Controller
{
    /**
     * @inheritdoc
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

	public function beforeAction($action)
	{
        if (Yii::$app->user->isGuest)
            Yii::$app->user->loginRequired();
		else if (Yii::$app->user->identity->dsResponsibility !== 'Super Admin' && Yii::$app->user->identity->dsResponsibility !== 'Manage User')
			throw new ForbiddenHttpException('You are not authorized to perform this action.');

		return true;
	}

    /**
     * Lists all Staff models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StaffSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionActivitylog(){
      $model = new Notification();

    /*$model = new SqlDataProvider([
    'sql' => 'SELECT * FROM audit_trail_entry',
    'key'        => 'id',
    'pagination' => [
        'pageSize' => 10,
    ],
    'sort' => [
        'attributes' => [
            'title',
            'view_count',
            'created_at',
        ],
    ],
]);*/

return $this->render('activitylog', [
    'model' => $model
]);
    }

    /**
     * Displays a single Staff model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Staff model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Staff();

        if ($model->load(Yii::$app->request->post())) {
			$model->dsResponsibility = implode(", ", $model->dsResponsibility);
			$model->dsPassword = sha1($model->dsPassword);
			if ($model->save()) {
				return $this->redirect(['view', 'id' => $model->dsId]);
			} else {
				return $this->render('create', [
					'model' => $model,
				]);
			}
		} else {
			return $this->render('create', [
				'model' => $model,
			]);
		}
    }

    /**
     * Updates an existing Staff model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
			$model->dsResponsibility = implode(", ", $model->dsResponsibility);
			if ($model->save()) {
				return $this->redirect(['view', 'id' => $model->dsId]);
			} else {
				return $this->render('update', [
					'model' => $model,
				]);
			}
		} else {
			return $this->render('update', [
				'model' => $model,
			]);
		}
    }

	/**
	 * Change User password.
	 *
	 * @return mixed
	 * @throws BadRequestHttpException
	 */
	public function actionChangepassword($id)
    {
		$model = $this->findModel($id);
		$id = $model->dsId;
		try {
			$model = new ChangePasswordForm($id);
		} catch (InvalidParamException $e) {
			throw new \yii\web\BadRequestHttpException($e->getMessage());
		}

		if ($model->load(\Yii::$app->request->post()) && $model->validate() && $model->changePassword()) {
			Yii::$app->session->setFlash('success', 'Password has been changed successfully!');
		}

		return $this->render('changePassword', [
			'model' => new ChangePasswordForm($id),
		]);
    }

    /**
     * Deletes an existing Staff model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Staff model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Staff the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Staff::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
