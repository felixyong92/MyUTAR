<?php

/* @var $this yii\web\View */

$this->title = 'MyUTAR Backend System';
?>
<div class="site-index">

     <div class="jumbotron">
        <h1>Hello <?php if(isset(Yii::$app->user->identity->username))echo Yii::$app->user->identity->username; ?></h1>

        <p class="lead">Welcome to MyUTAR Web-based backend system</p>

        
    </div>
</div>
