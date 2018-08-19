<?php

namespace app\modules\announcement\controllers;

use Yii;
use app\modules\announcement\models\Event;
use app\modules\announcement\models\EventSearch;
use app\models\UploadForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\web\Response;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * EventController implements the CRUD actions for Event model.
 */
class EventController extends Controller
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
  		else if (Yii::$app->user->identity->dsResponsibility !== 'Super Admin' && !stristr(Yii::$app->user->identity->dsResponsibility, 'Event'))
  			throw new ForbiddenHttpException('You are not authorized to perform this action.');

  		return true;
  	}

    /**
     * Lists all Event models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EventSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->pagination->pageSize=20;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionBulkmanage(){
      $searchModel = new EventSearch();
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
      \Yii::$app->response->format = Response::FORMAT_XML;
      $selection=(array)Yii::$app->request->post('selection');//typecasting
      foreach($selection as $id){
      if($action=="d"){
        Event::deleteAll('ID=:id',['id'=>$id]);
      }
        if($action=="a"){
          Event::updateAll(['status' => 1],['id'=>$id]);
        }
      }

      if($action=="b"){
          foreach($selection as $id){
            $events = Event::find()->where('ID=:id',['id'=>$id])->asArray()->all();
            foreach ($events as $event){
              $datas[] = $event;
            }
          }
          $jsondata = '';
          file_put_contents('backup.xml',$jsondata);
          header('Content-type: text/xml');
          header('Content-Disposition: Attachment; filename="backup.xml"');
          readfile('backup.xml');
          return $datas;

        }
      return $this->redirect('index.php?r=announcement%2Fevent%2Fbulkmanage');
    }

    public function actionRecover(){
      $datas = array();

      $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->file && $model->validate()) {
                $model->file->saveAs('' . $model->file->baseName . '.' . $model->file->extension);
                $xmlfile = file_get_contents($model->file);
                $arrXML = (array)simplexml_load_string($xmlfile);
                return $this->render('convert', [
                  'datas' => $arrXML,
                ]);
                }
              }
            return $this->render('recover', [
              'model' => $model,
            ]);
          }

    public function actionConvert(){

      return $this->render('convert');
    }

    public function objectsIntoArray($arrObjData, $arrSkipIndices = array())
    {
      $arrData = array();
      // if input is object, convert into array
      if (is_object($arrObjData)) {
        $arrObjData = get_object_vars($arrObjData);
      }
      if (is_array($arrObjData)) {
        foreach ($arrObjData as $index => $value) {
          if (is_object($value) || is_array($value)) {
            $value = $this->objectsIntoArray($value, $arrSkipIndices); // recursive call
          }
          if (in_array($index, $arrSkipIndices)) {
            continue;
          }
          $arrData[$index] = $value;
        }
      }
      return $arrData;
    }

    /**
     * Creates a new Event model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
     public function actionCreate()
     {
         $model = new Event();

         if ($model->load(Yii::$app->request->post())) {

             $post= Yii::$app->request->post();
             $images_path=[];
             $attachments_path=[];

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

         } else {
             return $this->render('create', [
                 'model' => $model,
             ]);
         }
     }

    /**
     * Updates an existing Event model.
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
     * Displays a single Event model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        date_default_timezone_set("Asia/Kuala_Lumpur");

        // var_dump($model->expiredText);exit();
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
     * Deletes an existing Event model.
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
     * Finds the Event model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Event the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
     protected function findModel($id)
     {
         if (($model = Event::findOne($id)) !== null) {
             return $model;
         } else {
             throw new NotFoundHttpException('The requested page does not exist.');
         }
     }
}
