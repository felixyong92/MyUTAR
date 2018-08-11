<?php

namespace app\controllers;

class NotificationController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionBulkManage()
    {
        return $this->render('bulkmanage');
    }

}
