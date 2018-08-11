<?php

namespace app\modules\announcement\controllers;

use Yii;
use app\modules\announcement\models\Notification;
use app\modules\announcement\models\NotificationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\web\Response;

/**
 * NotificationController implements the CRUD actions for Notification model.
 */
class NotificationController extends Controller
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
		else if (Yii::$app->user->identity->dsResponsibility !== 'Super Admin' && !stristr(Yii::$app->user->identity->dsResponsibility, 'Notification'))
			throw new ForbiddenHttpException('You are not authorized to perform this action.');

		return true;
	}

    /**
     * Lists all Notification models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NotificationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->pagination->pageSize=20;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Notification models.
     * @return mixed
     */
    public function actionBulkmanage()
    {
      $searchModel = new NotificationSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      $dataProvider->pagination->pageSize=20;

      return $this->render('bulkmanage', [
        'searchModel' => $searchModel,
          'dataProvider' => $dataProvider,
      ]);
    }

    public function actionBulk(){
      $datas = array();
      $action=Yii::$app->request->post('action');
      \Yii::$app->response->format = Response::FORMAT_JSON;
      $selection=(array)Yii::$app->request->post('selection');//typecasting
      foreach($selection as $id){
      if($action=="d"){
        Notification::deleteAll('ID=:id',['id'=>$id]);
      }
        if($action=="a"){
          Notification::updateAll(['status' => 1],['id'=>$id]);
        }
        if($action=="b"){
          $events = Notification::find()->where('ID=:id',['id'=>$id])->asArray()->all();
          foreach ($events as $event){
            $datas[] = $event;
          }
          $jsondata = '';
          file_put_contents('backup.json',$jsondata);
          header('Content-type: text/json');
          header('Content-Disposition: Attachment; filename="backup.json"');
          readfile('backup.json');
          return $datas;
        }
      }
      return $this->redirect('index.php?r=announcement%2Fevent%2Fbulkmanage');
    }


    public function actionBackup()
    {
      $searchModel = new NotificationSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      return $this->render('backup', [

          'dataProvider' => $dataProvider,
      ]);
    }

    public function actionBackupall(){
      $datas = array();
      $selection=(array)Yii::$app->request->post('selection');
      \Yii::$app->response->format = \yii\web\Response::FORMAT_XML;

      foreach($selection as $id){
      $notifications = Notification::find()->where('ID=:id',['id'=>$id])->all();
      foreach ($notifications as $notification){
        $datas[] = $notification;
      }
    }

    $xmldata = '';
    file_put_contents('backup.xml',$xmldata);
    header('Content-type: text/xml');
    header('Content-Disposition: Attachment; filename="backup.xml"');
    readfile('backup.xml');
    return $datas;
    }

    /**
     * Displays a single Notification model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if($model->image)
            $images = explode(",",$model->image);
        else
            $images = null;

        if($model->attachment)
            $attachments = explode(",",$model->attachment);
        else
            $attachments = null;

        return $this->render('view', [
            'model' => $model,
            'images' => $images,
            'attachments' => $attachments,
        ]);
    }


    /**
     * Creates a new Notification model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */


    public function actionCreate()
    {
        $model = new Notification();

      if ($model->load(Yii::$app->request->post())) {

            $post= Yii::$app->request->post();

            $model->attributes=$_POST['Notification'];
            $name = $model->dId = Yii::$app->user->identity->dId;
            $filename = pathinfo($name, PATHINFO_FILENAME);
            $ext = pathinfo($name, PATHINFO_EXTENSION);

            $newName = $filename."-".date("m-d-Y", time()).'.'.$ext;
            //$fullImgSource = Yii::getPathOfAlias('webroot').'/upload/'.$newName;
            $images_path=[''];
            $attachments_path=[];
            // var_dump( );exit();
            // foreach ($post['Safety']['images_Temp'] as $image) {\

            $image_instaces = UploadedFile::getInstances($model,'images_Temp');


            foreach ($image_instaces as $instance) {

                if($instance){
                    $path = $newName . $instance->extension;
                    $instance->saveAs('uploads/images/Notification' . $path);
                    array_push($images_path,$path);
                }
            }



           $att_instaces = UploadedFile::getInstances($model,'attachments_Temp');

            foreach ($att_instaces as $instance) {

                if($instance){
                    $path = $instance->baseName . '.' . $instance->extension;
                    $instance->saveAs('uploads/attachments/' . $path);
                    array_push($attachments_path,$path);
                }
            }


            if($images_path!=[]){
                $images_path = implode(",", $images_path);
                $model->image = $images_path;
            }


            if($attachments_path!=[]){
                $attachments_path = implode(",", $attachments_path);
                $model->attachment = $attachments_path;
            }


            $model->dId = Yii::$app->user->identity->dId;
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                var_dump($model);
                exit();
            }


            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Notification model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            if($model->image!=null)
                $images = explode(",",$model->image);
            else
                $images = null;

            if($model->attachment!=null)
                $attachments = explode(",",$model->attachment);
            else
                $attachments = null;

            $post= Yii::$app->request->post();


            if($post['old_image_value']!=null)
                $old_images = explode("-",$post['old_image_value']);
            else
                $old_images = null;


            if($post['old_att_value']!=null)
                $old_attachments = explode("-",$post['old_att_value']);
            else
                $old_attachments = null;

            $images_path=[];
            $attachments_path=[];

            if($images){
                if($old_images){
                    $c = 0;
                    foreach ($images as $image) {

                        if(in_array($c, $old_images))
                            array_push($images_path,$image);
                        else{
                            if(file_exists('uploads/images/'.$image))
                                unlink('uploads/images/'.$image);

                        }

                        $c++;
                    }
                }else{
                    foreach ($images as $image) {
                        if(file_exists('uploads/images/'.$image))
                            unlink('uploads/images/'.$image);
                    }
                }
            }

             if($attachments){
                if($old_attachments){
                    $c = 0;
                    foreach ($attachments as $attachment) {

                        if(in_array($c, $old_attachments))
                            array_push($attachments_path,$attachment);
                        else{
                            if(file_exists('uploads/attachments/'.$attachment))
                                unlink('uploads/attachments/'.$attachment);

                        }
                        $c++;
                    }
                }else{
                    foreach ($attachments as $attachment) {
                        if(file_exists('uploads/attachments/'.$attachment))
                            unlink('uploads/attachments/'.$attachment);
                    }
                }

            }


            $image_instaces = UploadedFile::getInstances($model,'images_Temp');

            foreach ($image_instaces as $instance) {

                if($instance){
                    $path = $instance->baseName . '.' . $instance->extension;
                    $instance->saveAs('uploads/images/' . $path);
                    array_push($images_path,$path);
                }
            }

           $att_instaces = UploadedFile::getInstances($model,'attachments_Temp');

            foreach ($att_instaces as $instance) {

                if($instance){
                    $path = $instance->baseName . '.' . $instance->extension;
                    $instance->saveAs('uploads/attachments/' . $path);
                    array_push($attachments_path,$path);
                }
            }


            if($images_path!=[]){
                $images_path = implode(",", $images_path);
                $model->image = $images_path;
            }else{
                $model->image = null;
            }


            if($attachments_path!=[]){
                $attachments_path = implode(",", $attachments_path);
                $model->attachment = $attachments_path;
            }else{
                $model->attachment = null;
            }


            $model->dId = Yii::$app->user->identity->dId;

            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                var_dump($model);
                exit();
            }


        } else {


            if($model->image)
                $images = explode(",",$model->image);
            else
                $images = null;

            if($model->attachment)
                $attachments = explode(",",$model->attachment);
            else
                $attachments = null;


            return $this->render('update', [
                'model' => $model,
                'images' => $images,
                'attachments' => $attachments,
            ]);
        }
    }

    /**
     * Deletes an existing Notification model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);


        if($model->status == 1){

            $model->delete();

        }else{
            $model->status = 1;
            $model->save();
        }

        return $this->redirect(['index']);
    }

    public function actionArchive($id)
    {
        $model = $this->findModel($id);
        $model->status = 1;
        $model->save();

        return $this->redirect(['view', 'id' => $model->id]);
    }

    public function actionUnarchive($id)
    {
        $model = $this->findModel($id);
        $model->status = 0;
        $model->save();

        return $this->redirect(['view', 'id' => $model->id]);
    }


    /**
     * Finds the Notification model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Notification the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Notification::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
