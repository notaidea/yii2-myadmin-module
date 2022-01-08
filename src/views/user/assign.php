<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
/* @var $roles array */
/* @var $selectRoles array */

$this->title = "user-assign";
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="user-assign-form">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
        ],
    ]) ?>

    <?php $form = ActiveForm::begin(); ?>
        <?php echo Html::hiddenInput("id", $model->id); ?>

        <?php foreach ($roles as $k => $v): ?>
            <?php
                $checked = false;
                if (in_array($v->name, $selectRoles)) {
                    $checked = true;
                }
            ?>
            <?php echo Html::checkbox("roles[]", $checked, ["value" => $v->name]); ?>
            <?php echo $v->name; ?>
            <br>
        <?php endforeach; ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
