<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model yii\Rbac\Role */

$this->title = 'Update Role';
$this->params['breadcrumbs'][] = ['label' => 'Role', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>