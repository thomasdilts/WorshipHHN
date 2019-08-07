<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
<div class="site-reply">

    <h1><?= Html::encode($title) ?></h1>

    <div class="col-md-5 well bs-component">

        <h3><?= $message ?></h3>
        <?php if(strlen($status)>0){ ?>
        	<h5>Status: <?= $status ?></h5>
    	<?php } ?>

    </div>
  
</div>
