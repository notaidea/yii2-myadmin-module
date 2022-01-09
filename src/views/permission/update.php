<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model yii\Rbac\Permission */

$this->title = 'Update Permission';
$this->params['breadcrumbs'][] = ['label' => 'Permission', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="permission-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>