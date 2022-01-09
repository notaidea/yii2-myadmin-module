<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model yii\Rbac\Rule */

$this->title = 'Create Rule';
$this->params['breadcrumbs'][] = ['label' => 'Rule', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rule-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>